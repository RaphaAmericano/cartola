<?php 
class Cartola { 
    
    
}

    $host = "127.0.0.1";
    $db = "cartola";
    $user = "root";
    $pass = "";

    $con = new mysqli($host, $user, $pass, $db); 
    //var_dump($con);

    if ($con->connect_errno) {
        print 'Erro '.$con->connect_error.'';
        exit;
    };

    $query_lista_rodadas = sprintf("SELECT RODADA.ID_RODADA, NOME_EQUIPE, NOME_JOGADOR, TOTAL_PONTOS FROM EQUIPE 
        INNER JOIN PONTUACAO ON EQUIPE.ID_JOGADOR =  PONTUACAO.ID_JOGADOR 
        INNER JOIN RODADA ON PONTUACAO.ID_RODADA = RODADA.ID_RODADA
        ORDER BY TOTAL_PONTOS DESC");

// $query_lista_rodadas = sprintf("SELECT * FROM PONTUACAO 
// INNER JOIN EQUIPE ON EQUIPE.ID_JOGADOR =  PONTUACAO.ID_JOGADOR 
// INNER JOIN RODADA ON PONTUACAO.ID_RODADA = RODADA.ID_RODADA");

//$query_lista_rodadas = sprintf("SELECT * FROM PONTUACAO;");

    if(!$resultado = $con->query($query_lista_rodadas)){
        print 'Erro '. $con->error .'\n' ;
        print "Errno: " . $con->errno . "\n";;
        exit;
    }

    if($resultado->num_rows === 0 ){
        print "0";
        exit;
    }

    if($resultado = $con->query($query_lista_rodadas)){
        while ($row = $resultado->fetch_assoc()) {
            
            print $row['ID_RODADA'].'<br>';
            print $row['NOME_EQUIPE'].'<br>';
            print $row['NOME_JOGADOR'].'<br>';
            print $row['TOTAL_PONTOS'].'<br>';
        }
        $resultado->close();
    }

    // $resultado->free();
    $con->close();

?>
