<?php
class crud2
{
    public function validar_contra($u1, $p1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        //$sql = "SELECT COUNT(supervisor) FROM db_asistencia.credenciales WHERE supervisor = '" . $u1 . "' AND pass_sup = '" . $p1 . "' AND REST_REVISADO = 'X';";
        $sql = "SELECT TRIM(COUNT(supervisor)) FROM db_asistencia.credenciales WHERE supervisor = '" . $u1 . "' AND pass_sup = sha1('" . $p1 . "') AND REST_REVISADO IN ('T', 'F', 'X');";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }
    public function buscar($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT COUNT(*) as resultado FROM db_asistencia.entregas_viveres WHERE badge = $badge;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }
    public function actualizar($badge, $user, $notag, $correlativo)
    {
        date_default_timezone_set('America/Tegucigalpa');
        $fecha = date('Y-m-d H:i:s');
        $obj = new conectar();

        $correlativo = (string)$correlativo;

        if($correlativo != '' || $correlativo != null) $tipoEntrega = "CAMBIO BADGE Y CARNET DE TRANSPORTE";
        else $tipoEntrega = 'CAMBIO BADGE';

        $conexion = $obj->conexionMySQL();
        $sql = "UPDATE db_asistencia.entregas_viveres SET TIPO_ENTREGA = '$tipoEntrega', FECHAHORA = CURRENT_TIMESTAMP() , ESTADO = 'ENTREGADO', ENTREGO = '$user', NOTA = UPPER('$notag'), CORR = '$correlativo' WHERE BADGE = $badge AND ESTADO = 'PENDIENTE';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    //Función agregada para la entrega de badge nuevos en octubre 2021 y verificación de personal que utiliza transporte para la entrega de badge en la misma fecha.
    public function VerificacionTransporte($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT * FROM db_asistencia.usuarios_transporte WHERE BADGE = $badge";
        $resultado = mysqli_query($conexion, $sql);
        $usaTransporte = mysqli_fetch_row($resultado);

        if($usaTransporte == null) return;
        else return 1;
        mysqli_close($conexion);
    }

    public function ComprobarCorrelativo($correlativo)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT COUNT(*) FROM db_asistencia.entregas_viveres WHERE CORR = '$correlativo'";
        $resultado = mysqli_query($conexion, $sql);
        $usaTransporte = mysqli_fetch_row($resultado);

        if($usaTransporte == null) return;
        else return $usaTransporte[0];
        mysqli_close($conexion);
    }

    public function entregado($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT COUNT(*) as resultado FROM db_asistencia.entregas_viveres WHERE badge = $badge and ESTADO = 'ENTREGADO';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }
    public function nombre($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT DISTINCT NOMBRE as NOMBRE FROM db_asistencia.entregas_viveres WHERE badge = '" . $badge . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }
    public function data_graf()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT 
        SUM(CASE WHEN ESTADO = 'PENDIENTE' THEN CUENTA ELSE 0 END) AS PENDIENTE,
        SUM(CASE WHEN ESTADO = 'ENTREGADO' THEN CUENTA ELSE 0 END) AS ENTREGADO,
        SUM(CASE WHEN ESTADO = 'PEN_ENTREG' THEN CUENTA ELSE 0 END) AS PENENTREG
        FROM
        (SELECT ESTADO,COUNT(1) AS CUENTA FROM ENTREGAS_VIVERES WHERE CORR = 'ENTREGA1' GROUP BY ESTADO) A ;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }
    public function graf_quiebre($areadt)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT nomarea AS AREA, turnooperadora AS TURNO, 
        SUM(CASE WHEN ESTADO = 'PENDIENTE' THEN CUENTA ELSE 0 END) AS PENDIENTE,
        SUM(CASE WHEN ESTADO = 'ENTREGADO' THEN CUENTA ELSE 0 END) AS ENTREGADO
        FROM (
        SELECT a.nomarea, a.estado, b.turnooperadora, COUNT(1) AS CUENTA 
        FROM entregas_viveres a
        LEFT JOIN operadorasturno b
        ON a.badge = b.badge
        AND a.CORR = 'ENTREGA1' 
        GROUP BY a.nomarea, a.estado, b.turnooperadora) A WHERE nomarea like '%" . $areadt . "%' GROUP BY nomarea, turnooperadora;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }
    public function graf_quiebre_area($areadt)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT nomarea AS AREA,  
        SUM(CASE WHEN ESTADO = 'PENDIENTE' THEN CUENTA ELSE 0 END) AS PENDIENTE,
        SUM(CASE WHEN ESTADO = 'ENTREGADO' THEN CUENTA ELSE 0 END) AS ENTREGADO
        FROM (
        SELECT a.nomarea, a.estado, COUNT(1) AS CUENTA 
        FROM entregas_viveres a
        LEFT JOIN operadorasturno b
        ON a.badge = b.badge
        AND a.CORR = 'ENTREGA1' 
        GROUP BY a.nomarea, a.estado) A WHERE nomarea like '%" . $areadt . "%'  GROUP BY nomarea;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }
    public function graf_quiebre_turno($areadt)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT turnooperadora AS TURNO, 
        SUM(CASE WHEN ESTADO = 'PENDIENTE' THEN CUENTA ELSE 0 END) AS PENDIENTE,
        SUM(CASE WHEN ESTADO = 'ENTREGADO' THEN CUENTA ELSE 0 END) AS ENTREGADO
        FROM (
        SELECT a.estado, b.turnooperadora, COUNT(1) AS CUENTA 
        FROM entregas_viveres a
        LEFT JOIN operadorasturno b
        ON a.badge = b.badge
        WHERE a.nomarea like '%" . $areadt . "%'
        AND a.CORR = 'ENTREGA1' 
        GROUP BY a.estado, b.turnooperadora) A  GROUP BY turnooperadora;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }
    public function verificar($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT BADGE,NOMBRE,NOMAREA,DATE_FORMAT(FECHAHORA,'%d/%m/%Y %H:%i') AS FECHAHORA,ESTADO,ENTREGO,NOTA FROM db_asistencia.entregas_viveres WHERE badge = $badge";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);


        
    }
    public function verificarct($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT count(1) FROM db_asistencia.entregas_viveres WHERE badge = '" . $badge . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
        
    }
    public function update_oper($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "UPDATE db_asistencia.entregas_viveres SET FECHAHORA = NULL , ESTADO = 'PENDIENTE', ENTREGO = NULL , NOTA = NULL WHERE BADGE = '" . $badge . "';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }
    public function update_operN($badge,$nota)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "UPDATE db_asistencia.entregas_viveres SET NOTA = '" . $nota . "'  WHERE BADGE = '" . $badge . "' AND ESTADO = 'ENTREGADO';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }


}
?>