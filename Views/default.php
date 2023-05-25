<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Mes Annonces</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Acceuil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/annonces">Liste des annonces</a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/users/profil">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users/logout">Deconnexion</a>
                </li>
                <?php else : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="/users/login">Connexion</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $contenu ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
</body>

</html>