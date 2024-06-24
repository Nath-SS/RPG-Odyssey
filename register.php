<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <div class="container">
        <h1>Registrar</h1>
        <form method="POST" action="php/cadastrar.php">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="txtName">
            <label for="email">Email:</label>
            <input type="email" id="email" name="txtEmail">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="txtPassword">
            <button type="submit">Registrar</button>
        </form>
        <p>Já tem uma conta? <a href="login.php">Login</a></p>
        <?php
            if (isset($_SESSION['error'])){
                $error = $_SESSION['error'];
                echo "<p>$error</p>";
                session_destroy();
            }  
        ?>
    </div>
</body>
</html>
