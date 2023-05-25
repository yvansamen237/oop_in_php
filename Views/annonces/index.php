<p>Liste des annonces</p>


<?php foreach($annonces as $annonce): ?>
<article>
    <h3><a href="/annonces/lire/<?= $annonce->id ?>"><?= $annonce->titre; ?></a></h3>
    <p><?= $annonce->description ?></p>
</article>
<?php endforeach; ?>