<?php

class crud
{
    // valida si existe el supervisor
    public function validar_contra($u1, $p1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(supervisor) FROM db_asistencia.credenciales WHERE supervisor = '" . $u1 . "' AND pass_sup = SHA1('" . $p1 . "');";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }
    //obtiene el nombre del sup
    public function get_sup_name($usuario)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT descripcion FROM db_asistencia.credenciales WHERE supervisor = '" . $usuario . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_my_admin($usuario)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT admin FROM db_asistencia.supervisores WHERE supervisor = '" . $usuario . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    //obtiene elrol del sup
    public function get_sup_rol($usuario)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT rol FROM db_asistencia.credenciales WHERE supervisor = '" . $usuario . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_sup_clerk($usuario)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT auto_rev FROM db_asistencia.credenciales WHERE supervisor = '" . $usuario . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function get_puestoact($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT NOMAREA,NOMBRE FROM db_asistencia.empleadosareas_v WHERE BADGE = '" . $badge . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_turno($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT turnooperadora FROM db_asistencia.operadorasturno WHERE BADGE = '" . $badge . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    //personal del superintendente como admin
    public function get_personal($admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT SUPER FROM db_asistencia.suprol WHERE admin = '" . $admin . "';";
        $sql = "SELECT DISTINCT SUPERVISOR AS SUPER FROM db_asistencia.supervisores WHERE admin = '" . $admin . "' ORDER BY SUPERVISOR ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_personal_all()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT SUPER FROM db_asistencia.suprol WHERE admin = '" . $admin . "';";
        $sql = "SELECT DISTINCT SUPER FROM (
            SELECT SUPERVISOR AS SUPER FROM db_asistencia.supervisores
            UNION 
            SELECT DESCRIPCION AS SUPER FROM db_asistencia.credenciales) A ORDER BY SUPER ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }
    //plantas en realidad
    public function get_areas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT SUPER FROM db_asistencia.suprol WHERE admin = '" . $admin . "';";
        $sql = "SELECT areaempleado,nomarea FROM db_asistencia.areas_list UNION SELECT areaempleado,nomarea FROM db_asistencia.areas_list_X;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function get_areas_linea()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT SUPER FROM db_asistencia.suprol WHERE admin = '" . $admin . "';";
        //$sql = "SELECT nomarea FROM db_asistencia.empleadosareas group by nomarea order by nomarea asc;";
        $sql = "SELECT nomarea FROM (
            SELECT nomarea FROM db_asistencia.areas_list
            UNION
            SELECT nomarea FROM db_asistencia.areas_list_x) a ORDER BY nomarea ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_areas_lineai($admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT SUPER FROM db_asistencia.suprol WHERE admin = '" . $admin . "';";
        //$sql = "SELECT a.nomarea as nomarea FROM db_asistencia.empleadosareas a, db_asistencia.supervisores b where a.areaempleado = b.areaempleado and B.ADMIN = '" . $admin . "' group by nomarea order by nomarea asc;";
        $sql = "SELECT a.nomarea as nomarea FROM db_asistencia.empleadosareas_v a, db_asistencia.supervisores b
                 where a.areaempleado = b.areaempleado and B.ADMIN = '" . $admin . "' group by nomarea order by nomarea asc;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_mysups($admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        $sql = "SELECT DISTINCT a.badge AS BADGE,a.supervisor AS SUPERVISOR,b.PUESTO, b.AREA, b.ESTADO,c.turnooperadora as TURNO,a.turno as ASIGNADO
        FROM supervisores a
        LEFT JOIN grupos_super b
        ON a.badge = b.badge
        LEFT JOIN operadorasturno_c c
        ON a.badge = c.badge
        WHERE a.admin = '" . $admin . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    //obtiene los oepradores bajo el supervisor responsable
    public function get_perfil($perfiln, $admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        // $sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,TURNO FROM db_asistencia.grupos_super WHERE responsable = '" . $perfiln . "' ORDER BY AREA, PUESTO ASC;";
        $sql = "SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,d.PUESTO,a.nomarea AS AREA,d.ESTADO,b.turnooperadora AS TURNO,c.supervisor 
        FROM empleadosareas_v a
        LEFT JOIN grupos_super D
        ON a.badge = d.badge
        INNER JOIN operadorasturno_c b
        ON a.badge = b.badge
        INNER JOIN supervisores C 
        ON A.areaempleado = c.areaempleado
        AND b.turnooperadora = c.turno
        AND C.supervisor = '" . $perfiln . "'
        and a.nombre <> '" . $perfiln . "'
        AND C.ADMIN = '" . $admin . "'
        ORDER BY BADGE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function get_perfil_M($perfiln, $admin, $supi)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        // $sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,TURNO FROM db_asistencia.grupos_super WHERE responsable = '" . $perfiln . "' ORDER BY AREA, PUESTO ASC;";
        $sql = "SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,d.PUESTO,a.nomarea AS AREA,d.ESTADO,b.turnooperadora AS TURNO,c.supervisor 
        FROM empleadosareas_v a
        LEFT JOIN grupos_super D
        ON a.badge = d.badge
        INNER JOIN operadorasturno_c b
        ON a.badge = b.badge
        INNER JOIN supervisores C 
        ON A.areaempleado = c.areaempleado
        AND b.turnooperadora = c.turno
        AND C.supervisor = '" . $perfiln . "'
        and a.nombre <> '" . $perfiln . "'
        AND C.ADMIN = '" . $supi . "'
        ORDER BY BADGE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_perfil_rrhh($perfiln, $admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        // $sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,TURNO FROM db_asistencia.grupos_super WHERE responsable = '" . $perfiln . "' ORDER BY AREA, PUESTO ASC;";
        $sql = "SELECT distinct a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,d.PUESTO,a.nomarea AS AREA,d.ESTADO,b.turnooperadora AS TURNO,c.supervisor 
        FROM empleadosareas_v a
        LEFT JOIN grupos_super D
        ON a.badge = d.badge
        INNER JOIN operadorasturno_c b
        ON a.badge = b.badge
        INNER JOIN supervisores C 
        ON A.areaempleado = c.areaempleado
        AND b.turnooperadora = c.turno
        AND C.supervisor = '" . $perfiln . "'
        and a.nombre <> '" . $perfiln . "'
        ORDER BY BADGE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_perfil_rrhh_all()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        // $sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,TURNO FROM db_asistencia.grupos_super WHERE responsable = '" . $perfiln . "' ORDER BY AREA, PUESTO ASC;";
        $sql = "SELECT distinct a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,d.PUESTO,a.nomarea AS AREA,d.ESTADO,b.turnooperadora AS TURNO,c.supervisor 
        FROM empleadosareas_v a
        LEFT JOIN grupos_super D
        ON a.badge = d.badge
        INNER JOIN operadorasturno_c b
        ON a.badge = b.badge
        INNER JOIN supervisores C 
        ON A.areaempleado = c.areaempleado
        AND b.turnooperadora = c.turno
        ORDER BY BADGE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_perfil_all($perfiln, $admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        // $sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,TURNO FROM db_asistencia.grupos_super WHERE responsable = '" . $perfiln . "' ORDER BY AREA, PUESTO ASC;";
        $sql = "SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,d.PUESTO,a.nomarea AS AREA,d.ESTADO,b.turnooperadora AS TURNO,c.SUPERVISOR 
        FROM empleadosareas_v a
        LEFT JOIN grupos_super D
        ON a.badge = d.badge
        INNER JOIN operadorasturno_c b
        ON a.badge = b.badge
        INNER JOIN supervisores C 
        ON A.areaempleado = c.areaempleado
        AND b.turnooperadora = c.turno
        AND C.ADMIN = '" . $admin . "'
        AND C.supervisor in (" . $perfiln . ")
         ORDER BY c.supervisor, a.badge ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }





    // llena los badge y turno del supervisor para la pantalla de manto
    public function fill_oper_sup($perfiln)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT BADGE,TURNO FROM db_asistencia.grupos_super WHERE responsable = '" . $perfiln . "' ORDER BY BADGE ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }
    //solo turno sup
    public function fill_oper_sup2($perfiln1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT TURNO FROM db_asistencia.supervisores WHERE supervisor = '" . $perfiln1 . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function fill_areas()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT AREA FROM db_asistencia.areas ORDER BY area ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_estados()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADO FROM db_asistencia.estados ORDER BY ESTADO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_puestos()
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT PUESTO FROM db_asistencia.puestos ORDER BY puesto ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_puestos($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT SUPER FROM db_asistencia.suprol WHERE admin = '" . $admin . "';";
        $sql = "SELECT PUESTO2,PUESTO3, PUESTO4, PUESTO5 FROM db_asistencia.grupos_super WHERE BADGE = '" . $badge . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    //actualiza el nuevo turno desde manto para supervisor
    public function update_turno($turn1, $resp1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "UPDATE db_asistencia.grupos_super SET TURNO = '" . $turn1 . "' WHERE RESPONSABLE = '" . $resp1 . "';";
        $sql = "UPDATE db_asistencia.supervisores SET TURNO = '" . $turn1 . "' WHERE SUPERVISOR = '" . $resp1 . "';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }
    //borrar operador
    public function borrar_operador($oper1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM db_asistencia.grupos_super WHERE BADGE = '" . $oper1 . "';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    //datos del operador
    public function datos_oper($badge1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO FROM db_asistencia.grupos_super WHERE BADGE = '" . $badge1. "' AND RESPONSABLE = '" . $super1. "';";
        $sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,PUESTO2,PUESTO3,PUESTO4,PUESTO5,AREA,ESTADO,TURNO FROM db_asistencia.grupos_super WHERE BADGE = '" . $badge1 . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    //datos del operador originales
    public function datos_oper2($badge1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO FROM db_asistencia.grupos_super WHERE BADGE = '" . $badge1. "' AND RESPONSABLE = '" . $super1. "';";
        $sql = "SELECT NOMBRE,NOMAREA FROM db_asistencia.empleadosareas_v WHERE BADGE = '" . $badge1 . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    //datos del oper turno actual
    public function datos_oper3($badge1)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //$sql = "SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO FROM db_asistencia.grupos_super WHERE BADGE = '" . $badge1. "' AND RESPONSABLE = '" . $super1. "';";
        $sql = "SELECT turnooperadora FROM db_asistencia.operadorasturno_c WHERE BADGE = '" . $badge1 . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    //verificar si existe el oper
    public function existe_oper($oper)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT COUNT(badge),RESPONSABLE FROM db_asistencia.grupos_super WHERE badge = '" . $oper . "' GROUP BY RESPONSABLE;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    //actualizar un registro que ya existe
    public function update_registro($resp1, $badge, $nom, $puesto, $puesto2, $puesto3, $puesto4, $puesto5, $area, $estado, $turno)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE db_asistencia.grupos_super SET NOMBRE_TRABAJADOR = '" . strtoupper($nom) . "' , PUESTO = '" . strtoupper($puesto) . "', PUESTO2 = '" . strtoupper($puesto2) . "' , PUESTO3 = '" . strtoupper($puesto3) . "'  , PUESTO4 = '" . strtoupper($puesto4) . "'  , PUESTO4 = '" . strtoupper($puesto5) . "'  , AREA = '" . strtoupper($area) . "' , ESTADO = '" . strtoupper($estado) . "' , RESPONSABLE = '" . strtoupper($resp1) . "' , TURNO = '" . $turno . "'  WHERE BADGE = '" . $badge . "';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    public function update_registro_sup($badge, $turno)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE db_asistencia.supervisores SET TURNO = '" . $turno . "'  WHERE BADGE = '" . $badge . "';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    //insertar un registro nuevo
    public function insertar_registro($resp1, $badge, $nom, $puesto, $puesto2, $puesto3, $puesto4, $puesto5, $area, $estado, $turno)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO db_asistencia.grupos_super (BADGE,NOMBRE_TRABAJADOR,PUESTO,PUESTO2,PUESTO3, PUESTO4, PUESTO5,AREA,ESTADO,TURNO,RESPONSABLE) VALUES ('" . $badge . "','" . strtoupper($nom) . "','" . strtoupper($puesto) . "','" . strtoupper($puesto2) . "','" . strtoupper($puesto3) . "','" . strtoupper($puesto4) . "','" . strtoupper($puesto5) . "','" . strtoupper($area) . "','" . strtoupper($estado) . "','" . $turno . "','" . strtoupper($resp1) . "');";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    // resumen de operadoras del supervisor
    public function fill_resumen($super)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADO,COUNT(1) as TOTAL FROM db_asistencia.grupos_super WHERE RESPONSABLE = '" . $super . "' and nombre_trabajador <> '" . $super . "' GROUP BY ESTADO ORDER BY ESTADO ASC ;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_resumen_all($super)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADO,COUNT(1) as TOTAL FROM db_asistencia.grupos_super WHERE RESPONSABLE in (" . $super . ") GROUP BY ESTADO ORDER BY ESTADO ASC ;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_resumen2($super, $admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        // $sql = "SELECT PUESTO,COUNT(1) as TOTAL FROM db_asistencia.grupos_super WHERE RESPONSABLE = '" . $super . "' GROUP BY PUESTO ORDER BY PUESTO ASC ;";
        $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) as TOTAL FROM (
        SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,d.PUESTO,a.nomarea AS AREA,d.ESTADO,b.turnooperadora AS TURNO,c.supervisor 
                FROM empleadosareas_v a
                LEFT JOIN grupos_super D
                ON a.badge = d.badge
                INNER JOIN operadorasturno_c b
                ON a.badge = b.badge
                INNER JOIN supervisores C 
                ON A.areaempleado = c.areaempleado
                AND b.turnooperadora = c.turno
                AND C.supervisor = '" . $super . "'
                and a.nombre <> '" . $super . "'
                AND C.admin = '" . $admin . "'
                 ORDER BY BADGE ASC) A GROUP BY PUESTO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_resumen2_all($super, $admin)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        // $sql = "SELECT PUESTO,COUNT(1) as TOTAL FROM db_asistencia.grupos_super WHERE RESPONSABLE in (" . $super . ") GROUP BY PUESTO ORDER BY PUESTO ASC ;";
        $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) as TOTAL FROM (
       SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,d.PUESTO,a.nomarea AS AREA,d.ESTADO,b.turnooperadora AS TURNO,c.supervisor 
               FROM empleadosareas_v a
               LEFT JOIN grupos_super D
               ON a.badge = d.badge
               INNER JOIN operadorasturno_c b
               ON a.badge = b.badge
               INNER JOIN supervisores C 
               ON A.areaempleado = c.areaempleado
               AND b.turnooperadora = c.turno
               AND C.admin = '" . $admin . "'
               AND C.supervisor in (" . $super . ") ORDER BY BADGE ASC) A GROUP BY PUESTO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }



    public function fill_marcadassup_all($super, $fecha, $radio)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT distinct A.BADGE,A.SUPERVISOR,B.PUESTO,B.AREA,B.ESTADO,C.HORA,B.TURNO
        FROM SUPERVISORES A
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
        WHERE ADMIN = '" . $super . "' 
        AND C.E_S = '" . $radio . "'
        AND C.FECHAMOVIMIENTO = '" . $fecha . "' ";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_marcadassup_no_all($super, $fecha, $radio)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT DISTINCT BADGE,SUPERVISOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO FROM (SELECT A.BADGE,A.SUPERVISOR,B.PUESTO,B.AREA,B.ESTADO,B.TURNO,
         (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
        FROM SUPERVISORES A
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
        WHERE ADMIN = '" . $super . "' 
        ) A WHERE CT IS NULL;";


        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    // datos de la vista de sistema de marcadas
    public function fill_marcadas($super, $fecha, $area, $badge, $radio, $admin)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor = '" . $super . "' 
                 AND A.admin = '" . $admin . "' 
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND C.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor = '" . $super . "' 
                 AND A.admin = '" . $admin . "' 
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND B.PUESTO LIKE '%" . $area . "%' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND C.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }

    public function fill_marcadas_resumen($super, $fecha, $area, $badge, $radio, $admin)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM 
        (SELECT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor = '" . $super . "' 
                 AND A.admin = '" . $admin . "' 
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND C.E_S = '" . $radio . "') B GROUP BY PUESTO ASC;";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM 
        (SELECT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor = '" . $super . "' 
                 AND A.admin = '" . $admin . "' 
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND B.PUESTO LIKE '%" . $area . "%' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND C.E_S = '" . $radio . "') B GROUP BY PUESTO ASC;";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }

    // datos de la vista de sistema de  no marcadas
    public function fill_marcadas_no($super, $fecha, $area, $badge, $radio)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();


            // $sql = "SELECT DISTINCT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO FROM (
            //     SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,
            //     (SELECT COUNT(1) FROM ASISTENCIA_TURNO B WHERE B.BADGE = A.BADGE AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND B.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor = '" . $super . "') A WHERE CT = 0  AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";

            // $sql = "SELECT * FROM (
            // SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,
            // (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor = '" . $super . "'
            // ) A WHERE CT IS NULL AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";


            $sql = "SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
            FROM view_area A
            LEFT JOIN GRUPOS_SUPER B
            ON A.BADGE = B.BADGE
            WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
            AND  A.supervisor = '" . $super . "'
            AND A.BADGE LIKE '%" . $badge . "%'  ORDER BY A.AREA, B.PUESTO, A.BADGE ASC;";



            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT DISTINCT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO FROM (
            //     SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,
            //     (SELECT COUNT(1) FROM ASISTENCIA_TURNO B WHERE B.BADGE = A.BADGE AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND B.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor = '" . $super . "') A WHERE CT = 0 AND PUESTO LIKE '%" . $area . "%' AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";


            // $sql = "SELECT * FROM (
            // SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,
            // (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor = '" . $super . "'
            // ) A WHERE CT IS NULL AND PUESTO LIKE '%" . $area . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";


            $sql = "SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
                    FROM view_area A
                     LEFT JOIN GRUPOS_SUPER B
                    ON A.BADGE = B.BADGE
                      WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
                      AND  A.supervisor = '" . $super . "'
                     AND A.BADGE LIKE '%" . $badge . "%' AND B.PUESTO LIKE '%" . $area . "%' ORDER BY A.AREA, B.PUESTO, A.BADGE ASC;";


            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }

    public function fill_marcadas_no_resumen($super, $fecha, $area, $badge, $radio)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT * FROM (
            // SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,
            // (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor = '" . $super . "'
            // ) A WHERE CT IS NULL AND BADGE LIKE '%" . $badge . "%') B GROUP BY PUESTO;";



            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
FROM view_area A
LEFT JOIN GRUPOS_SUPER B
ON A.BADGE = B.BADGE
WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
AND  A.supervisor = '" . $super . "'
AND A.BADGE LIKE '%" . $badge . "%'  ORDER BY A.AREA, B.PUESTO, A.BADGE ASC) B GROUP BY PUESTO;";


            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();


            // $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT * FROM (
            // SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO as PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,
            // (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor = '" . $super . "'
            // ) A WHERE CT IS NULL AND PUESTO LIKE '%" . $badge . "%') B GROUP BY PUESTO ASC;";


            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
FROM view_area A
 LEFT JOIN GRUPOS_SUPER B
ON A.BADGE = B.BADGE
  WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
  AND  A.supervisor = '" . $super . "'
 AND A.BADGE LIKE '%" . $badge . "%' AND B.PUESTO LIKE '%" . $area . "%' ORDER BY A.AREA, B.PUESTO, A.BADGE ASC) B GROUP BY PUESTO ASC;";


            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }

    public function fill_marcadas_all($super, $fecha, $area, $badge, $radio)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT DISTINCT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor in (" . $super . ")  
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND C.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT DISTINCT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor  in (" . $super . ")   
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND B.PUESTO LIKE '%" . $area . "%' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND C.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }

    public function fill_marcadas_all_resumen($super, $fecha, $area, $badge, $radio, $admin)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor in (" . $super . ")  
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND A.ADMIN = '" . $admin . "' 
                 AND C.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC) B GROUP BY PUESTO ASC;";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT A.BADGE,A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,B.HORA,A.TURNO 
            //  FROM GRUPOS_SUPER A LEFT JOIN ASISTENCIA_TURNO B ON A.BADGE = B.BADGE 
            //  WHERE A.RESPONSABLE = '" . $super . "' AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND A.AREA LIKE '%" . $area . "%' AND A.BADGE LIKE '%" . $badge . "%' AND B.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC;";
            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT a.badge as BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,a.supervisor 
        FROM view_area a
        LEFT JOIN GRUPOS_SUPER B
        ON A.BADGE = B.BADGE
        LEFT JOIN ASISTENCIA_TURNO C
        ON A.BADGE = C.BADGE
                 WHERE A.supervisor  in (" . $super . ")   
                 AND C.FECHAMOVIMIENTO = '" . $fecha . "' 
                 AND B.PUESTO LIKE '%" . $area . "%' 
                 AND A.BADGE LIKE '%" . $badge . "%' 
                 AND A.ADMIN = '" . $admin . "' 
                 AND C.E_S = '" . $radio . "' ORDER BY AREA, PUESTO, BADGE ASC) B GROUP BY PUESTO ASC;";
            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }

