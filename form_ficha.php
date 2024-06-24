<?php
    session_start();

    require_once 'global.php';

    if (!isset($_SESSION['User'])) {
        header('Location: login.php');
        exit();
    }

    if (isset($_SESSION['TryAgain'])){
        echo $_SESSION['TryAgain'];
        unset($_SESSION['TryAgain']);
    }

    $idFicha = isset($_GET['id']) ? $_GET['id'] : null;
    $detalhes = null;
    if ($idFicha) {
        $ficha = new Ficha();
        $detalhes = $ficha->detalhar($idFicha);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $idFicha ? 'Editar' : 'Criar'; ?> Personagem</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/form_fichas.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4"><?php echo $idFicha ? 'Editar' : 'Criar'; ?> Personagem</h1>
    <form method="POST" action="php/crud_ficha.php?action=<?php echo $idFicha ? 'editar&id=' . $idFicha : 'criar'; ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4">
                <div class="image-preview" id="imagePreview">
                    <img src="<?php echo $detalhes ? htmlspecialchars($detalhes['caminhoImagem']) : ''; ?>" alt="Image Preview" class="image-preview__image" style="<?php echo $detalhes ? '' : 'display: none;'; ?>">
                    <span class="image-preview__default-text" style="<?php echo $detalhes ? 'display: none;' : ''; ?>">Imagem</span>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control-file" id="imageUpload" name="imageUpload" accept="image/*">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="txtNome" placeholder="Ex. Asura Mephistopheles" value="<?php echo $detalhes ? htmlspecialchars($detalhes['nomePersonagem']) : ''; ?>">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="classe">Classe ou Profissao:</label>
                        <input type="text" class="form-control" id="classe" name="txtTrabalho" placeholder="Ex. Fighter, Monk" value="<?php echo $detalhes ? htmlspecialchars($detalhes['classe_profissao']) : ''; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nivel">Nível:</label>
                        <input type="number" class="form-control" id="nivel" name="txtNivel" min="1" max="20" value="<?php echo $detalhes ? htmlspecialchars($detalhes['nivelPersonagem']) : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="raca">Raça:</label>
                    <input type="text" class="form-control" id="raca" name="txtRaca" placeholder="Ex. Tiefling, Humano" value="<?php echo $detalhes ? htmlspecialchars($detalhes['racaPersonagem']) : ''; ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" id="descricao" name="txtDescricao" rows="3" placeholder="Ex. Alto, careca, cara de cansado com um chapéu de palha cobrindo todo o rosto"><?php echo $detalhes ? htmlspecialchars($detalhes['descricaoPersonagem']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="habilidades">Habilidades:</label>
            <textarea class="form-control" id="habilidades" name="txtHabilidades" rows="5" placeholder="Ex. Ataque com katana, Katanada, gritar"><?php echo $detalhes ? htmlspecialchars($detalhes['habilidadesPersonagem']) : ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $idFicha ? 'Salvar' : 'Criar'; ?></button>
        <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#imageUpload').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview').css('display', 'block');
                    $('#imagePreview img').attr('src', event.target.result);
                    $('#imagePreview img').css('display', 'block');
                    $('#imagePreview .image-preview__default-text').css('display', 'none');
                }
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview img').css('display', 'none');
                $('#imagePreview .image-preview__default-text').css('display', 'block');
            }
        });
    });
</script>
</body>
</html>
