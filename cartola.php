

<?php
include('header.php'); 
class Cartola { 

    function __construct() {
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
            ?>
            <table class="table">
            <thead>
                <tr>
                    <th>Rodada #</th>
                    <th>Equipe</th>
                    <th>Jogador</th>
                    <th>Pontos</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $c = 1;
            while ($row = $resultado->fetch_assoc()) { ?>
            
            <tr>
                <th>
                <?php if(strval($row['ID_RODADA']) == $c ){
                        print $row['ID_RODADA']; 
                        $c++;
                    } ?>
                </th>
                <td><?php print $row['NOME_EQUIPE']; ?></td>
                <td><?php print $row['NOME_JOGADOR']; ?></td>
                <td><?php print $row['TOTAL_PONTOS']; ?></td>
            </tr>
            
            <?php }

            print '</tbody></table>';
            $resultado->close();
        }

        // $resultado->free();
        $con->close();
    }
    
}

$cartola = new Cartola(); 

include('footer.php');