    public function fill_marcadas_no_all($super, $fecha, $area, $badge, $radio)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT DISTINCT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO,SUPERVISOR FROM (
            //     SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,
            //     (SELECT COUNT(1) FROM ASISTENCIA_TURNO B WHERE B.BADGE = A.BADGE AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND B.E_S = '" . $radio . "') AS CT,a.supervisor
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor in (" . $super. ")) A WHERE CT = 0  AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";

            // $sql = "SELECT * FROM (
            //     SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,A.supervisor AS SUPERVISOR,
            //     (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            //     FROM view_area a
            //     LEFT JOIN GRUPOS_SUPER B
            //     ON A.BADGE = B.BADGE
            //     LEFT JOIN ASISTENCIA_TURNO C
            //     ON A.BADGE = C.BADGE
            //     WHERE A.supervisor in (" . $super. ")
            //     ) A WHERE CT IS NULL AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";


            $sql = "SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
    FROM view_area A
    LEFT JOIN GRUPOS_SUPER B
    ON A.BADGE = B.BADGE
    WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
    AND A.supervisor IN (" . $super . ")
    AND A.BADGE LIKE '%" . $badge . "%'  ORDER BY A.AREA, B.PUESTO, A.BADGE ASC;";

            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT DISTINCT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO,SUPERVISOR FROM (
            //     SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,
            //     (SELECT COUNT(1) FROM ASISTENCIA_TURNO B WHERE B.BADGE = A.BADGE AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND B.E_S = '" . $radio . "') AS CT,A.supervisor 
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor in (" . $super. ")) A WHERE CT = 0 AND PUESTO LIKE '%" . $area . "%' AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";

