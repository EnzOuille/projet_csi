<?php foreach($lots as $lot): ?>

<h2><a href="/lots/lire/<?= $lot['id'] ?>"></a></h2>

<p><?= $lot['id'].  $lot['description']?></p>

<?php endforeach ?>