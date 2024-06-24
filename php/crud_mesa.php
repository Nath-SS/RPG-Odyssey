<?php
    session_start();

    require_once '../global.php';

    $acao = $_GET['action'];

    if ($acao == 'editar') {
        // Preparando variáveis
        $idMesa = $_GET['id'];
        $imagem = $_FILES['imageUpload'];
        $nomeImagem = $imagem['name'];
        $arquivo = $imagem['tmp_name'];
    
        // Setando atributos
        $mesa = new Mesa();
        $mesa->setIdMesa($idMesa);
        $mesa->setNomeMesa($_POST['txtNome']);
        $mesa->setSistemaMesa($_POST['txtSistema']);
        $mesa->setQntdJogadores($_POST['txtQntd']);
        $mesa->setLimitePersonagem($_POST['txtLimite']);
        $mesa->setDescricaoMesa($_POST['txtDescricao']);
    
        if (!empty($nomeImagem)) {
            // Recebendo nova imagem
            $mesa->setNomeImagem($nomeImagem);
            $mesa->setCaminhoImagem('img/');
            move_uploaded_file($arquivo, '../' . $mesa->getCaminhoImagem() . $mesa->getNomeImagem());
            $mesa->setCaminhoImagem($mesa->getCaminhoImagem() . $mesa->getNomeImagem());
        } else {
            // Manter imagem existente
            $conexao = Conexao::pegarConexao();
            $stmt = $conexao->prepare("SELECT caminhoImagem, nomeImagem FROM mesa WHERE idMesa = ?");
            $stmt->bindValue(1, $idMesa);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $mesa->setCaminhoImagem($result['caminhoImagem']);
            $mesa->setNomeImagem($result['nomeImagem']);
        }
        // Atualizando
        $mesa->atualizar($mesa);
    }else if($acao == 'criar'){
        //preparando variaveis
        $imagem = $_FILES['imageUpload'];
        $nomeImagem = $imagem['name'];
        $arquivo = $imagem['tmp_name'];

        //setando atributos
        $mesa = new Mesa();
        $mesa->setNomeMesa($_POST['txtNome']);
        $mesa->setSistemaMesa($_POST['txtSistema']);
        $mesa->setQntdJogadores($_POST['txtQntd']);
        $mesa->setLimitePersonagem($_POST['txtLimite']);
        $mesa->setDescricaoMesa($_POST['txtDescricao']);

        //recebendo imagem
        $mesa->setNomeImagem($nomeImagem);
        $mesa->setCaminhoImagem('img/');
        move_uploaded_file($arquivo, '../' . $mesa->getCaminhoImagem() . $mesa->getNomeImagem());
        $mesa->setCaminhoImagem($mesa->getCaminhoImagem() . $mesa->getNomeImagem());

        //Criando
        $mesa->criar($mesa);

    }else if($acao == 'deletar'){
        $idMesa = $_GET['id'];
        $mesa = new Mesa();
        $mesa->deletar($idMesa);
    }else{
        header("Location: ../meus_personagens.php");
    }

?>