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

    $idMonster = isset($_GET['id']) ? $_GET['id'] : null;
    $detalhes = null;
    if ($idMonster) {
        $monster = new Monster();
        $detalhes = $monster->detalhar($idMonster);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $idMonster ? 'Editar' : 'Criar'; ?> Monstro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/form_fichas.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4"><?php echo $idMonster ? 'Editar' : 'Criar'; ?> Monstro</h1>
    <form method="POST" action="php/crud_monster.php?action=<?php echo $idMonster ? 'editar&id=' . $idMonster : 'criar'; ?>" enctype="multipart/form-data">
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
                    <input type="text" class="form-control" id="nome" name="txtNome" placeholder="Ex. Conde Dracula" value="<?php echo $detalhes ? htmlspecialchars($detalhes['nomeMonster']) : ''; ?>">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="classe">Raça/Tipo:</label>
                        <input type="text" class="form-control" id="classe" name="txtRaca" placeholder="Ex. Vampiro, Morto-vivo" value="<?php echo $detalhes ? htmlspecialchars($detalhes['racaMonster']) : ''; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nivel">Nível:</label>
                        <input type="number" class="form-control" id="nivel" name="txtNivel" min="1" max="20" value="<?php echo $detalhes ? htmlspecialchars($detalhes['nivelMonster']) : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="txtDescricao" rows="5" placeholder="Ex. Conde Dracula é um vampiro alto, pálido como a lua..."><?php echo $detalhes ? htmlspecialchars($detalhes['descricaoMonster']) : ''; ?></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="habilidades">Habilidades:</label>
            <textarea class="form-control" id="habilidades" name="txtHabilidades" rows="8" placeholder="Ex. Metamorfose em morcego, voar..."><?php echo $detalhes ? htmlspecialchars($detalhes['habilidadesMonster']) : ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $idMonster ? 'Salvar' : 'Criar'; ?></button>
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
