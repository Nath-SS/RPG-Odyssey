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

    $idMesa = isset($_GET['id']) ? $_GET['id'] : null;
    $detalhes = null;
    if ($idMesa) {
        $mesa = new Mesa();
        $detalhes = $mesa->detalhar($idMesa);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $idMesa ? 'Editar' : 'Criar'; ?> Mesa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/form_fichas.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4"><?php echo $idMesa ? 'Editar' : 'Criar'; ?> Mesa</h1>
    <form method="POST" action="php/crud_mesa.php?action=<?php echo $idMesa ? 'editar&id=' . $idMesa : 'criar'; ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4">
                <div class="image-preview-mesa" id="imagePreview">
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
                    <input type="text" class="form-control" id="nome" name="txtNome" placeholder="Ex. Itharum: World of sins" value="<?php echo $detalhes ? htmlspecialchars($detalhes['nomeMesa']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="sistema">Sistema:</label>
                    <select class="form-control" id="sistema" name="txtSistema">
                        <option value="" disabled selected>Escolha o sistema</option>
                        <option value="Dungeons And Dragons" <?php echo $detalhes && $detalhes['sistemaMesa'] == 'Dungeons And Dragons' ? 'selected' : ''; ?>>Dungeons And Dragons</option>
                        <option value="Call of Cthullu" <?php echo $detalhes && $detalhes['sistemaMesa'] == 'Call of Cthullu' ? 'selected' : ''; ?>>Call of Cthullu</option>
                        <option value="Tormenta20" <?php echo $detalhes && $detalhes['sistemaMesa'] == 'Tormenta20' ? 'selected' : ''; ?>>Tormenta20</option>
                        <option value="Shadownrun" <?php echo $detalhes && $detalhes['sistemaMesa'] == 'Shadowrun' ? 'selected' : ''; ?>>Shadownrun</option>
                        <option value="Outro" <?php echo $detalhes && $detalhes['sistemaMesa'] == 'Outro' ? 'selected' : ''; ?>>Outro</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nivel">Quantidade de Jogadores:</label>
                        <input type="number" class="form-control" id="nivel" name="txtQntd" min="1" value="<?php echo $detalhes ? htmlspecialchars($detalhes['qntdJogadores']) : ''; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nivel">Limite de personagem:</label>
                        <input type="number" class="form-control" id="nivel" name="txtLimite" min="1" value="<?php echo $detalhes ? htmlspecialchars($detalhes['limitePersonagem']) : ''; ?>">
                    </div>
                </div>
            </div>
            
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" id="descricao" name="txtDescricao" rows="8" placeholder="Ex. Alto, careca, cara de cansado com um chapéu de palha cobrindo todo o rosto"><?php echo $detalhes ? htmlspecialchars($detalhes['descricaoMesa']) : ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $idMesa ? 'Salvar' : 'Criar'; ?></button>
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
