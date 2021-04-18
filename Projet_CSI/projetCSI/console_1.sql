DROP TABLE IF EXISTS PropositionAchat;
DROP TABLE IF EXISTS Vente;
DROP TABLE IF EXISTS AppartientA;
DROP TABLE IF EXISTS Lot;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Produit;

-- Table Produit
CREATE TABLE Produit (
                         idProduit serial primary key,
                         description char(50) not null,
                         type char(50) not null
);

--Table Lot
CREATE TABLE Lot(
                    idLot serial primary key,
                    description char(200) not null,
                    prixEstime numeric(10, 2) not null,
                    prixMinimal numeric(10, 2) not null CHECK ( prixMinimal < prixEstime),
                    dateDebut date not null CHECK ( dateDebut < dateFin),
                    dateFin date not null,
                    etat char(50)  default 'en vente' CHECK ( etat in('en vente','vendu','echec','en attente') ),
                    nbReventes integer  default 0 CHECK ( nbReventes <= 2 ) not null,
                    dateAttente date CHECK (current_date - dateAttente < 1)
    -- Si revente A FAIRE DANS UNE FONCTION
    -- dateAttente A FAIRE DANS UNE FONCTION QUAND ON FAIT UNE VENTE
);

--Table Client
CREATE TABLE Client(
                       idClient serial primary key,
                       prenom char(50) not null,
                       nom char(50) not null,
                       email char(50) not null,
                       solde numeric(10, 2) not null CHECK (solde > 0),
                       dateInscription date not null CHECK (dateInscription <= current_date)
);

-- Table Vente
CREATE TABLE Vente (
                       idVente serial primary key,
                       montant numeric(10, 2) not null CHECK (montant > 0),
                       benefice numeric(10, 2) not null CHECK (benefice >= 0),
                       idLot serial REFERENCES Lot(idLot),
                       idClient serial REFERENCES Client(idClient)
);

-- Table Proposition Achat
CREATE TABLE PropositionAchat(
                                 idProposition serial primary key,
                                 montant numeric(10, 2) not null CHECK ( montant > 0 ),
    -- MontantSuivant > MontantPrécédent A FAIRE DANS UN TRIGGERS LORS DE LA MODIFICATION
                                 nbModifs integer not null CHECK ( nbModifs <= 2 ),
    -- dateProposition < dateFin du lot
                                 dateProposition date not null,
                                 etatPropal char(50) CHECK (etatPropal in('en attente','en validation','acceptée','rejetee')),
                                 idClient serial REFERENCES Client(idClient),
                                 idLot serial REFERENCES Lot(idLot),
                                 dateValidation date
);
-- Table Appartient A
CREATE TABLE AppartientA (
                             idProduit serial REFERENCES Produit(idProduit),
                             idLot serial not null REFERENCES Lot(idLot),
                             quantite numeric(5, 0) not null CHECK (quantite >= 1),
                             primary key (idProduit, idLot)
);


/*
 Contraintes Proposition Achat
 */

--Trigger pour l'insertion d'une proposition pour en avoir qu'une seule sur un lot
CREATE OR REPLACE FUNCTION trigger_insert_propAchat() RETURNS TRIGGER AS $trigger_insert_propAchat$
DECLARE
nbProp int;
    solde numeric(10,2);
BEGIN
SELECT INTO nbProp Count(Client.idClient) FROM Client INNER JOIN PropositionAchat PA on Client.idClient = PA.idClient
WHERE Client.idClient = NEW.idClient AND PA.idLot = NEW.idLot;
SELECT INTO solde Client.solde FROM Client where idclient = NEW.idClient;
if nbProp > 0 then
        RAISE EXCEPTION 'Le client a déjà fait une proposition sur ce lot';
end if;
    if solde < NEW.montant then
        RAISE EXCEPTION 'Le client n''a pas assez de solde pour faire cette proposition';
end if;
return NEW;
end
$trigger_insert_propAchat$
LANGUAGE plpgsql;

CREATE TRIGGER trigger_insert_propAchat BEFORE INSERT ON PropositionAchat
    FOR EACH ROW EXECUTE PROCEDURE trigger_insert_propAchat();
--Fin Trigger

CREATE OR REPLACE FUNCTION trigger_update_propAchat() RETURNS TRIGGER AS $trigger_update_propAchat$
DECLARE
nbmod int;
    etat char(50);
    etatLot char(50);
    dateAtt date;
    res text;
