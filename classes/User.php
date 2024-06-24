<?php

class User{

    private $idUser;
    private $nomeUser;
    private $emailUser;
    private $senhaUser;

    public function getIdUser(){
        return $this->idUser;
    }

    public function getNomeUser(){
        return $this->nomeUser;
    }

    public function getEmailUser(){
        return $this->emailUser;
    }

    public function getSenhaUser(){
        return $this->senhaUser;
    }


    public function setIdUser($idUser){
        $this->idUser = $idUser;
    }

    public function setNomeUser($nome){
        $this->nomeUser = $nome;
    }

    public function setEmailUser($email){
        $this->emailUser = $email;
    }

    public function setSenhaUser($senha){
        $this->senhaUser = $senha;
    }

    public function cadastrar($usuario){
        $conexao = Conexao::pegarConexao();
        
        //validação

        $nomeUsuario = $usuario->getNomeUser();
        $emailUsuario = $usuario->getEmailUser();


        $stmtL = $conexao->prepare("SELECT * FROM user WHERE nomeUser = ?");
        $stmtE = $conexao->prepare("SELECT * FROM user WHERE emailUser = ? ");

        $stmtL->bindParam(1, $nomeUsuario);
        $stmtL->execute();
        $stmtE->bindParam(1, $emailUsuario);
        $stmtE->execute();



        if($stmtL->rowCount() > 0 || $stmtE->rowCount() > 0){            
            $_SESSION['error'] = "Usuario ou Email ja existentes, por favor utilize um diferente.";
            header("Location: ../register.php");

        }else{
        //cadastro
            $stmt = $conexao->prepare("INSERT INTO user (nomeUser, emailUser, senhaUser)
                                        VALUES (?, ?, ?) ");

            $stmt->bindParam(1, $usuario->getNomeUser());
            $stmt->bindParam(2, $usuario->getEmailUser());
            $stmt->bindParam(3, $usuario->getSenhaUser());
            $stmt->execute();

            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Cadastro realizado com sucesso!');</script>";
            header("Location: ../login.php");

        }        
    }

    public function logar($login, $senha){
        $conexao = Conexao::pegarConexao();

        $stmt = $conexao->prepare("SELECT * FROM user WHERE emailUser = ? and senhaUser = ?");


        $stmt->bindParam(1, $login);
        $stmt->bindParam(2, $senha);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $dado = $stmt->fetch();

            session_start();
            $_SESSION['User'] = $dado['nomeUser'];

            return true;
        }else{
            return false;
        }
    }

}



?>