<?php 
class BancoDeDados {

    private $host = "127.0.0.1";
    private $db = "cartola";
    private $user = "root";
    private $pass = "";
    private $con;

    public function  __construct(){
        BancoDeDados::checarServidor();
        BancoDeDados::abrirConexao();
    }

    public function checarServidor(){
        if($_SERVER['SERVER_ADDR'] == "31.220.16.172" ) {
            $this->host = "localhost";
            $this->db = "u651336980_carto";
            $this->user = "u651336980_admin";
            $this->pass = "fluminense";
        }
    }

    public function abrirConexao(){
        $this->con = new mysqli($this->host,  $this->user, $this->pass, $this->db);
    } 

    public function fecharConexao(){
        $this->con->close();
    }

    public function checarConexao($conexao, $query){
        if ($conexao->connect_errno) {
            print 'Erro '.$conexao->connect_error.'';
            exit;
        };

        if(!$resultado = $conexao->query($query)){
            print 'Erro '. $conexao->error .'\n' ;
            print "Errno: " . $conexao->errno . "\n";;
            exit;
        }

        if($resultado->num_rows === 0 ){
            print "0";
            exit;
        }
        return $resultado;
    }
}
?>