BEGIN
SELECT INTO nbmod OLD.nbModifs FROM PropositionAchat WHERE OLD.idProposition = NEW.idProposition;
SELECT into etat PropositionAchat.etatPropal FROM PropositionAchat WHERE idProposition = NEW.idProposition;
SELECT into etatLot Lot.etat FROM Lot INNER JOIN PropositionAchat PA on Lot.idLot = PA.idLot WHERE Lot.idLot = NEW.idLot;
SELECT into dateAtt dateAttente FROM Lot INNER JOIN PropositionAchat PA on Lot.idLot = PA.idLot WHERE Lot.idLot = NEW.idLot;
if nbmod >= 2 then
        RAISE EXCEPTION 'Déjà deux modifications de faites';
end if;
    if NEW.montant < OLD.montant then
        RAISE EXCEPTION 'Le nouveau montant doit être supérieur à l''ancien';
end if;
    if NEW.montant > OLD.montant then
        NEW.nbModifs = OLD.nbModifs + 1;
end if;
    if etat = 'en validation' AND etatLot = 'en attente' then
        if dateAtt - NEW.dateValidation < 1 AND dateAtt - NEW.dateValidation > - 1 then
            perform creer_vente(NEW.idlot,NEW.idProposition);
UPDATE Lot SET etat = 'vendu' WHERE idLot = NEW.idLot;
NEW.etatPropal = 'acceptée';
            --UPDATE PropositionAchat SET etatPropal = 'refusee' WHERE idLot = NEW.idLot;
update lot set dateattente = current_date where idlot = new.idLot;
else
            NEW.etatPropal = 'rejetee';
end if;
end if;
return NEW;
end
$trigger_update_propAchat$
LANGUAGE plpgsql;

SELECT (dateAttente - '2021-04-19') FROM Lot;

CREATE TRIGGER trigger_update_propAchat BEFORE UPDATE ON PropositionAchat
    FOR EACH ROW EXECUTE PROCEDURE trigger_update_propAchat();

CREATE OR REPLACE function modify_props(param_idLot int) returns void as $$
declare
id_prop int;
begin
SELECT into id_prop idproposition FROM PropositionAchat inner join Lot L on PropositionAchat.idLot = L.idLot inner join vente v on L.idLot = v.idlot
WHERE PropositionAchat.idClient = v.idClient AND PropositionAchat.idLot = V.idLot;
UPDATE PropositionAchat SET etatpropal = 'rejetee' WHERE id_prop != idproposition AND idLot = param_idLot;
end
$$
language plpgsql;

CREATE OR REPLACE function delete_props(param_idLot int) returns void as $$
begin
DELETE FROM PropositionAchat WHERE idLot = param_idLot;
end;
$$
language plpgsql;

/*
 Contraintes pour Lot
 */


CREATE OR REPLACE FUNCTION generer_revente(param_idlot integer) RETURNS text AS $$
DECLARE
res text;
    nbrev int;
BEGIN
select into nbrev nbreventes from lot where idlot = param_idlot;
if nbrev >= 2 then
        res = 'Le lot a déjà été remis en vente deux fois, passage en mode echec et suppression des proposition associées';
        perform delete_props(param_idlot);
else
UPDATE Lot SET dateAttente = null, dateFin = dateFin + 7, nbReventes = nbReventes + 1, prixMinimal = prixMinimal - 0.1 * prixMinimal, etat = 'en vente' WHERE idLot = param_idlot;
perform delete_props(param_idlot);
        res = 'Le lot a bien été remis en vente';
end if;
return res;
end
$$
LANGUAGE plpgsql;

