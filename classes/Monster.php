<?php

class Monster{

    private $idMonster;
    private $idUser;
    private $nomeMonster;
    private $racaMonster;
    private $nivelMonster;
    private $descricaoMonster;
    private $habilidadesMonster;
    private $caminhoImagem;
    private $nomeImagem;

    public function getIdMonster(){
        return $this->idMonster;
    }

    public function getIdUser(){
        return $this->idUser;
    }

    public function getNomeMonster(){
        return $this->nomeMonster;
    }

    public function getRacaMonster(){
        return $this->racaMonster;
    }

    public function getNivelMonster(){
        return $this->nivelMonster;
    }

    public function getDescricaoMonster(){
        return $this->descricaoMonster;
    }

    public function getHabilidadesMonster(){
        return $this->habilidadesMonster;
    }

    public function getCaminhoImagem(){
        return $this->caminhoImagem;
    }

    public function getNomeImagem(){
        return $this->nomeImagem;
    }


    public function setIdMonster($idMonster){
        $this->idMonster = $idMonster;
    }

    public function setIdUser($idUser){
        $this->idUser = $idUser;
    }

    public function setNomeMonster($nomeMonster){
        $this->nomeMonster = $nomeMonster;
    }

    public function setRacaMonster($racaMonster){
        $this->racaMonster = $racaMonster;
    }

    public function setNivelMonster($nivelMonster){
        $this->nivelMonster = $nivelMonster;
    }

    public function setDescricaoMonster($descricaoMonster){
        $this->descricaoMonster = $descricaoMonster;
    }

    public function setHabilidadesMonster($habilidadesMonster){
        $this->habilidadesMonster = $habilidadesMonster;
    }

    public function setCaminhoImagem($caminho){
        $this->caminhoImagem = $caminho;
    }
    
    public function setNomeImagem($nome){
        $this->nomeImagem = $nome;
    }

    public function criar($monster){
        $conexao = Conexao::pegarConexao();

        //Pegar id do usuário
        $stmtU = $conexao->query("SELECT idUser FROM user WHERE nomeUser = '" . $_SESSION['User'] . "'");
        $resultado = $stmtU->fetch();
        $monster->setIdUser($resultado['idUser']);

        //criação da ficha no banco de dados
        $stmt = $conexao->prepare
        (" INSERT INTO monster(idUser, nomeMonster, racaMonster, nivelMonster, descricaoMonster, habilidadesMonster, caminhoImagem, nomeImagem)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");

        $stmt->bindValue(1, $monster->getIdUser());
        $stmt->bindValue(2, $monster->getNomeMonster());
        $stmt->bindValue(3, $monster->getRacaMonster());
        $stmt->bindValue(4, $monster->getNivelMonster());
        $stmt->bindValue(5, $monster->getDescricaoMonster());
        $stmt->bindValue(6, $monster->getHabilidadesMonster());
        $stmt->bindValue(7, $monster->getCaminhoImagem());
        $stmt->bindValue(8, $monster->getNomeImagem());

        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Ficha criada com sucesso!');</script>";
            header('Location: ../meus_monstros.php');
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao criar ficha, tente novamente.');</script>";
        }
    }

    public function deletar($idMonster){
        $conexao = Conexao::pegarConexao();

        $stmt = $conexao->prepare("DELETE FROM monster WHERE idMonster = ?");
        $stmt->bindValue(1, $idMonster);
        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Ficha excluida com sucesso!');</script>";
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao excluir ficha, tente novamente.');</script>";
        }
        header('Location: ../meus_monstros.php');
    }

    public function atualizar($monster){
        $conexao = Conexao::pegarConexao();

        //Pegar id do usuário
        $stmtU = $conexao->query("SELECT idUser FROM user WHERE nomeUser = '" . $_SESSION['User'] . "'");
        $resultado = $stmtU->fetch();
        $monster->setIdUser($resultado['idUser']);

        //Atualizar ficha
        $stmt = $conexao->prepare("UPDATE monster
                                    SET nomeMonster = ?,
                                        racaMonster = ?,
                                        nivelMonster = ?,
                                        descricaoMonster = ?,
                                        habilidadesMonster = ?,
                                        caminhoImagem = ?,
                                        nomeImagem = ?
                                     WHERE idUser = ? && idMonster = ?");

        $stmt->bindValue(1, $monster->getNomeMonster());
        $stmt->bindValue(2, $monster->getRacaMonster());
        $stmt->bindValue(3, $monster->getNivelMonster());
        $stmt->bindValue(4, $monster->getDescricaoMonster());
        $stmt->bindValue(5, $monster->getHabilidadesMonster());
        $stmt->bindValue(6, $monster->getCaminhoImagem());
        $stmt->bindValue(7, $monster->getNomeImagem());
        $stmt->bindValue(8, $monster->getIdUser());
        $stmt->bindValue(9, $monster->getIdMonster());

        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Ficha atualizada com sucesso!');</script>";
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao atualizar a ficha, tente novamente.');</script>";
        }
        
        header('Location: ../meus_monstros.php');
    }

    public function listar(){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT nomeUser, idMonster, nomeMonster, racaMonster, nivelMonster, caminhoImagem
                        FROM monster
                         INNER JOIN user ON monster.idUser = user.idUser
                            WHERE nomeUser = '" . $_SESSION['User'] . "'";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;
    }

    public function detalhar($idMonster){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT idMonster, nomeMonster, racaMonster, nivelMonster, descricaoMonster, habilidadesMonster, caminhoImagem
                        FROM monster
                        WHERE idMonster = :idMonster";
        $stmt = $conexao->prepare($querySelect);
        $stmt->bindParam(':idMonster', $idMonster, PDO::PARAM_INT);
        $stmt->execute();
        $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);
        return $detalhes;
    }
}



?>