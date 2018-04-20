

<?php
include('header.php'); 
class Cartola {

    private $host = "127.0.0.1";
    private $db = "cartola";
    private $user = "root";
    private $pass = "";

    function __construct() {
        Cartola::listarRodadas();
        Cartola::listarLideranca();
    }

    public function listarRodadas(){
        $con = new mysqli($this->host,  $this->user, $this->pass, $this->db);   
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

    public function listarLideranca(){
        $con = new mysqli($this->host,  $this->user, $this->pass, $this->db);   
        if ($con->connect_errno) {
            print 'Erro '.$con->connect_error.'';
            exit;
        };

        $query_lista_rodadas = sprintf("SELECT 
        E.NOME_EQUIPE, sum(P.TOTAL_PONTOS) AS TOTAL
        FROM 
        EQUIPE E INNER JOIN PONTUACAO P ON E.ID_JOGADOR = P.ID_JOGADOR
        INNER JOIN RODADA R ON R.ID_RODADA = P.ID_RODADA
        GROUP BY  
        E.NOME_EQUIPE");

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
                    <th>Posição</th>
                    <th>Equipe</th>
                    <th>Total de Pontos</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $c = 1;
            while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php print $c; $c++; ?></td>
                <td><?php print $row['NOME_EQUIPE']; ?></td>
                <td><?php print $row['TOTAL']; ?></td>
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