/**CREATE OR REPLACE FUNCTION trigger_update_date() RETURNS TRIGGER AS $trigger_update_date$
DECLARE
    etat char(50);
    etatLot char(50);
    dateAtt date;
    res char(50);
BEGIN
    SELECT into etat PropositionAchat.etatPropal FROM PropositionAchat WHERE idProposition = NEW.idProposition;
    SELECT into etatLot Lot.etat FROM Lot INNER JOIN PropositionAchat PA on Lot.idLot = PA.idLot WHERE Lot.idLot = NEW.idLot;
    SELECT into dateAtt dateAttente FROM Lot INNER JOIN PropositionAchat PA on Lot.idLot = PA.idLot WHERE Lot.idLot = NEW.idLot;
    if etat = 'en validation' AND etatLot = 'en attente' then
        if NEW.dateValidation - dateAtt < 1 AND NEW.dateValidation - dateAtt >= 0 then
            select into res creer_vente(NEW.idlot,NEW.idProposition);
            UPDATE Lot SET etat = 'vendu' WHERE idLot = NEW.idLot;
            NEW.etatPropal = 'acceptée';
            ALTER TABLE PropositionAchat DISABLE TRIGGER trigger_update_propAchat;
            ALTER TABLE PropositionAchat DISABLE TRIGGER trigger_update_date;
            SET session_replication_role = replica;
            UPDATE PropositionAchat SET etatPropal = 'refusee' WHERE idLot = NEW.idLot;
            ALTER TABLE PropositionAchat ENABLE TRIGGER trigger_update_propAchat;
            ALTER TABLE PropositionAchat ENABLE TRIGGER trigger_update_date;
            SET session_replication_role = DEFAULT;
            update lot set dateattente = current_date where idlot = new.idLot;
        else
            update propositionachat set etatPropal = 'refusee' where idproposition = new.idProposition;
        end if;
    end if;
    return new;
end;
$trigger_update_date$
language plpgsql;**/
SELECT idProposition FROM PropositionAchat
Where montant = (SELECT Max(montant) FROM PropositionAchat where idlot = 1 AND etatPropal !='rejetee') AND idLot = 1 AND etatPropal != 'rejetee';

create or replace function deuxieme_propal(param_idlot int) returns text as $$
declare
idprop int;
    res text;
begin
SELECT INTO idProp idProposition FROM PropositionAchat
Where montant = (SELECT Max(montant) FROM PropositionAchat where idlot = param_idlot AND etatPropal !='rejetee') AND idLot = param_idlot AND etatPropal != 'rejetee';
if idprop is null then
        res = 'Aucun proposition valide, lot remis en vente';
        perform generer_revente(param_idlot);
else
update propositionachat set etatPropal = 'en validation' where idproposition = idprop;
end if;
return 'tout bon';
end;
$$
language plpgsql;
/**CREATE TRIGGER trigger_update_date BEFORE UPDATE ON PropositionAchat
    FOR EACH ROW EXECUTE PROCEDURE trigger_update_date();**/

CREATE OR REPLACE PROCEDURE debut_vendre_lot(param_idlot integer) AS $$
DECLARE
idProp int;
BEGIN
SELECT INTO idProp idProposition FROM PropositionAchat
Where montant = (SELECT Max(montant) FROM PropositionAchat) AND idLot = param_idlot;
if idProp IS NOT NULL then
UPDATE Lot SET dateAttente = current_date, etat = 'en attente' WHERE idLot = param_idlot;
UPDATE PropositionAchat SET etatPropal = 'en validation' WHERE idProposition = idProp;
else
        RAISE EXCEPTION 'Aucune Proposition d achat pour ce lot';
end if;
end
$$
language plpgsql;

--Supprimer un lot
CREATE OR REPLACE FUNCTION supprimer_lot(param_idlot int) returns void as $$
begin
DELETE FROM AppartientA WHERE idLot = param_idlot;
perform delete_props(param_idlot);
DELETE FROM Lot WHERE idLot = param_idlot;
end;
$$
language plpgsql;
/*
 Contraintes pour Client
 */
CREATE or replace function trigger_modif_solde() returns trigger as $trigger_modif_solde$
begin
    if NEW.solde < OLD.solde then
        raise exception 'Le nouveau solde doit être supérieur au précédent';
end if;
end;
$trigger_modif_solde$
language plpgsql;

create trigger trigger_modif_solde before update on client
    for each row execute procedure trigger_modif_solde();
/*
 Contraintes pour Vente
 */

create or replace function creer_vente(param_idlot int, param_idprop int) returns text as $$
declare
benef numeric(10,2);
    montant_prop numeric(10,2);
    param_idclient int;
begin
SELECT INTO benef sum(0.02 * montant) FROM propositionachat
WHERE param_idprop != idProposition and param_idlot = idLot
group by idLot;
select into montant_prop montant * 0.05 from propositionachat where param_idlot = idLot and param_idprop = idProposition;
select into param_idclient idclient from propositionachat where param_idprop = idProposition;
if benef is null then
        benef = 0;
end if;
    benef = benef + montant_prop;
INSERT INTO Vente(montant,benefice,idlot,idclient) VALUES (montant_prop,benef,param_idlot,param_idclient);
UPDATE Client set solde = solde - montant_prop where idclient = param_idclient;
return 'vente bien generee';
end
$$
language plpgsql;

