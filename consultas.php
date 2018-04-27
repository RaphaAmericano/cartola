<?php 

$opcao = $_POST['action'];

if($opcao){
    if($opcao == "1"){

    $db = "cartola";
    $user = "root";
    $pass = "";
    $host = "127.0.0.1";

    if($_SERVER['SERVER_ADDR'] == "31.220.16.172" ) {
        $host = "localhost";
        $db = "u651336980_carto";
        $user = "u651336980_admin";
        $pass = "fluminense";
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
    
    //var_dump($retorno);
    //    echo  implode(" ",$retorno);
   echo json_encode($retorno);

    }

    if($opcao == "2") {

        $db = "cartola";
        $user = "root";
        $pass = "";
        $host = "127.0.0.1";

        if($_SERVER['SERVER_ADDR'] == "31.220.16.172" ) {
            $host = "localhost";
            $db = "u651336980_carto";
            $user = "u651336980_admin";
            $pass = "fluminense";
        }

        $con = new mysqli($host,  $user, $pass, $db);   
        if ($con->connect_errno) {
            print 'Erro '.$con->connect_error.'';
            exit;
        };

        $query_total_pontos = sprintf("SELECT E.NOME_EQUIPE,E.ID_JOGADOR, SUM(TOTAL_PONTOS) AS TOTAL FROM EQUIPE E INNER JOIN PONTUACAO P INNER JOIN RODADA R ON E.ID_JOGADOR = P.ID_JOGADOR AND R.ID_RODADA = P.ID_RODADA  GROUP BY P.ID_JOGADOR ORDER BY TOTAL DESC");
        // SELECT 
        // E.NOME_EQUIPE, sum(P.TOTAL_PONTOS) AS TOTAL
        // FROM 
        // EQUIPE E INNER JOIN PONTUACAO P ON E.ID_JOGADOR = P.ID_JOGADOR
        // INNER JOIN RODADA R ON R.ID_RODADA = P.ID_RODADA
        // GROUP BY  
        // E.NOME_EQUIPE
        // ORDER BY TOTAL DESC
        //ORDER BY TOTAL_PONTOS DESC
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
            $retorno['pontos'] = array();
            while ($row = $resultado->fetch_assoc()) { 
                array_push($retorno['nome_equipe'], $row['NOME_EQUIPE']);      
                array_push($retorno['pontos'], $row['TOTAL']);
            }
            $resultado->close();
        }

        echo json_encode($retorno);
    }
}
?>