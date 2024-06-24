<?php
    session_start();
    
    require_once '../global.php';

    $loginEmail = $_POST['txtEmail'];
    $loginSenha = $_POST['txtPassword'];

    if(isset($loginEmail) && !empty($loginEmail) || isset($loginSenha) && !empty($loginSenha)){

        $usuario = new User();

        $login = $_POST['txtEmail'];
        $senha = $_POST['txtPassword'];

        if($usuario->logar($login, $senha) == true){
            header("Location:  ../dashboard.php");
        }else{
            $_SESSION['error'] = "Dados incorretos ou usuário inexistente.";
            header("Location: ../login.php");
        }

    }else{
        $_SESSION['error'] = "Por favor preencha todos os campos.";
        header("Location: ../login.php");
    }


?>
