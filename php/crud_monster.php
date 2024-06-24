<?php
    session_start();

    require_once '../global.php';

    $acao = $_GET['action'];

    if($acao == 'editar'){
        //preparando variaveis
        $idMonster = $_GET['id'];
        $imagem = $_FILES['imageUpload'];
        $nomeImagem = $imagem['name'];
        $arquivo = $imagem['tmp_name'];

        //setando atributos
        $monster = new Monster();
        $monster->setIdMonster($idMonster);
        $monster->setNomeMonster($_POST['txtNome']);
        $monster->setRacaMonster($_POST['txtRaca']);
        $monster->setNivelMonster($_POST['txtNivel']);
        $monster->setDescricaoMonster($_POST['txtDescricao']);
        $monster->setHabilidadesMonster($_POST['txtHabilidades']);

        if(!empty($nomeImagem)){
            //recebendo imagem
            $monster->setNomeImagem($nomeImagem);
            $monster->setCaminhoImagem('img/');
            move_uploaded_file($arquivo, '../' . $monster->getCaminhoImagem() . $monster->getNomeImagem());
            $monster->setCaminhoImagem($monster->getCaminhoImagem() . $monster->getNomeImagem());
        } else {
            // Manter imagem existente
            $conexao = Conexao::pegarConexao();
            $stmt = $conexao->prepare("SELECT caminhoImagem, nomeImagem FROM monster WHERE idMonster = ?");
            $stmt->bindValue(1, $idMonster);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $monster->setCaminhoImagem($result['caminhoImagem']);
            $monster->setNomeImagem($result['nomeImagem']);
        }
        //atualizando
        $monster->atualizar($monster);


    }else if($acao == 'criar'){
        //preparando variaveis
        $imagem = $_FILES['imageUpload'];
        $nomeImagem = $imagem['name'];
        $arquivo = $imagem['tmp_name'];

        //setando atributos
        $monster = new Monster();
        $monster->setNomeMonster($_POST['txtNome']);
        $monster->setRacaMonster($_POST['txtRaca']);
        $monster->setNivelMonster($_POST['txtNivel']);
        $monster->setDescricaoMonster($_POST['txtDescricao']);
        $monster->setHabilidadesMonster($_POST['txtHabilidades']);

        //recebendo imagem
        $monster->setNomeImagem($nomeImagem);
        $monster->setCaminhoImagem('img/');
        move_uploaded_file($arquivo, '../' . $monster->getCaminhoImagem() . $monster->getNomeImagem());
        $monster->setCaminhoImagem($monster->getCaminhoImagem() . $monster->getNomeImagem());

        //Criando
        $monster->criar($monster);

    }else if($acao == 'deletar'){
        $idMonster = $_GET['id'];
        $monster = new Monster();
        $monster->deletar($idMonster);
    }else{
        header("Location: ../meus_monstros.php");
    }

?>