<?php

spl_autoload_register('carregarClasse');

function carregarClasse($nomeClasse) {
    $pastas = [
        './classes/',
        '../classes/'
    ];

    foreach ($pastas as $pasta) {
        $arquivo = $pasta . $nomeClasse . '.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
}

?>
