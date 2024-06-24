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
        // Mesas
        $Mesa = new Mesa();
        $ListaMesa = $Mesa->listarMeu();

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
                        <a class="btn btn-secondary" href="#mesas">Mesas</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="meus_personagens.php">Personagens</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="meus_monstros.php">Monstros</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="php/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <br>
        <h1 class="section-title"><?php echo $_SESSION['User'];?> Odyssey</h1>

        <h2 class="section-title mt-5" id="mesas">Minhas mesas
            <a href="form_mesa.php" class="btn btn-primary">Criar</a>
        </h2>
        <div class="row">
                <div class="col-md-4 mb-4">
                    <a href="#" class="card-link">
                        <div class="card bg-dark text-white">
                            <img src="img/b6c.jpg" class="card-img card-mesa" alt="Mesa Image">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Titulo</h5>
                                <h6 class="card-subtitle mb-2">Sistema</h6>
                                <h6 class="card-subtitle mb-2">Jogadores: 4</h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php foreach ($ListaMesa as $mesa): ?>
                <div class="col-md-4 mb-4">
                    <a href="#" onclick="showActionModal(<?php echo $mesa['idMesa'];?>)" class="card-link">
                        <div class="card bg-dark text-white">
                            <img src="<?php echo $mesa['caminhoImagem']; ?>" class="card-img card-mesa" alt="Mesa Image">
                            <div class="card-img-overlay    ">
                                <h5 class="card-title"><?php echo htmlspecialchars($mesa['nomeMesa']); ?></h5>
                                <h6 class="card-subtitle mb-2"><?php echo htmlspecialchars($mesa['sistemaMesa']); ?></h6>
                                <h6 class="card-subtitle mb-2">Jogadores: <?php echo $mesa['qntdJogadores']; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">Escolha uma Ação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>O que você gostaria de fazer?</p>
                    <a href="#" id="editLink" class="btn btn-secondary">Editar</a>
                    <a href="#" id="deleteLink" class="btn btn-primary">Excluir</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showActionModal(id) {
            // Set the href attribute for edit and delete links
            document.getElementById('editLink').href = 'form_mesa.php?id=' + id;
            document.getElementById('deleteLink').href = 'php/crud_mesa.php?action=deletar&id=' + id;

            // Show the modal
            $('#actionModal').modal('show');
        }
    </script>
</body>
</html>
