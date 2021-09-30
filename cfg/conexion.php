<?php
class conectar
{
  
    private $servidor="32.94.126.190";
    private $usuario="d.espinoza";
    private $bd="db_asistencia";
    private $password="Desp2018$";

    public function conexionMySQL()
    {
        $conexion=mysqli_connect($this->servidor,
									 $this->usuario,
									 $this->password,
                                     $this->bd) ;
									 if (!$conexion) {
										echo  mysqli_connect_error() . PHP_EOL;
										header("location:../404.php?error=1");
										exit;
									}
									mysqli_set_charset($conexion,"utf8");				
			return $conexion;
        


    }
}
?>





