<?php session_start();  ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <?php
        if(isset($_SESSION['Sucess'])){
            echo($_SESSION['Sucess']);
            session_destroy();
        }
    ?>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="php/logar.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="txtEmail">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="txtPassword">
            <button type="submit">Login</button>
        </form>
        <p>Não tem uma conta? <a href="register.php">Registre-se</a></p>
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
