<?php

class Conexao{

    public static function pegarConexao(){
        //offline
        /*$servidor = "localhost";
        $banco = "rpgodyssey";
        $usuario = "root";
        $senha = "";*/

        //online
        $servidor = "fdb1030.awardspace.net";
        $banco = "3683152_rpgodyssey";
        $usuario = "3683152_rpgodyssey";
        $senha = "Teste123456";	

        try{
            $conexao = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);

            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexao->exec("SET CHARACTER SET utf8");
            return $conexao;
            
        }catch(PDOException $err){
            echo "Error: ".$err -> getMessage();
        }

    }
}
 
?>
