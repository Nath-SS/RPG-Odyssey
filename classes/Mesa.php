<?php

class Mesa {

    private $idMesa;
    private $idUser;
    private $nomeMesa;
    private $sistemaMesa;
    private $descricaoMesa;
    private $qntdJogadores;
    private $limitePersonagem;
    private $caminhoImagem;
    private $nomeImagem;

    public function getIdMesa(){
        return $this->idMesa;
    }

    public function getIdUser(){
        return $this->idUser;
    }

    public function getNomeMesa(){
        return $this->nomeMesa;
    }

    public function getSistemaMesa(){
        return $this->sistemaMesa;
    }

    public function getDescricaoMesa(){
        return $this->descricaoMesa;
    }

    public function getQntdJogadores(){
        return $this->qntdJogadores;
    }

    public function getLimitePersonagem(){
        return $this->limitePersonagem;
    }

    public function getCaminhoImagem(){
        return $this->caminhoImagem;
    }

    public function getNomeImagem(){
        return $this->nomeImagem;
    }


    public function setIdMesa($idMesa){
        $this->idMesa = $idMesa;
    }

    public function setIdUser($idUser){
        $this->idUser = $idUser;
    }

    public function setNomeMesa($nomeMesa){
        $this->nomeMesa = $nomeMesa;
    }

    public function setSistemaMesa($sistemaMesa){
        $this->sistemaMesa = $sistemaMesa;
    }

    public function setDescricaoMesa($descricaoMesa){
        $this->descricaoMesa = $descricaoMesa;
    }

    public function setQntdJogadores($qntdJogadores){
        $this->qntdJogadores = $qntdJogadores;
    }

    public function setLimitePersonagem($limitePersonagem){
        $this->limitePersonagem = $limitePersonagem;
    }

    public function setCaminhoImagem($caminhoImagem){
        $this->caminhoImagem = $caminhoImagem;
    }

    public function setNomeImagem($nomeImagem){
        $this->nomeImagem = $nomeImagem;
    }

    public function criar($mesa){
        $conexao = Conexao::pegarConexao();

        //Pegar id do usuário
        $stmtU = $conexao->query("SELECT idUser FROM user WHERE nomeUser = '" . $_SESSION['User'] . "'");
        $resultado = $stmtU->fetch();
        $mesa->setIdUser($resultado['idUser']);

        //criação da mesa no banco de dados
        $stmt = $conexao->prepare
        (" INSERT INTO mesa(idUser, nomeMesa, sistemaMesa, descricaoMesa, qntdJogadores, limitePersonagem, caminhoImagem, nomeImagem)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");

        $stmt->bindValue(1, $mesa->getIdUser());
        $stmt->bindValue(2, $mesa->getNomeMesa());
        $stmt->bindValue(3, $mesa->getSistemaMesa());
        $stmt->bindValue(4, $mesa->getDescricaoMesa());
        $stmt->bindValue(5, $mesa->getQntdJogadores());
        $stmt->bindValue(6, $mesa->getLimitePersonagem());
        $stmt->bindValue(7, $mesa->getCaminhoImagem());
        $stmt->bindValue(8, $mesa->getNomeImagem());

        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Mesa criada com sucesso!');</script>";
            header('Location: ../minhas_mesas.php');
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao criar mesa, tente novamente.');</script>";
        }
    }

    public function deletar($idMesa){
        $conexao = Conexao::pegarConexao();

        $stmt = $conexao->prepare("DELETE FROM mesa WHERE idMesa = ?");
        $stmt->bindValue(1, $idMesa);
        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Mesa excluida com sucesso!');</script>";
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao excluir mesa, tente novamente.');</script>";
        }
        header('Location: ../minhas_mesas.php');
    }

    public function atualizar($mesa){
        $conexao = Conexao::pegarConexao();

        //Pegar id do usuário
        $stmtU = $conexao->query("SELECT idUser FROM user WHERE nomeUser = '" . $_SESSION['User'] . "'");
        $resultado = $stmtU->fetch();
        $mesa->setIdUser($resultado['idUser']);

        //Atualizar ficha
        $stmt = $conexao->prepare("UPDATE mesa
                                    SET nomeMesa = ?,
                                        sistemaMesa = ?,
                                        descricaoMesa = ?,
                                        qntdJogadores = ?,
                                        limitePersonagem = ?,
                                        caminhoImagem = ?,
                                        nomeImagem = ?
                                     WHERE idUser = ? && idMesa = ?");

        $stmt->bindValue(1, $mesa->getNomeMesa());
        $stmt->bindValue(2, $mesa->getSistemaMesa());
        $stmt->bindValue(3, $mesa->getDescricaoMesa());
        $stmt->bindValue(4, $mesa->getQntdJogadores());
        $stmt->bindValue(5, $mesa->getLimitePersonagem());
        $stmt->bindValue(6, $mesa->getCaminhoImagem());
        $stmt->bindValue(7, $mesa->getNomeImagem());
        $stmt->bindValue(8, $mesa->getIdUser());
        $stmt->bindValue(9, $mesa->getIdMesa());


        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Mesa atualizada com sucesso!');</script>";
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao atualizar a mesa, tente novamente.');</script>";
        }
        
        header('Location: ../minhas_mesas.php');
    }

    public function listar(){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT nomeUser, idMesa, nomeMesa, sistemaMesa, qntdJogadores, caminhoImagem
                        FROM mesa
                         INNER JOIN user ON mesa.idUser = user.idUser
                            WHERE nomeUser != '" . $_SESSION['User'] . "'";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;
    }

    public function listarMeu(){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT nomeUser, idMesa, nomeMesa, sistemaMesa, qntdJogadores, caminhoImagem
                        FROM mesa
                         INNER JOIN user ON mesa.idUser = user.idUser
                            WHERE nomeUser = '" . $_SESSION['User'] . "'";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;
    }

    public function detalhar($idMesa){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT nomeUser, idMesa, nomeMesa, sistemaMesa, descricaoMesa, qntdJogadores, limitePersonagem, caminhoImagem, nomeImagem
                        FROM mesa
                         INNER JOIN user ON mesa.idUser = user.idUser
                            WHERE idMesa = :idMesa ";
        $stmt = $conexao->prepare($querySelect);
        $stmt->bindParam(':idMesa', $idMesa, PDO::PARAM_INT);
        $stmt->execute();
        $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);
        return $detalhes;
    }
}

?>