<?php 

$opcao = $_POST['action'];

if($opcao){
    if($opcao == "1"){

    $host = "mysql.hostinger.com.br";
    $db = "u651336980_carto";
    $user = "u651336980_admin";
    $pass = "fluminense";

    if($_SERVER['SERVER_ADDR'] == "::1" ) {
        $db = "cartola";
        $user = "root";
        $pass = "";
        $host = "127.0.0.1";
    }

    $con = new mysqli($host,  $user, $pass, $db);   
    if ($con->connect_errno) {
        print 'Erro '.$con->connect_error.'';
        exit;
    };

    $query_lista_rodadas = sprintf("SELECT RODADA.ID_RODADA, NOME_EQUIPE, NOME_JOGADOR, EQUIPE.ID_JOGADOR, TOTAL_PONTOS FROM EQUIPE 
        INNER JOIN PONTUACAO ON EQUIPE.ID_JOGADOR =  PONTUACAO.ID_JOGADOR 
        INNER JOIN RODADA ON PONTUACAO.ID_RODADA = RODADA.ID_RODADA");
    //ORDER BY TOTAL_PONTOS DESC

    $query_pontos_ordenados = sprintf("SELECT * FROM PONTUACAO WHERE 1 order by ID_JOGADOR, ID_RODADA");
    
    if(!$resultado = $con->query($query_lista_rodadas)){
        print 'Erro '. $con->error .'\n' ;
        print "Errno: " . $con->errno . "\n";;
        exit;
    }

    if($resultado->num_rows === 0 ){
        print "0";
        exit;
    }
    
    if(!$resultado_ordenado = $con->query($query_pontos_ordenados)){
        print 'Erro '. $con->error .'\n' ;
        print "Errno: " . $con->errno . "\n";;
        exit;
    }

    if($resultado_ordenado->num_rows === 0 ){
        print "0";
        exit;
    }

    
    if($resultado = $con->query($query_lista_rodadas)){
        $retorno['rodada'] = array();
        $retorno['id_jogador'] = array();
        $retorno['nome_jogador'] = array();
        $retorno['nome_equipe'] = array();
        $retorno['pontos'] = array();
      

        $c = 1;
        $i = 1;
        while ($row = $resultado->fetch_assoc()) { 
            if(strval($row['ID_RODADA']) == $c ){
                array_push($retorno['rodada'], $row['ID_RODADA']);
                
                $c++;
            }
            if(strval($row['ID_JOGADOR']) == $i ){
                array_push($retorno['id_jogador'], $row['ID_JOGADOR']);
                array_push($retorno['nome_jogador'], $row['NOME_JOGADOR']);
                array_push($retorno['nome_equipe'], $row['NOME_EQUIPE']);
                $i++;
            }
            array_push($retorno['pontos'], $row['TOTAL_PONTOS']);
            }
            
        $resultado->close();
    }

   echo json_encode($retorno);

    }

    if($opcao == "2") {

        $host = "mysql.hostinger.com.br";
        $db = "u651336980_carto";
        $user = "u651336980_admin";
        $pass = "fluminense";

        if($_SERVER['SERVER_ADDR'] == "::1" ) {
            $db = "cartola";
            $user = "root";
            $pass = "";
            $host = "127.0.0.1";
        }

        $con = new mysqli($host,  $user, $pass, $db);   
        if ($con->connect_errno) {
            print 'Erro '.$con->connect_error.'';
            exit;
        };

        $query_total_pontos = sprintf("SELECT RODADA.ID_RODADA, NOME_EQUIPE, NOME_JOGADOR, EQUIPE.ID_JOGADOR, TOTAL_PONTOS FROM EQUIPE 
        INNER JOIN PONTUACAO ON EQUIPE.ID_JOGADOR =  PONTUACAO.ID_JOGADOR 
        INNER JOIN RODADA ON PONTUACAO.ID_RODADA = RODADA.ID_RODADA");

        if(!$resultado = $con->query($query_total_pontos)){
            print 'Erro '. $con->error .'\n' ;
            print "Errno: " . $con->errno . "\n";;
            exit;
        }

        if($resultado->num_rows === 0 ){
            print "0";
            exit;
        }

        if($resultado = $con->query($query_total_pontos)){
            $retorno['nome_equipe'] = array();
            $retorno['id_jogador'] = array();
            $retorno['pontos'] = array();
            
            while ($row = $resultado->fetch_assoc()) { 
                array_push($retorno['nome_equipe'], $row['NOME_EQUIPE']);      
                array_push($retorno['id_jogador'], $row['ID_JOGADOR']);
                array_push($retorno['pontos'], $row['TOTAL_PONTOS']);
            }
            $resultado->close();
        }
        echo json_encode($retorno);
    }
}
?>