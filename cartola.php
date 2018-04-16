<?php 
class Cartola {

    

    public function __construct(){

    }

    $conexao = mysql_connect('localhost', 'root', '');
    if(!$conexao){
        die('Conexão falhou: '.mysql_error());
    }

    public function exibir($quantidades){
        for ($i=0; $i < $quantidades; $i++) { 
            echo 'funciona'.$i.'<br>';
        }
        
    }
}
$novo = new Cartola;
$novo->exibir(5);
?>
