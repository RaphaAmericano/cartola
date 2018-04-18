<?php 
class Cartola { 
    
    // private $host = "localhost";
    // private $db = "devmedia";
    // private $user = "root";
    // private $pass = "";

    // $con = mysql_pconnect($host, $user, $pass);

    // public function __construct(){
    //     print '<h1>Funcionando</h1>';
    // }

    // public function printHost(){
        
    // }
    

    // mysql_select_db($db, $con);

    // $query_lista_rodadas = sprintf("SELECT RODADA.ID_RODADA, NOME_EQUIPE, NOME_JOGADOR, TOTAL_PONTOS FROM EQUIPE 
    //     INNER JOIN PONTUACAO ON EQUIPE.ID_JOGADOR =  PONTUACAO.ID_JOGADOR 
    //     INNER JOIN RODADA ON PONTUACAO.ID_RODADA = RODADA.ID_RODADA
    //     ORDER BY TOTAL_PONTOS DESC");

    // if(!$con){
    //     die('Conexão falhou: '.mysql_error());
    // } 

    // $dados = mysql_query($query_lista_rodadas, $con);

    // $linha = mysql_fetch_assoc($dados);

    // $total = mysql_num_rows($dados);


    // public function exibir($total){
    //     for ($i=0; $i < $total; $i++) { 
    //         echo 'funciona'.$i.'<br>';
    //     }
        
    // }
}
// $novo = new Cartola;
// $novo->printHost();


    private $host = "localhost";
    private $db = "devmedia";
    private $user = "root";
    private $pass = "";

    $con = mysql_pconnect($host, $user, $pass); 

    mysql_select_db($db, $con);

    $query_lista_rodadas = sprintf("SELECT RODADA.ID_RODADA, NOME_EQUIPE, NOME_JOGADOR, TOTAL_PONTOS FROM EQUIPE 
        INNER JOIN PONTUACAO ON EQUIPE.ID_JOGADOR =  PONTUACAO.ID_JOGADOR 
        INNER JOIN RODADA ON PONTUACAO.ID_RODADA = RODADA.ID_RODADA
        ORDER BY TOTAL_PONTOS DESC");

    if(!$con){
        die('Conexão falhou: '.mysql_error());
    } 

    $dados = mysql_query($query_lista_rodadas, $con);

    $linha = mysql_fetch_assoc($dados);

    $total = mysql_num_rows($dados);
    print $total;
?>
