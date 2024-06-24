<?php
    session_start();
    require_once 'global.php';

    if (!isset($_SESSION['User'])) {
        header("Location: login.php");
        exit();
    }

    if(isset($_SESSION['Sucess'])){
        echo $_SESSION['Sucess'];
        unset($_SESSION['Sucess']);
    }

    if(isset($_SESSION['TryAgain'])){
        echo $_SESSION['TryAgain'];
        unset($_SESSION['TryAgain']);
    }
    try {
        // Ficha dos monstros
        $Monster = new Monster();
        $ListaMonster = $Monster->listar();
    } catch (Exception $e) {
        echo '<pre>';
            print_r($e);
        echo '</pre>';
        echo $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Odyssey</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg custom-navbar fixed-top">
            <a class="navbar-brand custom-navbar-brand" href="dashboard.php">
                RPG Odyssey
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="minhas_mesas.php">Mesas</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="meus_personagens.php">Personagens</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="#monstros">Monstros</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="php/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <br>
        <h1 class="section-title"><?php echo $_SESSION['User'];?> Odyssey</h1>

        <h2 class="section-title mt-5" id="monstros">Meus monstros
            <a href="form_monster.php" class="btn btn-primary">Criar</a>
        </h2>
        <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="img/images.png" class="card-img-top card-portrait" alt="Monster Image">
                        <div class="card-body">
                            <h5 class="card-title">Nome Monstro</h5>
                            <p class="card-text">Raça/Tipo: Nivel</p>
                            <a href="#" class="btn btn-secondary">Editar</a>
                        </div>
                    </div>
                </div>
            <?php foreach ($ListaMonster as $monster): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="<?php echo $monster['caminhoImagem']; ?>" class="card-img-top card-portrait" alt="Monster Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($monster['nomeMonster']); ?></h5>
                            <p class="card-text">Tipo: <?php echo htmlspecialchars($monster['racaMonster']);?> <?php echo htmlspecialchars($monster['nivelMonster']); ?></p>
                            <a href="form_monster.php?id=<?php echo $monster['idMonster']?>" class="btn btn-secondary">Editar</a>
                            <a href="php/crud_monster.php?action=deletar&id=<?php echo $monster['idMonster'] ?>" class="btn btn-primary">Excluir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
