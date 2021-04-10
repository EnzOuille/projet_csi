<?php
class Lot extends Model{

    public function __construct()
    {
        // Nous ouvrons la connexion à la base de données
        $this->getConnection();
    }

    /**
     * Retourne un lot en fonction de son id
     *
     * @param string $id
     * @return void
     */
    public function findById(int $id){
        $sql = "SELECT * FROM Lot WHERE idLot=".$id.";";
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);    
    }

}