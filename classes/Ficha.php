<?php

class Ficha{

    private $idFicha;
    private $idUser;
    private $nomePersonagem;
    private $classe_profissao;
    private $nivelPersonagem;
    private $racaPersonagem;
    private $descricaoPersonagem;
    private $habilidadesPersonagem;
    private $caminhoImagem;
    private $nomeImagem;

    public function getIdFicha() {
        return $this->idFicha;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    public function getNomePersonagem() {
        return $this->nomePersonagem;
    }

    public function getClasseProfissao() {
        return $this->classe_profissao;
    }

    public function getNivelPersonagem() {
        return $this->nivelPersonagem;
    }

    public function getRacaPersonagem() {
        return $this->racaPersonagem;
    }

    public function getDescricaoPersonagem() {
        return $this->descricaoPersonagem;
    }

    public function getHabilidadesPersonagem() {
        return $this->habilidadesPersonagem;
    }

    public function getCaminhoImagem(){
        return $this->caminhoImagem;
    }

    public function getNomeImagem(){
        return $this->nomeImagem;
    }


    public function setIdFicha($idFicha) {
        $this->idFicha = $idFicha;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    public function setNomePersonagem($nomePersonagem) {
        $this->nomePersonagem = $nomePersonagem;
    }

    public function setClasseProfissao($classe_profissao) {
        $this->classe_profissao = $classe_profissao;
    }

    public function setNivelPersonagem($nivelPersonagem) {
        $this->nivelPersonagem = $nivelPersonagem;
    }

    public function setRacaPersonagem($racaPersonagem) {
        $this->racaPersonagem = $racaPersonagem;
    }

    public function setDescricaoPersonagem($descricaoPersonagem) {
        $this->descricaoPersonagem = $descricaoPersonagem;
    }

    public function setHabilidadesPersonagem($habilidadesPersonagem) {
        $this->habilidadesPersonagem = $habilidadesPersonagem;
    }

    public function setCaminhoImagem($caminho){
        $this->caminhoImagem = $caminho;
    }
    
    public function setNomeImagem($nome){
        $this->nomeImagem = $nome;
    }

    public function criar($ficha){
        $conexao = Conexao::pegarConexao();

        //Pegar id do usuário
        $stmtU = $conexao->query("SELECT idUser FROM user WHERE nomeUser = '" . $_SESSION['User'] . "'");
        $resultado = $stmtU->fetch();
        $ficha->setIdUser($resultado['idUser']);

        //criação da ficha no banco de dados
        $stmt = $conexao->prepare
        (" INSERT INTO ficha(idUser, nomePersonagem, classe_profissao, nivelPersonagem, racaPersonagem, descricaoPersonagem, habilidadesPersonagem, caminhoImagem, nomeImagem)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ");

        $stmt->bindValue(1, $ficha->getIdUser());
        $stmt->bindValue(2, $ficha->getNomePersonagem());
        $stmt->bindValue(3, $ficha->getClasseProfissao());
        $stmt->bindValue(4, $ficha->getNivelPersonagem());
        $stmt->bindValue(5, $ficha->getRacaPersonagem());
        $stmt->bindValue(6, $ficha->getDescricaoPersonagem());
        $stmt->bindValue(7, $ficha->getHabilidadesPersonagem());
        $stmt->bindValue(8, $ficha->getCaminhoImagem());
        $stmt->bindValue(9, $ficha->getNomeImagem());

        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Ficha criada com sucesso!');</script>";
            header('Location: ../meus_personagens.php');
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao criar ficha, tente novamente.');</script>";
        }
    }

    public function deletar($idFicha){
        $conexao = Conexao::pegarConexao();

        $stmt = $conexao->prepare("DELETE FROM ficha WHERE idFicha = ?");
        $stmt->bindValue(1, $idFicha);
        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Ficha excluida com sucesso!');</script>";
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao excluir ficha, tente novamente.');</script>";
        }
        header('Location: ../meus_personagens.php');
    }

    public function atualizar($ficha){
        $conexao = Conexao::pegarConexao();

        //Pegar id do usuário
        $stmtU = $conexao->query("SELECT idUser FROM user WHERE nomeUser = '" . $_SESSION['User'] . "'");
        $resultado = $stmtU->fetch();
        $ficha->setIdUser($resultado['idUser']);

        //Atualizar ficha
        $stmt = $conexao->prepare("UPDATE ficha
                                    SET nomePersonagem = ?,
                                        classe_profissao = ?,
                                        nivelPersonagem = ?,
                                        racaPersonagem = ?,
                                        descricaoPersonagem = ?,
                                        habilidadesPersonagem = ?,
                                        caminhoImagem = ?,
                                        nomeImagem = ?
                                     WHERE idUser = ? && idFicha = ?");

        $stmt->bindValue(1, $ficha->getNomePersonagem());
        $stmt->bindValue(2, $ficha->getClasseProfissao());
        $stmt->bindValue(3, $ficha->getNivelPersonagem());
        $stmt->bindValue(4, $ficha->getRacaPersonagem());
        $stmt->bindValue(5, $ficha->getDescricaoPersonagem());
        $stmt->bindValue(6, $ficha->getHabilidadesPersonagem());
        $stmt->bindValue(7, $ficha->getCaminhoImagem());
        $stmt->bindValue(8, $ficha->getNomeImagem());
        $stmt->bindValue(9, $ficha->getIdUser());
        $stmt->bindValue(10, $ficha->getIdFicha());
        $stmt->execute();

        if ($stmt->execute()) {
            $_SESSION['Sucess'] = "<script type='text/javascript'>alert('Ficha atualizada com sucesso!');</script>";
        } else {
            $_SESSION['TryAgain'] = "<script type='text/javascript'>alert('Falha ao atualizar a ficha, tente novamente.');</script>";
        }

        header('Location: ../meus_personagens.php');
    }

    public function listar(){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT nomeUser, idFicha, nomePersonagem, classe_profissao, nivelPersonagem, caminhoImagem
                        FROM ficha
                         INNER JOIN user ON ficha.idUser = user.idUser
                            WHERE nomeUser = '" . $_SESSION['User'] . "'";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;
    }

    public function detalhar($idFicha) {
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT idFicha, nomePersonagem, classe_profissao, nivelPersonagem, racaPersonagem, descricaoPersonagem, habilidadesPersonagem, caminhoImagem
                        FROM ficha
                        WHERE idFicha = :idFicha";
        $stmt = $conexao->prepare($querySelect);
        $stmt->bindParam(':idFicha', $idFicha, PDO::PARAM_INT);
        $stmt->execute();
        $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);
        return $detalhes;
    }
    
}
