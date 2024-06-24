<?php
    session_start();
    
    require_once '../global.php';
    
    $nome = $_POST['txtName'];
    $email = $_POST['txtEmail'];
    $senha = $_POST['txtPassword'];

    if(!empty($nome) && !empty($email) && !empty($senha)){
        $usuario = new User();
        $usuario->setNomeUser($_POST['txtName']);
        $usuario->setEmailUser($_POST['txtEmail']);
        $usuario->setSenhaUser($_POST['txtPassword']);
        $usuario->cadastrar($usuario);
    }else{
        $_SESSION['error'] = "Por favor preencha todos os campos.";
        header("Location: ../register.php");
    }

?>