            // $sql = "SELECT * FROM (
            //     SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,A.supervisor AS SUPERVISOR,
            //     (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            //     FROM view_area a
            //     LEFT JOIN GRUPOS_SUPER B
            //     ON A.BADGE = B.BADGE
            //     LEFT JOIN ASISTENCIA_TURNO C
            //     ON A.BADGE = C.BADGE
            //     WHERE A.supervisor in (" . $super. ")
            //     ) A WHERE CT IS NULL AND PUESTO LIKE '%" . $area . "%' AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";

            $sql = "SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
    FROM view_area A
    LEFT JOIN GRUPOS_SUPER B
    ON A.BADGE = B.BADGE
    WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
    AND A.supervisor IN (" . $super . ")
    AND A.BADGE LIKE '%" . $badge . "%' AND B.PUESTO LIKE '%" . $area . "%'  ORDER BY A.AREA, B.PUESTO, A.BADGE ASC;";

            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }

    public function fill_marcadas_no_all_resumen($super, $fecha, $area, $badge, $radio)
    {
        if ($area == '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT DISTINCT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO,SUPERVISOR FROM (
            //     SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,
            //     (SELECT COUNT(1) FROM ASISTENCIA_TURNO B WHERE B.BADGE = A.BADGE AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND B.E_S = '" . $radio . "') AS CT,a.supervisor
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor in (" . $super. ")) A WHERE CT = 0  AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";

            //         $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT * FROM (
            // SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,A.supervisor AS SUPERVISOR,
            // (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor in (" . $super . ")
            // ) A WHERE CT IS NULL AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC) B GROUP BY PUESTO ASC;";


            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
    FROM view_area A
    LEFT JOIN GRUPOS_SUPER B
    ON A.BADGE = B.BADGE
    WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
    AND A.supervisor IN (" . $super . ")
    AND A.BADGE LIKE '%" . $badge . "%'  ORDER BY A.AREA, B.PUESTO, A.BADGE ASC) B GROUP BY PUESTO ASC;";


            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        } else {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            // $sql = "SELECT DISTINCT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO,SUPERVISOR FROM (
            //     SELECT a.BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,C.HORA,a.turnooperadora AS TURNO,
            //     (SELECT COUNT(1) FROM ASISTENCIA_TURNO B WHERE B.BADGE = A.BADGE AND B.FECHAMOVIMIENTO = '" . $fecha . "' AND B.E_S = '" . $radio . "') AS CT,A.supervisor 
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor in (" . $super. ")) A WHERE CT = 0 AND PUESTO LIKE '%" . $area . "%' AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC;";

            //         $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT * FROM (
            // SELECT DISTINCT a.BADGE AS BADGE,a.nombre AS NOMBRE_TRABAJADOR,B.PUESTO,a.nomarea AS AREA,B.ESTADO,'--:--:--' AS HORA,a.turnooperadora AS TURNO,A.supervisor AS SUPERVISOR,
            // (SELECT SUM(D.F) FROM MARC_CT D WHERE A.BADGE = D.BADGE AND D.FECHAMOVIMIENTO = '" . $fecha . "' AND D.E_S = '" . $radio . "') AS CT
            // FROM view_area a
            // LEFT JOIN GRUPOS_SUPER B
            // ON A.BADGE = B.BADGE
            // LEFT JOIN ASISTENCIA_TURNO C
            // ON A.BADGE = C.BADGE
            // WHERE A.supervisor in (" . $super . ")
            // ) A WHERE CT IS NULL AND PUESTO LIKE '%" . $area . "%' AND BADGE LIKE '%" . $badge . "%'  ORDER BY AREA, PUESTO, BADGE ASC) B GROUP BY PUESTO ASC;";



            $sql = "SELECT (CASE WHEN PUESTO IS NULL THEN 'NUEVO' ELSE PUESTO END) AS PUESTO, COUNT(1) AS TOTAL FROM (SELECT DISTINCT A.BADGE AS BADGE, A.NOMBRE AS NOMBRE_TRABAJADOR,B.PUESTO AS PUESTO, A.NOMAREA AS AREA,B.ESTADO AS ESTADO ,'--:--:--' AS HORA,a.turnooperadora AS TURNO, A.SUPERVISOR AS SUPERVISOR
    FROM view_area A
    LEFT JOIN GRUPOS_SUPER B
    ON A.BADGE = B.BADGE
    WHERE A.badge NOT IN (SELECT C.badge FROM asistencia_turno C WHERE C.fechamovimiento =  '" . $fecha . "'  AND C.e_s = '" . $radio . "')
    AND A.supervisor IN (" . $super . ")
    AND A.BADGE LIKE '%" . $badge . "%' AND B.PUESTO LIKE '%" . $area . "%'  ORDER BY A.AREA, B.PUESTO, A.BADGE ASC) B GROUP BY PUESTO ASC;";


            $resultado = mysqli_query($conexion, $sql);
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            mysqli_close($conexion);
        }
    }


    // public function fill_marcadas_no_ct($super, $fecha)
    // {
    //     $obj = new conectar();
    //     $conexion = $obj->conexionMySQL();

    //     $sql = "SELECT COUNT(1) FROM (SELECT BADGE,NOMBRE_TRABAJADOR,PUESTO,AREA,ESTADO,'--:--:--' AS HORA,TURNO FROM (
    //         SELECT A.BADGE, A.NOMBRE_TRABAJADOR,A.PUESTO,A.AREA,A.ESTADO,A.TURNO,
    //         (SELECT COUNT(1) FROM ASISTENCIA_TURNO B WHERE B.BADGE = A.BADGE AND B.FECHAMOVIMIENTO = '" . $fecha . "') AS CT
    //         FROM GRUPOS_SUPER A 
    //         WHERE A.RESPONSABLE = '" . $super . "'  ) A WHERE CT = 0) B;";
    //     $resultado = mysqli_query($conexion, $sql);
    //     return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    //     mysqli_close($conexion);
    // }

    public function obtenertipo($oper)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT tipo from db_asistencia.tipo_personal where badge = '" . $oper . "';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    //insertar un registro nuevo a logs
    public function insertar_log($supervisor, $fecha, $fecha_s, $fecha_s2, $oper, $nombre, $area, $observacion, $notas, $tipo, $septimo, $ndias, $nhoras, $nmins, $horaini, $horafin, $turno, $ajuste, $newfilename, $rol)
    {

        date_default_timezone_set('America/Tegucigalpa');
        $fecha2 = date('Y-m-d');

        // TIPO DE EXENTO O MARCA
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT tipo from db_asistencia.tipo_personal where badge = '" . $oper . "';";
        $resultado = mysqli_query($conexion, $sql);
        $tipo_res = mysqli_fetch_row($resultado);
        mysqli_close($conexion);
        $tipo2 = $tipo_res[0];

        // T O F PARA SABER SI ES SUPERINTENDENTE QUE NO PUEDE MANDAR A REVISADO 
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        $sql = "SELECT rest_revisado from db_asistencia.credenciales where descripcion like  '%" . $supervisor . "%';";
        $resultado = mysqli_query($conexion, $sql);
        $tipo_res2 = mysqli_fetch_row($resultado);
        mysqli_close($conexion);
        $rest = $tipo_res2[0];


        if ($tipo2 == 'M') {
            if ($observacion != "HORAS EXTRAS") {
                if ($rol == 'A' && $rest == 'F') {
                    if ($horaini == '') {
                        $obj = new conectar();
                        $conexion = $obj->conexionMySQL();
                        $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,PAGAR,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,TURNO,AJUSTE,COMPROBANTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . strtoupper($septimo) . "','" . $ndias . "','" . $nhoras . "','" . $nmins . "','REVISADO','" . $turno . "','" . $ajuste . "','" . $newfilename . "','" . $tipo2 . "','" . $fecha2 . "');";
                        mysqli_query($conexion, $sql);
                        mysqli_close($conexion);
                    } else {
                        $obj = new conectar();
                        $conexion = $obj->conexionMySQL();
                        $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,PAGAR,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . strtoupper($septimo) . "','" . $ndias . "','" . $nhoras . "','" . $nmins . "','REVISADO','" . $horaini . "','" . $horafin . "','" . $turno . "','" . $ajuste . "','" . $newfilename . "','" . $tipo2 . "','" . $fecha2 . "');";
                        mysqli_query($conexion, $sql);
                        mysqli_close($conexion);
                    }
                } else if ($rol == 'A' && $rest == 'T') {
                    if ($horaini == '') {
                        $obj = new conectar();
                        $conexion = $obj->conexionMySQL();
                        $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,PAGAR,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,TURNO,AJUSTE,COMPROBANTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . strtoupper($septimo) . "','" . $ndias . "','" . $nhoras . "','" . $nmins . "','CREADO','" . $turno . "','" . $ajuste . "','" . $newfilename . "','" . $tipo2 . "','" . $fecha2 . "');";
                        mysqli_query($conexion, $sql);
                        mysqli_close($conexion);
                    } else {
                        $obj = new conectar();
                        $conexion = $obj->conexionMySQL();
                        $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,PAGAR,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . strtoupper($septimo) . "','" . $ndias . "','" . $nhoras . "','" . $nmins . "','CREADO','" . $horaini . "','" . $horafin . "','" . $turno . "','" . $ajuste . "','" . $newfilename . "','" . $tipo2 . "','" . $fecha2 . "');";
                        mysqli_query($conexion, $sql);
                        mysqli_close($conexion);
                    }
                } else if ($rol == 'M' || $rol == 'S') {
                    if ($horaini == '') {
                        $obj = new conectar();
                        $conexion = $obj->conexionMySQL();
                        $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,PAGAR,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,TURNO,AJUSTE,COMPROBANTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . strtoupper($septimo) . "','" . $ndias . "','" . $nhoras . "','" . $nmins . "','CREADO','" . $turno . "','" . $ajuste . "','" . $newfilename . "','" . $tipo2 . "','" . $fecha2 . "');";
                        mysqli_query($conexion, $sql);
                        mysqli_close($conexion);
                    } else {
                        $obj = new conectar();
                        $conexion = $obj->conexionMySQL();
                        $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,PAGAR,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . strtoupper($septimo) . "','" . $ndias . "','" . $nhoras . "','" . $nmins . "','CREADO','" . $horaini . "','" . $horafin . "','" . $turno . "','" . $ajuste . "','" . $newfilename . "','" . $tipo2 . "','" . $fecha2 . "');";
                        mysqli_query($conexion, $sql);
                        mysqli_close($conexion);
                    }
                }
            } else {
            }
        }
    }



    public function  insertar_log_extras($supervisor, $fecha, $fecha_s, $fecha_s2, $oper, $nombre, $area, $observacion, $notas, $tipo, $nhoras, $horaini, $horafin, $turno, $ajuste, $rol)
    {

        date_default_timezone_set('America/Tegucigalpa');
        $fecha2 = date('Y-m-d');

        // TIPO DE EXENTO O MARCA
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT tipo from db_asistencia.tipo_personal where badge = '" . $oper . "';";
        $resultado = mysqli_query($conexion, $sql);
        $tipo_res = mysqli_fetch_row($resultado);
        mysqli_close($conexion);
        $tipo2 = $tipo_res[0];

        // T O F PARA SABER SI ES SUPERINTENDENTE QUE NO PUEDE MANDAR A REVISADO 
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        $sql = "SELECT rest_revisado from db_asistencia.credenciales where descripcion like  '%" . $supervisor . "%';";
        $resultado = mysqli_query($conexion, $sql);
        $tipo_res2 = mysqli_fetch_row($resultado);
        mysqli_close($conexion);
        $rest = $tipo_res2[0];


        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT esgerente from db_asistencia.credenciales where descripcion like  '%" . $supervisor . "%';";
        $resultado3 = mysqli_query($conexion, $sql);
        $tipo_res4 = mysqli_fetch_row($resultado3);
        mysqli_close($conexion);
        $gerente = $tipo_res4[0];


        if ($rol == 'A' && $rest == 'F' && $gerente == 'N') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,NUMERO_HORAS,ESTADO,HINI,HFIN,TURNO,AJUSTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . $nhoras . "','REVISION','" . $horaini . "','" . $horafin . "','" . $turno . "','OV','" . $tipo2 . "','" . $fecha2 . "');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        } else if ($rol == 'A' && $rest == 'T' && $gerente == 'N') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,NUMERO_HORAS,ESTADO,HINI,HFIN,TURNO,AJUSTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . $nhoras . "','CREADO','" . $horaini . "','" . $horafin . "','" . $turno . "','OV','" . $tipo2 . "','" . $fecha2 . "');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        } else if ($rol == 'A' && $rest == 'F' && $gerente == 'S') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,NUMERO_HORAS,ESTADO,HINI,HFIN,TURNO,AJUSTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . $nhoras . "','REVISADO','" . $horaini . "','" . $horafin . "','" . $turno . "','OV','" . $tipo2 . "','" . $fecha2 . "');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        } else if ($rol == 'M' || $rol == 'S') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.log_asistencia (SUPERVISOR,FECHA,FECHA_INGRESO,FECHA_FINAL,OPERARIO,NOMBRE,AREA,OBSERVACION,NOTAS,ES,NUMERO_HORAS,ESTADO,HINI,HFIN,TURNO,AJUSTE,TIPO_PERSONAL,FECHA_REVISION) VALUES ('" . strtoupper($supervisor) . "','" . $fecha . "','" . $fecha_s . "','" . $fecha_s2 . "','" . $oper . "','" . strtoupper($nombre) . "','" . strtoupper($area) . "','" . strtoupper($observacion) . "','" . strtoupper($notas) . "','" . strtoupper($tipo) . "','" . $nhoras . "','CREADO','" . $horaini . "','" . $horafin . "','" . $turno . "','OV','" . $tipo2 . "','" . $fecha2 . "');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }
    }




    // datos logs guardados por supervisores
    // public function fill_logs($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per)
    // {
    //     $obj = new conectar();
    //     $conexion = $obj->conexionMySQL();

    //     $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') as FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY)  AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' ORDER BY idreg DESC;";
    //     $resultado = mysqli_query($conexion, $sql);
    //     return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    //     mysqli_close($conexion);
    // }

    // public function fill_logs_in($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per)
    // {
    //     $obj = new conectar();
    //     $conexion = $obj->conexionMySQL();

    //     $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') as FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . " 00:00:00' AND FECHA <= DATE_ADD('" . $fechaf . ", INTERVAL 1 DAY) 23:59:00' AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA IN (" . $area . ") AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%'  ORDER BY idreg DESC;";
    //     $resultado = mysqli_query($conexion, $sql);
    //     return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    //     mysqli_close($conexion);
    // }


    public function fill_logs_sup($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden)
    {

        // echo "<script>console.log('Debug Objects: " . $super . "' );</script>";

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($orden == 1) {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') as FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA > '" . $fecha . "' AND FECHA <=  DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY)  AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%'  ORDER BY idreg DESC;";
        } else {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') as FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA_INGRESO > '" . $fecha . "' AND FECHA_INGRESO <=  DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY)  AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%'  ORDER BY idreg DESC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_logs_all($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        if ($orden == 1) {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%'  ORDER BY idreg DESC;";
        } else {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA_INGRESO >= '" . $fecha . "' AND FECHA_INGRESO <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%'  ORDER BY idreg DESC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function fill_logs_in_all($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($orden == 1) {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA IN (" . $area . ") AND AJUSTE LIKE '%" . $ajuste . "%'  AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%'  ORDER BY idreg DESC;";
        } else {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA_INGRESO >= '" . $fecha . "' AND FECHA_INGRESO <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA IN (" . $area . ") AND AJUSTE LIKE '%" . $ajuste . "%'  AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%'  ORDER BY idreg DESC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_logs_all_noext($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($orden == 1) {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION <> 'HORAS EXTRAS' ORDER BY idreg DESC;";
        } else {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA_INGRESO >= '" . $fecha . "' AND FECHA_INGRESO <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION <> 'HORAS EXTRAS' ORDER BY idreg DESC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_logs_in_all_noext($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($orden == 1) {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA IN (" . $area . ") AND AJUSTE LIKE '%" . $ajuste . "%'  AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION <> 'HORAS EXTRAS' ORDER BY idreg DESC;";
        } else {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA_INGRESO >= '" . $fecha . "' AND FECHA_INGRESO <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA IN (" . $area . ") AND AJUSTE LIKE '%" . $ajuste . "%'  AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION <> 'HORAS EXTRAS' ORDER BY idreg DESC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function fill_logs_all_ext($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($orden == 1) {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION = 'HORAS EXTRAS' ORDER BY idreg DESC;";
        } else {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA_INGRESO >= '" . $fecha . "' AND FECHA_INGRESO <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' AND AJUSTE LIKE '%" . $ajuste . "%' AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION = 'HORAS EXTRAS' ORDER BY idreg DESC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_logs_in_all_ext($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        if ($orden == 1) {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA IN (" . $area . ") AND AJUSTE LIKE '%" . $ajuste . "%'  AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION = 'HORAS EXTRAS' ORDER BY idreg DESC;";
        } else {
            $sql = "SELECT IDREG,DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,SUPERVISOR,DATE_FORMAT(FECHA_INGRESO,'%d/%m/%Y') AS FECHA_INGRESO,DATE_FORMAT(FECHA_FINAL,'%d/%m/%Y') AS FECHA_FINAL,OPERARIO,trim(NOMBRE) as NOMBRE,AREA,OBSERVACION,NOTAS,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,ESTADO,DATE_FORMAT(FECHA_REVISION,'%d/%m/%Y') AS FECHA_REVISION,HINI,HFIN,TURNO,AJUSTE,COMPROBANTE FROM db_asistencia.log_asistencia  WHERE SUPERVISOR in (" . $super . ") AND FECHA_INGRESO >= '" . $fecha . "' AND FECHA_INGRESO <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY) AND OPERARIO LIKE '%" . $badge . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA IN (" . $area . ") AND AJUSTE LIKE '%" . $ajuste . "%'  AND TIPO_PERSONAL LIKE '%" . $tipo_per . "%' AND OBSERVACION = 'HORAS EXTRAS' ORDER BY idreg DESC;";
        }
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function fill_logs_resumen($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADO,COUNT(1) AS CT FROM db_asistencia.log_asistencia  WHERE SUPERVISOR = '" . $super . "' AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY)  AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%' GROUP BY ESTADO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function fill_logs_resumen_all($super, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT ESTADO,COUNT(1) AS CT FROM db_asistencia.log_asistencia  WHERE SUPERVISOR like '%" . $super . "%' AND FECHA >= '" . $fecha . "' AND FECHA <= DATE_ADD('" . $fechaf . "', INTERVAL 1 DAY)  AND OPERARIO LIKE '%" . $badge . "%' AND OBSERVACION LIKE '%" . $obs . "%' AND ESTADO LIKE '%" . $estado2 . "%' AND TURNO LIKE '%" . $turno . "%' AND AREA LIKE '%" . $area . "%'  GROUP BY ESTADO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    // cuenta de datos para notas
    public function get_cuenta_notas($super, $fecha, $oper2)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT IDREG FROM log_Asistencia WHERE SUPERVISOR = '" . $super . "' AND FECHA_INGRESO LIKE '%" . $fecha . "%' AND OPERARIO = '" . $oper2 . "'";
        $sql = "SELECT IDREG FROM log_Asistencia WHERE FECHA_INGRESO LIKE '%" . $fecha . "%' AND OPERARIO = '" . $oper2 . "'  AND OBSERVACION <> 'HORAS EXTRAS';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function get_cuenta_notas2($super, $fecha, $oper2, $ES)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT IDREG FROM log_Asistencia WHERE SUPERVISOR = '" . $super . "' AND FECHA_INGRESO LIKE '%" . $fecha . "%' AND OPERARIO = '" . $oper2 . "' AND ES = '" . $ES . "' ";
        $sql = "SELECT IDREG FROM log_Asistencia WHERE  FECHA_INGRESO LIKE '%" . $fecha . "%' AND OPERARIO = '" . $oper2 . "' AND ES = '" . $ES . "'  AND OBSERVACION <> 'HORAS EXTRAS'";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }


    public function get_cuenta_notas3($super, $fecha, $oper2)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        // $sql = "SELECT IDREG FROM log_Asistencia WHERE SUPERVISOR = '" . $super . "' AND FECHA_INGRESO LIKE '%" . $fecha . "%' AND OPERARIO = '" . $oper2 . "'";
        $sql = "SELECT IDREG FROM log_Asistencia WHERE FECHA_INGRESO LIKE '%" . $fecha . "%' AND OPERARIO = '" . $oper2 . "' AND OBSERVACION = 'HORAS EXTRAS';";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    // obtiene nota clicked
    public function get_nota_click($idr)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        $sql = "SELECT OBSERVACION,NOTAS,FECHA_INGRESO,FECHA_FINAL,NUMERO_DIAS,NUMERO_HORAS,NUMERO_MINUTOS,PAGAR FROM log_Asistencia WHERE IDREG = '" . $idr . "'";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }


    public function get_nota_click2($idr)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        $sql = "SELECT NOTAS,FECHA_INGRESO,FECHA_FINAL,HINI,HFIN,NUMERO_HORAS FROM log_Asistencia WHERE IDREG = '" . $idr . "'";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_row($resultado);
        mysqli_close($conexion);
    }

    public function llenar_detalles($sup, $badge, $fini, $ffin, $querycr)
    {

        //aqui hay que construir las fechas para armar el query a correr fini a ffin

        //
        //
        ///
        //

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        //     $sql = "SELECT BADGE, OPER,
        //  " . $querycr . "
        // FROM (
        // SELECT A.badge AS BADGE,A.NOMBRE_TRABAJADOR AS OPER,b.fechamovimiento AS FMOV,b.hora AS HORA,b.e_s AS ES
        // FROM grupos_super A, asistencia_turno B 
        // WHERE A.responsable = '" . $sup . "'
        // AND A.BADGE  LIKE '%" . $badge . "%'
        // AND A.BADGE = B.BADGE
        // AND b.fechamovimiento >= '" . $fini . "' 
        // AND b.fechamovimiento <= '" . $ffin . "'
        // AND b.e_s IN ('E','S')
        // ORDER BY b.fechamovimiento ASC) Z GROUP BY BADGE, OPER;";



        $sql = "SELECT BADGE, OPER,
    " . $querycr . "
   FROM (
   SELECT A.badge AS BADGE,A.NOMBRE AS OPER,b.fechamovimiento AS FMOV,b.hora AS HORA,b.e_s AS ES
   FROM view_area A, asistencia_turno B 
   WHERE A.supervisor = '" . $sup . "'
   AND A.BADGE  LIKE '%" . $badge . "%'
   AND A.BADGE = B.BADGE
   AND b.fechamovimiento >= '" . $fini . "' 
   AND b.fechamovimiento <= '" . $ffin . "'
   AND b.e_s IN ('E','S')
   ORDER BY b.fechamovimiento ASC) Z GROUP BY BADGE, OPER;";


        $resultado = mysqli_query($conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function llenar_detalles_cronos($sup, $badge, $fini, $ffin)
    {


        $obj = new conectar();
        $conexion = $obj->conexionMySQL();


        $sql = "SELECT DISTINCT a.BADGE, a.EMPLEADO, a.TURNO, a.AREA, DATE_FORMAT(FECHA,'%d/%m/%y') AS FECHA, a.DIA, H_ENTRADA, H_SALIDA,LEFT(b.SUPERVISOR,10) AS SUPERVISOR
        FROM ENTRADAS_SALIDAS a, view_area b
        WHERE a.FECHA >= '" . $fini . "' 
        AND a.FECHA <=  '" . $ffin . "'
        AND a.badge = b.badge
        AND a.turno = b.turnooperadora
        and a.badge like '%" . $badge . "%'
        AND b.supervisor in (" . $sup . ")
        ORDER BY b.supervisor,a.badge,a.fecha ASC;";



        $sql = "SELECT DISTINCT a.BADGE, a.EMPLEADO, C.turnooperadora AS TURNO, a.AREA, DATE_FORMAT(FECHA,'%d/%m/%y') AS FECHA, a.DIA, H_ENTRADA, H_SALIDA,LEFT(b.SUPERVISOR,10) AS SUPERVISOR
        FROM ENTRADAS_SALIDAS a,operadorasturno c, view_area b
        WHERE a.FECHA >= '" . $fini . "' 
        AND a.FECHA <=  '" . $ffin . "'
        AND a.badge = c.badge
        AND c.badge = b.badge
        AND c.turnooperadora = b.turnooperadora
        AND b.supervisor in (" . $sup . ")
        AND a.badge like '%" . $badge . "%'
        ORDER BY b.supervisor,a.badge,a.fecha ASC;";

        $resultado = mysqli_query($conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }



    public function bitacora_update($accion, $super, $fechahora, $operario, $puesto, $estado2, $transfer)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO db_asistencia.bitacora (ACCION,SUPER,FECHAHORA,OPERARIO,PUESTO,ESTADO,TRANSFERS) VALUES ('" . strtoupper($accion) . "','" . $super . "','" . $fechahora . "','" . $operario . "','" . strtoupper($puesto) . "','" . strtoupper($estado2) . "','" . strtoupper($transfer) . "');";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    public function grafs_wk_ausentismo($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',WEEK(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'AUSENCIA INJUSTIFICADA' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY WEEK(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_mth_ausentismo($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',MONTH(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'AUSENCIA INJUSTIFICADA' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY MONTH(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function grafs_dly_ausentismo($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT FECHA_INGRESO AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'AUSENCIA INJUSTIFICADA' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY FECHA_INGRESO
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_wk_tardias($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',WEEK(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'ENTRADA TARDIA' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY WEEK(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function grafs_mth_tardias($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',MONTH(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'ENTRADA TARDIA' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY MONTH(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_dly_tardias($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT FECHA_INGRESO AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'ENTRADA TARDIA' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY FECHA_INGRESO
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_wk_incapa($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',WEEK(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION like '%INCAPACIDAD%' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY WEEK(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_mth_incapa($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',MONTH(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION like '%INCAPACIDAD%' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY MONTH(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_dly_incapa($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT FECHA_INGRESO AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION like '%INCAPACIDAD%' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY FECHA_INGRESO
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }





    public function grafs_wk_permisos($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',WEEK(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'PERMISO PERSONAL' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY WEEK(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_mth_permisos($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT CONCAT(YEAR(FECHA_INGRESO),'-',MONTH(FECHA_INGRESO)) AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'PERMISO PERSONAL' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY MONTH(FECHA_INGRESO)
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }

    public function grafs_dly_permisos($fini, $ffin, $sup)
    {

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "SELECT FECHA_INGRESO AS YW,COUNT(1) AS CT 
        FROM db_asistencia.log_asistencia
        WHERE OBSERVACION = 'PERMISO PERSONAL' 
        AND FECHA_INGRESO BETWEEN '" . $fini . "' AND '" . $ffin . "'
        AND SUPERVISOR LIKE '%" . $sup . "%'
        GROUP BY FECHA_INGRESO
        ORDER BY FECHA_INGRESO ASC;";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_close($conexion);
    }


    public function borrar_puesto_over($badge)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "DELETE FROM db_asistencia.empleadosareas_over WHERE BADGE = '" . $badge . "';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }


    public function insertar_puesto_over($badge, $areaempleado, $nomarea, $user, $anterior)
    {
        date_default_timezone_set('America/Tegucigalpa');
        $fecha = date('Y-m-d H:i:s');
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "INSERT INTO db_asistencia.empleadosareas_over (BADGE,AREAEMPLEADO,NOMAREA,AGREGADO,MODIFICO,ANTERIOR) VALUES ('" . $badge . "','" . $areaempleado . "','" . $nomarea . "','" . $fecha . "','" . $user . "','" . $anterior . "');";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    public function cambiar_contra($user, $pass)
    {
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE db_asistencia.credenciales SET pass_sup = SHA('" . $pass . "') WHERE supervisor = '" . $user . "';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }


    public function actualizar_estado($boxes, $sup, $boxes2, $boxes3, $boxes4)
    {

        // T O F PARA SABER SI ES SUPERINTENDENTE QUE NO PUEDE MANDAR A REVISADO 
        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT rest_revisado from db_asistencia.credenciales where descripcion like  '%" . $sup . "%';";
        $resultado = mysqli_query($conexion, $sql);
        $tipo_res2 = mysqli_fetch_row($resultado);
        mysqli_close($conexion);
        $rest = $tipo_res2[0];

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT esclerk from db_asistencia.credenciales where descripcion like  '%" . $sup . "%';";
        $resultado2 = mysqli_query($conexion, $sql);
        $tipo_res3 = mysqli_fetch_row($resultado2);
        mysqli_close($conexion);
        $clerk = $tipo_res3[0];

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "SELECT esgerente from db_asistencia.credenciales where descripcion like  '%" . $sup . "%';";
        $resultado3 = mysqli_query($conexion, $sql);
        $tipo_res4 = mysqli_fetch_row($resultado3);
        mysqli_close($conexion);
        $gerente = $tipo_res4[0];

        //actualizar estado admin
        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");

        if ($boxes != '') {
            if ($rest == 'T') {
                $obj = new conectar();
                $conexion = $obj->conexionMySQL();
                $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'REVISION', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes . ") and estado IN ('CREADO');";
                mysqli_query($conexion, $sql);
                mysqli_close($conexion);
            } else if ($rest == 'F') {
                $obj = new conectar();
                $conexion = $obj->conexionMySQL();
                $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'REVISADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes . ") and estado IN ('REVISION','CREADO');";
                mysqli_query($conexion, $sql);
                mysqli_close($conexion);
            }

            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes2 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }

        // HORAS EXTRAS NADA MAS OBLIGAR A REVISION
        if ($boxes3 != '' && $clerk == 'N' && $gerente == 'N') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'REVISION', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes3 . ") and estado IN ('CREADO');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);

            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes4 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        } else if ($boxes3 != '' && $clerk == 'N' && $gerente == 'S') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'REVISADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes3 . ") and estado IN ('CREADO','REVISION');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);

            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes4 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }
    }

    public function actualizar_estado2($boxes, $sup, $boxes2, $boxes3, $boxes4)
    {
        //actualizar estado CLERK O RYM
        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");


        if ($boxes != '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'REVISION', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes . ") and estado IN ('CREADO');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);

            //2DO

            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes2 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }

        if ($boxes3 != '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'REVISADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes3 . ") and estado IN ('CREADO');";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);


            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes4 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }
    }


    public function procesar_estado($boxes, $sup, $boxes2)
    {
        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'PROCESADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes . ") and estado = 'REVISADO';";
        mysqli_query($conexion, $sql);

        mysqli_close($conexion);

        //2DO

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes2 . ";";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    public function procesado_extras($sup, $boxes3, $boxes4)
    {
        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'PROCESADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes3 . ") and estado = 'REVISADO' and observacion = 'HORAS EXTRAS';";
        mysqli_query($conexion, $sql);

        mysqli_close($conexion);

        //2DO

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes4 . ";";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    public function revisado_extras($sup, $boxes3, $boxes4)
    {
        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'REVISADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes3 . ") and estado = 'REVISION' and observacion = 'HORAS EXTRAS';";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);

        //2DO

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes4 . ";";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }


    public function pagado_estado($boxes, $sup, $boxes2, $boxes3, $boxes4)
    {
        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");

        if ($boxes != '') {
            // los de ajsute normal
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'PAGADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes . ") and estado = 'PROCESADO' and AJUSTE = 'SI';";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);


            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes2 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }

        // PROCESADOS POR EDUARDO MONTES

        if ($boxes3 != '') {
            // los de horas extras
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'PAGADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes3 . ") and estado = 'PROCESADO' and observacion = 'HORAS EXTRAS';";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);

            //2DO
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes4 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }
    }

    public function pagado_estado2($boxes, $sup, $boxes2)
    {
        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();

        $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'PAGADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes . ") and estado = 'REVISADO';";
        mysqli_query($conexion, $sql);

        mysqli_close($conexion);

        //2DO

        //2DO

        $obj = new conectar();
        $conexion = $obj->conexionMySQL();
        $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes2 . ";";
        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
    }

    public function cancelar_accion($boxes, $sup, $boxes2, $boxes3, $boxes4)
    {

        date_default_timezone_set('America/Tegucigalpa');
        $fechat =  date("Y-m-d");


        if ($boxes != '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'CANCELADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes . ") AND ESTADO IN ('CREADO','REVISION','REVISADO');";
            mysqli_query($conexion, $sql);

            mysqli_close($conexion);

            //2DO

            //2DO

            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes2 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }

        if ($boxes3 != '') {
            $obj = new conectar();
            $conexion = $obj->conexionMySQL();

            $sql = "UPDATE db_asistencia.log_asistencia SET estado = 'CANCELADO', fecha_revision = '" . $fechat . "' WHERE IDREG IN (" . $boxes3 . ") AND ESTADO IN ('CREADO','REVISION','REVISADO');";
            mysqli_query($conexion, $sql);

            mysqli_close($conexion);

            //2DO

            //2DO

            $obj = new conectar();
            $conexion = $obj->conexionMySQL();
            $sql = "INSERT INTO db_asistencia.bitacora_acciones (ACCION,SUPER,FECHAHORA,IDREG) VALUES " . $boxes4 . ";";
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        }
    }
}
