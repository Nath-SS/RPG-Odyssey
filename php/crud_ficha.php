<?php
    session_start();

    require_once '../global.php';

    $acao = $_GET['action'];

    if($acao == 'editar'){
        //preparando variaveis
        $idFicha = $_GET['id'];
        $imagem = $_FILES['imageUpload'];
        $nomeImagem = $imagem['name'];
        $arquivo = $imagem['tmp_name'];

        //setando atributos
        $ficha = new Ficha();
        $ficha->setIdFicha($idFicha);
        $ficha->setNomePersonagem($_POST['txtNome']);
        $ficha->setClasseProfissao($_POST['txtTrabalho']);
        $ficha->setNivelPersonagem($_POST['txtNivel']);
        $ficha->setRacaPersonagem($_POST['txtRaca']);
        $ficha->setDescricaoPersonagem($_POST['txtDescricao']);
        $ficha->setHabilidadesPersonagem($_POST['txtHabilidades']);

        if(!empty($nomeImagem)){
            //recebendo imagem
            $ficha->setNomeImagem($nomeImagem);
            $ficha->setCaminhoImagem('img/');
            move_uploaded_file($arquivo, '../' . $ficha->getCaminhoImagem() . $ficha->getNomeImagem());
            $ficha->setCaminhoImagem($ficha->getCaminhoImagem() . $ficha->getNomeImagem());
        }else{
            // Manter imagem existente
            $conexao = Conexao::pegarConexao();
            $stmt = $conexao->prepare("SELECT caminhoImagem, nomeImagem FROM ficha WHERE idFicha = ?");
            $stmt->bindValue(1, $idFicha);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $ficha->setCaminhoImagem($result['caminhoImagem']);
            $ficha->setNomeImagem($result['nomeImagem']);
        }
        //atualizando
        $ficha->atualizar($ficha);


    }else if($acao == 'criar'){
        //preparando variaveis
        $imagem = $_FILES['imageUpload'];
        $nomeImagem = $imagem['name'];
        $arquivo = $imagem['tmp_name'];

        //setando atributos
        $ficha = new Ficha();
        $ficha->setNomePersonagem($_POST['txtNome']);
        $ficha->setClasseProfissao($_POST['txtTrabalho']);
        $ficha->setNivelPersonagem($_POST['txtNivel']);
        $ficha->setRacaPersonagem($_POST['txtRaca']);
        $ficha->setDescricaoPersonagem($_POST['txtDescricao']);
        $ficha->setHabilidadesPersonagem($_POST['txtHabilidades']);

        //recebendo imagem
        $ficha->setNomeImagem($nomeImagem);
        $ficha->setCaminhoImagem('img/');
        move_uploaded_file($arquivo, '../' . $ficha->getCaminhoImagem() . $ficha->getNomeImagem());
        $ficha->setCaminhoImagem($ficha->getCaminhoImagem() . $ficha->getNomeImagem());

        //Criando
        $ficha->criar($ficha);

    }else if($acao == 'deletar'){
        $idFicha = $_GET['id'];
        $ficha = new Ficha();
        $ficha->deletar($idFicha);
    }else{
        header("Location: ../meus_personagens.php");
    }

?>