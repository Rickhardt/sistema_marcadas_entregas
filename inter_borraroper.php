<?php
session_start();



require_once "cfg/conexion.php";
require_once "crud/crud.php";
include "llegadast.php";


$estado = $_POST['estado'];
$info = new crud();




if ($estado == 'LoadPuestos') {
    $badge = $_POST['badge'];
    // $supervisor = $_POST['supervisor'];
    //$result_A = $info->datos_oper($badge, $supervisor);
    $result_A = $info->get_puestos($badge);
    // echo $result_A[0] . ',' . $result_A[1] . ',' . $result_A[2] . ',' . $result_A[3] . ',' . $result_A[4] ;
    echo json_encode($result_A);
}


if ($estado == 'BuscarPuesto') {
    $badge = $_POST['badge'];

    $result_A = $info->get_puestoact($badge);



    foreach ($result_A as $row) {


        $areaactual = $row['NOMBRE'] . ',' . $row['NOMAREA'];
    }

    echo $areaactual;
}


if ($estado == 'Buscarturno') {
    $badge = $_POST['badge'];

    $result_A = $info->get_turno($badge);



    foreach ($result_A as $row) {


        $turno = $row['turnooperadora'];
    }

    echo $turno;
}

if ($estado == 'LoadDataOper') {
    $badge = $_POST['badge'];
    // $supervisor = $_POST['supervisor'];
    //$result_A = $info->datos_oper($badge, $supervisor);
    $result_A = $info->datos_oper($badge);
    // echo $result_A[0] . ',' . $result_A[1] . ',' . $result_A[2] . ',' . $result_A[3] . ',' . $result_A[4] ;
    echo json_encode($result_A);
}


if ($estado == 'LoadDataOper2') {
    $badge = $_POST['badge'];
    // $supervisor = $_POST['supervisor'];
    //$result_A = $info->datos_oper($badge, $supervisor);
    $result_A = $info->datos_oper2($badge);
    // echo $result_A[0] . ',' . $result_A[1] . ',' . $result_A[2] . ',' . $result_A[3] . ',' . $result_A[4] ;
    echo json_encode($result_A);
}

if ($estado == 'LoadDataOper3') {
    $badge = $_POST['badge'];
    // $supervisor = $_POST['supervisor'];
    //$result_A = $info->datos_oper($badge, $supervisor);
    $result_A = $info->datos_oper3($badge);
    // echo $result_A[0] . ',' . $result_A[1] . ',' . $result_A[2] . ',' . $result_A[3] . ',' . $result_A[4] ;
    echo json_encode($result_A);
}


if ($estado == 'BorrarOper') {
    $oper_b = $_POST['oper_b'];
    if ($oper_b != '') {
        $result_B = $info->borrar_operador($oper_b);
        //echo $sup;
        //echo $tn;
        echo 1;
    } else {
        echo 99;
    }
}


if ($estado == 'ExisteOper') {
    $badge = $_POST['badge'];
    $result_c = $info->existe_oper($badge);
    echo json_encode($result_c);
}

if ($estado == 'UpdateOper') {
    $badge1 = $_POST['badge1'];
    $responsable1 = $_POST['responsable1'];
    $nombre1 = $_POST['nombre1'];
    $puesto1 = $_POST['puesto1'];
    $puesto2 = $_POST['puesto2'];
    $puesto3 = $_POST['puesto3'];
    $puesto4 = $_POST['puesto4'];
    $puesto5 = $_POST['puesto5'];
    $area1 = $_POST['area1'];
    $estado1 = $_POST['estado1'];
    $turno1 = $_POST['turno1'];

    $result_d = $info->update_registro($responsable1, $badge1, $nombre1, $puesto1, $puesto2, $puesto3, $puesto4, $puesto5, $area1, $estado1, $turno1);
    $result_d = $info->update_registro_sup($badge1, $turno1);
    echo json_encode($result_d);
}

if ($estado == 'InsertOper') {
    $badge1 = $_POST['badge1'];
    $responsable1 = $_POST['responsable1'];
    $nombre1 = $_POST['nombre1'];
    $puesto1 = $_POST['puesto1'];
    $puesto2 = $_POST['puesto2'];
    $puesto3 = $_POST['puesto3'];
    $puesto4 = $_POST['puesto4'];
    $puesto5 = $_POST['puesto5'];
    $area1 = $_POST['area1'];
    $estado1 = $_POST['estado1'];
    $turno1 = $_POST['turno1'];

    $result_e = $info->insertar_registro($responsable1, $badge1, $nombre1, $puesto1, $puesto2, $puesto3, $puesto4, $puesto5, $area1, $estado1, $turno1);
    echo json_encode($result_e);
}

if ($estado == 'BuscarMarc') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $badge = $_POST['badge'];
    $radio = $_POST['radio'];
    $admin = $_POST['admin'];
    $horareal = '';

    $result_f = $info->fill_marcadas($supervisor, $fecha, $area, $badge, $radio, $admin);

    $tablita = '';



    if ($_POST['fecha'] == '') {
    } elseif (count($result_f) != 0) {





        if ($radio == 'E') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS- </b>:  " . count($result_f) . " MARCADAS !   </label>";
        } else if ($radio == 'S') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO : <b> -SALIDAS- </b>" . count($result_f) . " MARCADAS !   </label>";
        }

        $tablita .=    " </br><table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>



    <tr class='bg-primary'>
    <th scope='col'>BADGE</th>
    <th scope='col'>OPERADORA</th>
    <th scope='col'>PUESTO</th>
    <th scope='col'>AREA</th>
    <th scope='col'>ESTADO</th>
    <th scope='col'>HORA</th>
    <th scope='col'>TURNO</th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
     </tr> ";

        foreach ($result_f as $row) {

            # code...

            $horareal = llegadast($row['TURNO'], $row['HORA'], $fecha, $radio);

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td class='text-" . $horareal . "'>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-turno='" . $row['TURNO'] . "' data-ajuste='NO'>ACCIONES</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-turno='" . $row['TURNO'] . "' data-ajuste='SI'>AJUSTE</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal3' data-whatever2='" . $row['BADGE'] . "' data-nombre2='" . $row['NOMBRE_TRABAJADOR'] . "' data-area2='" . $row['AREA'] . "' data-turno2='" . $row['TURNO'] . "' data-ajuste2='OVT' disabled >OVT</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "'  class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
        }

        $tablita .=  "</table> ";

        $marcadas = [];
        $marcadas[0] = $tablita;
        $marcadas[1] = $result_f;

        if (count($result_f) == 0) {
            $marcadas = [];
        }

        echo json_encode($marcadas);
    }
}

if ($estado == 'BuscarMarc2') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $badge = $_POST['badge'];
    $radio = $_POST['radio'];
    $admin = $_POST['admin'];
    $tablita = '';

    $tablita .= "<div id='divh' class='bg-primary'>";
    // resumen puestos

    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS MARCADOS:</b><br> ';


    $result_perf3 = $info->fill_marcadas_resumen($supervisor, $fecha, $area, $badge, $radio, $admin);

    $ct = 0;
    $ctdiv = '';

    $tablita .= '<table>';

    foreach ($result_perf3 as $row) {
        # code...
        $ct = $ct + 1;

        $ctdiv = $ct / 6;

        $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

        if (strpos($ctdiv, ".") !== false) {
        } else {
            $tablita .= '</table><table>';
        }
    }
    $tablita .= '</table>';

    $tablita .= '</label></br>';


    //fin

    // resumen puestos

    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS NO MARCADOS :</b><br> ';


    $result_perf3 = $info->fill_marcadas_no_resumen($supervisor, $fecha, $area, $badge, $radio);

    $ct = 0;
    $ctdiv = '';

    $tablita .= '<table>';

    foreach ($result_perf3 as $row) {
        # code...
        $ct = $ct + 1;

        $ctdiv = $ct / 6;

        $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

        if (strpos($ctdiv, ".") !== false) {
        } else {
            $tablita .= '</table><table>';
        }
    }
    $tablita .= '</table>';

    $tablita .= '</label>';


    //fin
    $tablita .= "</div>";

    if ($_POST['fecha'] == '') {
    } else {

        $result_f = $info->fill_marcadas_no($supervisor, $fecha, $area, $badge, $radio);

        $result_g = $info->get_perfil($supervisor, $admin);





        if (count($result_f) == count($result_g)) {
        } elseif (count($result_f) != '') {





            if ($radio == 'E') {

                $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS-</b>  :  " . count($result_f) . " AUSENTE(S) !   </label>";
            } else if ($radio == 'S') {

                $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -SALIDAS- </b> :  " . count($result_f) . " AUSENTE(S) !   </label>";
            }





            $tablita .=    " </br><table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>



    <tr class='bg-danger'>
    <th scope='col'>BADGE</th>
    <th scope='col'>OPERADORA</th>
    <th scope='col'>PUESTO</th>
    <th scope='col'>AREA</th>
    <th scope='col'>ESTADO</th>
    <th scope='col'>HORA</th>
    <th scope='col'>TURNO</th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
     </tr> ";

            foreach ($result_f as $row) {
                # code...

                $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='NO'>ACCIONES</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='SI'>AJUSTE</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal3' data-whatever2='" . $row['BADGE'] . "' data-nombre2='" . $row['NOMBRE_TRABAJADOR'] . "' data-area2='" . $row['AREA'] . "' data-turno2='" . $row['TURNO'] . "' data-ajuste2='OVT' disabled >OVT</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
                //$tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' onclick='abrircerrar('algo')'>NOTA</button></td></tr>";
            }

            $tablita .=  "</table> ";


            // echo $tablita;



            $marcadasno = [];
            $marcadasno[0] = $tablita;
            $marcadasno[1] = $result_f;


            // echo "<script>console.log('Debug Objects: " . count($result_f) . "' );</script>";


            echo json_encode($marcadasno);
        }
    }
}

if ($estado == 'BuscarMarc_all') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $badge = $_POST['badge'];
    $radio = $_POST['radio'];

    $result_f = $info->fill_marcadas_all($supervisor, $fecha, $area, $badge, $radio);

    if ($_POST['fecha'] == '') {
    } elseif (count($result_f) != 0) {



        $tablita = '';

        if ($radio == 'E') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS- </b>:  " . count($result_f) . " MARCADAS !   </label>";
        } else if ($radio == 'S') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO : <b> -SALIDAS- </b>" . count($result_f) . " MARCADAS !   </label>";
        }

        $tablita .=    " </br><table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>



    <tr class='bg-primary'>
    <th scope='col'>BADGE</th>
    <th scope='col'>OPERADORA</th>
    <th scope='col'>PUESTO</th>
    <th scope='col'>AREA</th>
    <th scope='col'>ESTADO</th>
    <th scope='col'>HORA</th>
    <th scope='col'>TURNO</th>
    <th scope='col'>SUPERVISOR</th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
     </tr> ";

        foreach ($result_f as $row) {
            # code...

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td>" . $row['supervisor'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='NO'>ACCIONES</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='SI'>AJUSTE</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal3' data-whatever2='" . $row['BADGE'] . "' data-nombre2='" . $row['NOMBRE_TRABAJADOR'] . "' data-area2='" . $row['AREA'] . "' data-turno2='" . $row['TURNO'] . "' data-ajuste2='OVT' disabled >OVT</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "'  class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
        }

        $tablita .=  "</table> ";


        echo $tablita;
    }
}

if ($estado == 'BuscarMarc2_all') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $badge = $_POST['badge'];
    $radio = $_POST['radio'];
    $admin  = $_POST['admin'];
    $tablita = '';


    if ($_POST['fecha'] == '') {
    } else {

        $tablita .= "<div id='divh' class='bg-primary'>";
        // resumen puestos

        $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS MARCADOS:</b><br> ';


        $result_perf3 = $info->fill_marcadas_all_resumen($supervisor, $fecha, $area, $badge, $radio, $admin);

        $ct = 0;
        $ctdiv = '';

        $tablita .= '<table>';

        foreach ($result_perf3 as $row) {
            # code...
            $ct = $ct + 1;

            $ctdiv = $ct / 6;

            $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

            if (strpos($ctdiv, ".") !== false) {
            } else {
                $tablita .= '</table><table>';
            }
        }
        $tablita .= '</table>';

        $tablita .= '</label></br>';


        //fin

        // resumen puestos

        $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS NO MARCADOS :</b><br> ';


        $result_perf3 = $info->fill_marcadas_no_all_resumen($supervisor, $fecha, $area, $badge, $radio);

        $ct = 0;
        $ctdiv = '';

        $tablita .= '<table>';

        foreach ($result_perf3 as $row) {
            # code...
            $ct = $ct + 1;

            $ctdiv = $ct / 6;

            $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

            if (strpos($ctdiv, ".") !== false) {
            } else {
                $tablita .= '</table><table>';
            }
        }
        $tablita .= '</table>';

        $tablita .= '</label>';


        //fin
        $tablita .= "</div>";


        $result_f = $info->fill_marcadas_no_all($supervisor, $fecha, $area, $badge, $radio);

        $result_g = $info->get_perfil_all($supervisor, $admin);



        if (count($result_f) == count($result_g)) {
        } elseif (count($result_f) != '') {


            // $tablita = '';


            if ($radio == 'E') {

                $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS-</b>  :  " . count($result_f) . " AUSENTE(S) !   </label>";
            } else if ($radio == 'S') {

                $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -SALIDAS- </b> :  " . count($result_f) . " AUSENTE(S) !   </label>";
            }





            $tablita .=    " </br><table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>



    <tr class='bg-danger'>
    <th scope='col'>BADGE</th>
    <th scope='col'>OPERADORA</th>
    <th scope='col'>PUESTO</th>
    <th scope='col'>AREA</th>
    <th scope='col'>ESTADO</th>
    <th scope='col'>HORA</th>
    <th scope='col'>TURNO</th>
    <th scope='col'>SUPERVISOR</th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
    <th scope='col'></th>
     </tr> ";

            foreach ($result_f as $row) {
                # code...

                $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='NO' >ACCIONES</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='SI' >AJUSTE</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal3' data-whatever2='" . $row['BADGE'] . "' data-nombre2='" . $row['NOMBRE_TRABAJADOR'] . "' data-area2='" . $row['AREA'] . "' data-turno2='" . $row['TURNO'] . "' data-ajuste2='OVT' disabled >OVT</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
                //$tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' onclick='abrircerrar('algo')'>ACCIONES</button></td></tr>";
            }

            $tablita .=  "</table> ";


            echo $tablita;
        }
    }
}


if ($estado == 'BuscarMarcsups_all') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $radio = $_POST['radio'];

    $result_f = $info->fill_marcadassup_all($supervisor, $fecha, $radio);


    if ($_POST['fecha'] == '') {
    } elseif (count($result_f) != 0) {


        $tablita = '';

        $tablita .= "<div id='divh' class='bg-primary'>";

        if ($radio == 'E') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS SUPERVISORES-</b>  :  " . count($result_f) . " MARCADAS !  </label>";
        } else if ($radio == 'S') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -SALIDAS SUPERVISORES- </b> :  " . count($result_f) . " MARCADAS !   </label>";
        }


        $tablita .=    " </br><table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>



       <tr class='bg-primary'>
       <th scope='col'>BADGE</th>
       <th scope='col'>SUPERVISOR</th>
       <th scope='col'>PUESTO</th>
       <th scope='col'>AREA</th>
       <th scope='col'>ESTADO</th>
       <th scope='col'>HORA</th>
       <th scope='col'>TURNO</th>
       <th scope='col'></th>
       <th scope='col'></th>
       <th scope='col'></th>
       <th scope='col'></th>
        </tr> ";


        foreach ($result_f as $row) {
            # code...

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='NO'>ACCIONES</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='SI'>AJUSTE</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal3' data-whatever2='" . $row['BADGE'] . "' data-nombre2='" . $row['SUPERVISOR'] . "' data-area2='" . $row['AREA'] . "' data-turno2='" . $row['TURNO'] . "' data-ajuste2='OVT' disabled >OVT</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
            //$tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' onclick='abrircerrar('algo')'>ACCIONES</button></td></tr>";
        }

        $tablita .=  "</table> ";

        $tablita .= "</br></div>";

        echo $tablita;
    }
}

if ($estado == 'BuscarMarcsups_no_all') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $radio = $_POST['radio'];

    $result_f = $info->fill_marcadassup_no_all($supervisor, $fecha, $radio);


    if ($_POST['fecha'] == '') {
    } elseif (count($result_f) != 0) {


        $tablita = '';

        $tablita .= "<div id='divh' class='bg-primary'>";

        if ($radio == 'E') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS SUPERVISORES-</b>  :  " . count($result_f) . " AUSENTES !  </label>";
        } else if ($radio == 'S') {

            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -SALIDAS SUPERVISORES- </b> :  " . count($result_f) . " AUSENTES !   </label>";
        }


        $tablita .=    " </br><table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>



       <tr class='bg-danger'>
       <th scope='col'>BADGE</th>
       <th scope='col'>SUPERVISOR</th>
       <th scope='col'>PUESTO</th>
       <th scope='col'>AREA</th>
       <th scope='col'>ESTADO</th>
       <th scope='col'>HORA</th>
       <th scope='col'>TURNO</th>
       <th scope='col'></th>
       <th scope='col'></th>
       <th scope='col'></th>
       <th scope='col'></th>
        </tr> ";


        foreach ($result_f as $row) {
            # code...

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='NO'>ACCIONES</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "'  data-turno='" . $row['TURNO'] . "' data-ajuste='SI'>AJUSTE</button></td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal3' data-whatever2='" . $row['BADGE'] . "' data-nombre2='" . $row['SUPERVISOR'] . "' data-area2='" . $row['AREA'] . "' data-turno2='" . $row['TURNO'] . "' data-ajuste2='OVT' disabled >OVT</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
            //$tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' onclick='abrircerrar('algo')'>ACCIONES</button></td></tr>";
        }

        $tablita .=  "</table> ";

        $tablita .= "</br></div>";

        echo $tablita;
    }
}

if ($estado == 'SaveDetails') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $oper = $_POST['oper'];
    $nombre = $_POST['nombre'];
    $area = $_POST['area'];
    $observacion = $_POST['observacion'];
    $notas = $_POST['notas'];
    $fecha_s = $_POST['fecha_s'];
    $fecha_s2 = $_POST['fecha_s2'];
    $tipo = $_POST['tipo'];
    $septimo = $_POST['septimo'];
    $ndias = $_POST['ndias'];
    $nhoras = $_POST['nhoras'];
    $nmins = $_POST['nmins'];
    $horaini = $_POST['horaini'];
    $horafin = $_POST['horafin'];
    $turno = $_POST['turno'];
    $ajuste = $_POST['ajuste'];
    $newfilename = $_POST['newfilename'];

    $rol = $_POST['rol'];

    $result_z = $info->insertar_log($supervisor, $fecha, $fecha_s, $fecha_s2, $oper, $nombre, $area, $observacion, $notas, $tipo, $septimo, $ndias, $nhoras, $nmins, $horaini, $horafin, $turno, $ajuste, $newfilename, $rol);
    echo json_encode($result_z);
}

if ($estado == 'SaveDetails_extras') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $oper = $_POST['oper'];
    $nombre = $_POST['nombre'];
    $area = $_POST['area'];
    $observacion = $_POST['observacion'];
    $notas = $_POST['notas'];
    $fecha_s = $_POST['fecha_s'];
    $fecha_s2 = $_POST['fecha_s2'];
    $tipo = $_POST['tipo'];
    $septimo = $_POST['septimo'];
    $nhoras = $_POST['nhoras'];
    $horaini = $_POST['horaini'];
    $horafin = $_POST['horafin'];
    $turno = $_POST['turno'];
    $ajuste = $_POST['ajuste'];


    $rol = $_POST['rol'];

    $result_z = $info->insertar_log_extras($supervisor, $fecha, $fecha_s, $fecha_s2, $oper, $nombre, $area, $observacion, $notas, $tipo, $nhoras, $horaini, $horafin, $turno, $ajuste, $rol);
    echo json_encode($result_z);
}

if ($estado == 'BuscarNotas') {
    $supervisor = $_POST['supervisor'];
    $fecha = $_POST['fecha'];
    $fechaf = $_POST['fechaf'];
    $badge = $_POST['badge'];
    $obs = $_POST['obs'];
    $rol = $_POST['rol'];
    $ct = '';
    $ct2 = '';
    $estado2 = $_POST['estado2'];
    $turno = $_POST['turno'];
    $area = $_POST['area'];
    $ajuste = $_POST['ajuste'];
    $comp = '';
    $temp2 = getcwd();
    $tipo_per = $_POST['tipo_per'];
    $orden = $_POST['orden'];

    if ($rol == 'I') {
        if ($area == '') {
            $result_Q = $info->fill_logs_all_noext($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        } else {
            $result_Q = $info->fill_logs_in_all_noext($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        }
    } else if ($rol == 'Y' || $rol == 'X'  ) {
        if ($area == '') {
            $result_Q = $info->fill_logs_all_ext($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        } else {
            $result_Q = $info->fill_logs_in_all_ext($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        }
    } else if ($rol == 'R' || $rol == 'C' ) {
        if ($area == '') {
            $result_Q = $info->fill_logs_all($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        } else {
            $result_Q = $info->fill_logs_in_all($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        }
    } else if ($rol == 'A') {
        // if ($area == '') {
        //     $result_Q = $info->fill_logs($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per);
        // } else {
        //     $result_Q = $info->fill_logs_in($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per);
        // }
        if ($area == '') {
            $result_Q = $info->fill_logs_all($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        } else {
            $result_Q = $info->fill_logs_in_all($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
        }
        // $result_Q2 = $info->fill_logs_resumen($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area);
    } else if ($rol == 'S' || $rol == 'M') {

        $result_Q = $info->fill_logs_sup($supervisor, $fecha, $fechaf, $badge, $obs, $estado2, $turno, $area, $ajuste, $tipo_per, $orden);
    }



    $tablita = '';


    // $tablita .= "</br><label class='p-3 mb-2 bg-dark text-white'> MOSTRANDO :  " . count($result_Q) . " LOGS! </label>";
    // foreach ($result_Q2 as $row) {
    //     if ($row['ESTADO'] == 'REVISION') {
    //         $ct = $row['CT'];
    //     } else {
    //         $ct2 = $row['CT'];
    //     }
    // }

    // $tablita .= "</br><label class='p-3 mb-2 bg-dark text-white'> EN REVISION :  " . $ct . " REVISADOS : " . $ct2 . " </label>";

    if ($rol == 'A' || $rol == 'M' || $rol == 'I' || $rol == 'R' || $rol == 'C' || $rol == 'Y' || $rol == 'X' ) {

        $tablita .=    "<table id='table' class='table table-striped table-dark table-bordered table-hover table-responsive'><tr class='bg-primary'><th scope='col' >REG#</th><th scope='col' onclick='sortTable(20)'>FECHA_REG</th><th scope='col' onclick='sortTable(1)'>BADGE</th><th scope='col' onclick='sortTable(2)'>NOMBRE</th><th scope='col' onclick='sortTable(3)'>TURNO</th><th scope='col' onclick='sortTable(4)'>AREA</th><th scope='col' onclick='sortTable(5)' style='min-width='500px'>SUPERVISOR</th><th scope='col' onclick='sortTable(6)'>OBSERVACION</th><th scope='col' onclick='sortTable(8)'>NOTAS</th><th scope='col' onclick='sortTable(9)'>FECHA INICIO</th><th scope='col' onclick='sortTable(10)'>FECHA FINAL</th><th scope='col' onclick='sortTable(11)'>H_INICIO</th><th scope='col' onclick='sortTable(12)'>H_FINAL</th><th scope='col' onclick='sortTable(13)'>DIAS</th><th scope='col' onclick='sortTable(14)'>HORAS</th><th scope='col' onclick='sortTable(15)'>MINS</th><th scope='col' onclick='sortTable(16)'>AJUSTE</th><th scope='col' >COMPROBANTE</th><th scope='col' onclick='sortTable(18)'>ESTADO</th><th scope='col' onclick='sortTable(19)'>FECHA_REVISION</th><th scope='col'><input type='checkbox' id='select-all' name='select-all' onClick='toggle(this)'></th></tr> ";

        foreach ($result_Q as $row) {
            if ($row['ESTADO'] == 'REVISION') {
                $bg = 'text-dark bg-warning';
            } else if ($row['ESTADO'] == 'PROCESADO') {
                $bg = 'bg-info';
            } else if ($row['ESTADO'] == 'PAGADO') {
                $bg = 'bg-primary';
            } else if ($row['ESTADO'] == 'CREADO') {
                $bg = 'bg-secondary';
            } else if ($row['ESTADO'] == 'CANCELADO') {
                $bg = 'bg-danger';
            } else {
                $bg = 'bg-success';
            }

            if ($row['COMPROBANTE'] != '') {
                $comp = "<a href='marcadas/comprobantes/" . $row['COMPROBANTE']  . "'  download>Descargar</a>";
            } else {
                $comp = '';
            }


            $tablita .=  "<tr><td>" . $row['IDREG'] . "</td><td>" . $row['FECHA'] . "</td><td>" . $row['OPERARIO'] . "</td><td>" . $row['NOMBRE'] . "</td><td>" . $row['TURNO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td>" . $row['OBSERVACION'] . "</td><td>" . $row['NOTAS'] . "</td><td>" . $row['FECHA_INGRESO'] . "</td><td>" . $row['FECHA_FINAL'] . "</td><td>" . $row['HINI'] . "</td><td>" . $row['HFIN'] . "</td><td>" . $row['NUMERO_DIAS'] . "</td><td>" . $row['NUMERO_HORAS'] . "</td><td>" . $row['NUMERO_MINUTOS'] . "</td><td><b>" . $row['AJUSTE'] . "</b></td><td>" . $comp . "</td><td class='" . $bg . "'><b>" . $row['ESTADO'] . "</b></td><td class='" . $bg . "'><b>" . $row['FECHA_REVISION'] . "</b></td><td><input type='checkbox' id='" . $row['IDREG']  . "' name='registros' value='" . $row['IDREG']  . "' data-nombre= '" . $row['NOMBRE'] . "' data-obs= '" . $row['OBSERVACION'] . "'></td></tr>";
        }
    } else if ($rol == 'S') {




        $tablita .=    "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'><tr class='bg-primary'><th scope='col'>REG#</th><th scope='col' onclick='sortTable(19)'>FECHA_REG</th><th scope='col' onclick='sortTable(1)'>BADGE</th><th scope='col' onclick='sortTable(2)'>NOMBRE</th><th scope='col' onclick='sortTable(3)'>TURNO</th><th scope='col' onclick='sortTable(4)'>AREA</th><th scope='col' onclick='sortTable(5)'>SUPERVISOR</th><th scope='col' onclick='sortTable(6)'>OBSERVACION</th><th scope='col' onclick='sortTable(7)'>NOTAS</th><th scope='col' onclick='sortTable(8)' style='min-width='500px'>FECHA INICIO</th><th scope='col' onclick='sortTable(9)'>FECHA FINAL</th><th scope='col' onclick='sortTable(10)'>H_INICIO</th><th scope='col' onclick='sortTable(11)'>H_FINAL</th><th scope='col' onclick='sortTable(12)'>DIAS</th><th scope='col' onclick='sortTable(13)'>HORAS</th><th scope='col' onclick='sortTable(14)'>MINS</th><th scope='col' onclick='sortTable(15)'>AJUSTE</th><th scope='col'>COMPROBANTE</th><th scope='col' onclick='sortTable(17)'>ESTADO</th><th scope='col' onclick='sortTable(18)'>FECHA_REVISION</th></tr>";

        foreach ($result_Q as $row) {

            if ($row['ESTADO'] == 'REVISION') {
                $bg = 'text-dark bg-warning';
            } else if ($row['ESTADO'] == 'PROCESADO') {
                $bg = 'bg-info';
            } else if ($row['ESTADO'] == 'PAGADO') {
                $bg = 'bg-primary';
            } else if ($row['ESTADO'] == 'CREADO') {
                $bg = 'bg-secondary';
            } else if ($row['ESTADO'] == 'CANCELADO') {
                $bg = 'bg-danger';
            } else {
                $bg = 'bg-success';
            }

            if ($row['COMPROBANTE'] != '') {
                $comp = "<a href='marcadas/comprobantes/" . $row['COMPROBANTE']  . "'  download>Descargar</a>";
            } else {
                $comp = '';
            }


            $tablita .=  "<tr><td>" . $row['IDREG'] . "</td><td>" . $row['FECHA'] . "</td><td>" . $row['OPERARIO'] . "</td><td>" . $row['NOMBRE'] . "</td><td>" . $row['TURNO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td>" . $row['OBSERVACION'] . "</td><td>" . $row['NOTAS'] . "</td><td>" . $row['FECHA_INGRESO'] . "</td><td>" . $row['FECHA_FINAL'] . "</td><td>" . $row['HINI'] . "</td><td>" . $row['HFIN'] . "</td><td>" . $row['NUMERO_DIAS'] . "</td><td>" . $row['NUMERO_HORAS'] . "</td><td>" . $row['NUMERO_MINUTOS'] . "</td><td><b>" . $row['AJUSTE'] . "</b></td><td>" . $comp . "</td><td class='" . $bg . "'><b>" . $row['ESTADO'] . "</b></td><td class='" . $bg . "'><b>" . $row['FECHA_REVISION'] . "</b></td><td><input type='checkbox' id='" . $row['IDREG']  . "' name='registros' value='" . $row['IDREG']  . "' data-nombre= '" . $row['NOMBRE'] . "' data-obs= '" . $row['OBSERVACION'] . "'></td></tr>";
        }
    }

    $tablita .=  "</table>";


    $resultado_log = [];
    $resultado_log[0] = $tablita;
    $resultado_log[1] = $result_Q;


    //echo "<script>console.log('Debug Objects: " . count($result_f) . "' );</script>";


    echo json_encode($resultado_log);


    // echo $tablita;
}

if ($estado == 'buscaridnotas') {
    $sup = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $oper = $_POST['operario'];


    $result_Q = $info->get_cuenta_notas($sup, $fecha, $oper);

    $tablita = '';


    $tablita .= "</br><table border='1' class='table-primary'>";

    foreach ($result_Q as $row) {


        $tablita .=  "<td><span onclick='getdatab(this.id)' title='Nota " . $row['IDREG'] . "' id='" . $row['IDREG'] . "'><img src='img/warn.png' height='15' width='15'> -" . $row['IDREG'] . "</span></td>";
    }

    $tablita .=  "</table> ";



    echo $tablita;
}


if ($estado == 'buscaridnotas3') {
    $sup = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $oper = $_POST['operario'];


    $result_Q = $info->get_cuenta_notas3($sup, $fecha, $oper);

    $tablita = '';


    $tablita .= "</br><table border='1' class='table-primary'>";

    foreach ($result_Q as $row) {


        $tablita .=  "<td><span onclick='getdatab2(this.id)' title='Nota " . $row['IDREG'] . "' id='" . $row['IDREG'] . "'><img src='img/warn.png' height='15' width='15'> -" . $row['IDREG'] . "</span></td>";
    }

    $tablita .=  "</table> ";



    echo $tablita;
}

if ($estado == 'GetDetails') {
    $idn = $_POST['idn'];

    $result_Q = $info->get_nota_click($idn);

    echo json_encode($result_Q);
}

if ($estado == 'GetDetails2') {
    $idn = $_POST['idn'];

    $result_Q = $info->get_nota_click2($idn);

    echo json_encode($result_Q);
}

if ($estado == 'mostrardatossup') {
    $sup = $_POST['sup'];
    $tablita = '';
    $nuevo = '';

    echo '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN</b> </br> ';


    $tablita .= '</label>';

    $tablita .= '</br><b><label class="p-3 mb-2 bg-dark text-white"> SUPERVISORES A CARGO DE SUPERINTENDENTE : </label></b>';

    $result_perf = $info->get_mysups($sup);


    $tablita .=  "<table id='table2' class='table table-striped table-dark table-bordered table-hover table-sm'>
    <tr class='bg-primary'>
   <th scope='col'>BADGE</th>
   <th scope='col'>SUPERVISOR</th>
   <th scope='col'>PUESTO</th>
   <th scope='col'>AREA</th>
   <th scope='col'>ESTADO</th>
   <th scope='col'>TURNO</th>
   <th scope='col'>ASIGNADO</th>
   <th scope='col'></th>
       </tr> ";

    foreach ($result_perf as $row) {
        if ($row['ESTADO'] == '') {
            $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
        } else {
            $nuevo = $row['ESTADO'];
        }
        # code...

        $tablita .= "<tr>";
        $tablita .= "<td>" . $row['BADGE'] . "</td>";
        $tablita .= "<td>" . $row['SUPERVISOR'] . "</td>";
        $tablita .= "<td>" . $row['PUESTO'] . "</td>";
        $tablita .= "<td>" . $row['AREA'] . "</td>";
        $tablita .= "<td><center>" . $nuevo . "</center></td>";
        $tablita .= "<td>" . $row['TURNO'] . "</td>";
        $tablita .= "<td>" . $row['ASIGNADO'] . "</td>";
        $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo . "' data-turn1='" . $row['TURNO'] . "' data-asignado='" . $row['ASIGNADO'] . "' data-rolclick='A'>MOD</button></td>";
        // $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "R' class='btn btn-danger' onclick='f_borrar(this.id)'>X</button></td>";
        $tablita .= "</tr>";
    }

    $tablita .= "</table>";



    echo  $tablita;
}

if ($estado == 'mostrardatos') {
    $supi = $_POST['supi'];
    $sup = $_POST['sup'];
    $rol = $_POST['rol'];
    $admin = $_POST['admin'];
    $tablita = '';
    $nuevo = '';

    echo '<label class="p-3 mb-2 bg-dark text-white"> <b>ESTADOS :</b> </br> ';


    $result_perf2 = $info->fill_resumen($sup);

    foreach ($result_perf2 as $row) {
        # code...


        $tablita .= '' . $row['ESTADO'] . '(' . $row['TOTAL'] . ') <br>';
    }

    $tablita .= '</label> &nbsp';

    // resumen puestos

    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS:</b><br> ';


    $result_perf3 = $info->fill_resumen2($sup, $admin);

    $ct = 0;
    $ctdiv = '';

    $tablita .= '<table>';

    foreach ($result_perf3 as $row) {
        # code...
        $ct = $ct + 1;

        $ctdiv = $ct / 6;

        $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

        if (strpos($ctdiv, ".") !== false) {
        } else {
            $tablita .= '</table><table>';
        }
    }
    $tablita .= '</table>';

    $tablita .= '</label>';


    //fin




    $tablita .= '</br><b><label class="p-3 mb-2 bg-dark text-white"> PERSONAL A CARGO  DE <b>' . $sup . '</b> : </label></b>';




    if ($rol == 'A') {

        $result_perf = $info->get_perfil($sup, $admin);

        $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
     <tr class='bg-primary'>
    <th scope='col' onclick='sortTable(0)'>BADGE</th>
    <th scope='col' onclick='sortTable(1)'>OPERADORA</th>
    <th scope='col' onclick='sortTable(2)'>PUESTO</th>
    <th scope='col' onclick='sortTable(3)'>AREA</th>
    <th scope='col' onclick='sortTable(4)'>ESTADO</th>
    <th scope='col' onclick='sortTable(5)'>TURNO</th>
    <th scope='col'></th>
        </tr> ";

        foreach ($result_perf as $row) {
            if ($row['ESTADO'] == '') {
                $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
            } else {
                $nuevo = $row['ESTADO'];
            }
            # code...

            $tablita .= "<tr>";
            $tablita .= "<td>" . $row['BADGE'] . "</td>";
            $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
            $tablita .= "<td>" . $row['PUESTO'] . "</td>";
            $tablita .= "<td>" . $row['AREA'] . "</td>";
            $tablita .= "<td><center>" . $nuevo . "</center></td>";
            $tablita .= "<td>" . $row['TURNO'] . "</td>";
            $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo . "' data-turn1='" . $row['TURNO'] . "'>MOD</button></td>";
            // $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "R' class='btn btn-danger' onclick='f_borrar(this.id)'>X</button></td>";
            $tablita .= "</tr>";
        }

        $tablita .= "</table>";

        echo  $tablita;
        // $mipersonal=[];
        // $mipersonal[0] = $tablita;
        // $mipersonal[1] = $result_perf;

        // echo json_encode($mipersonal);
    } else if ($rol == 'M') {

        $result_perf = $info->get_perfil_M($sup, $admin, $supi);

        $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
     <tr class='bg-primary'>
    <th scope='col' onclick='sortTable(0)'>BADGE</th>
    <th scope='col' onclick='sortTable(1)'>OPERADORA</th>
    <th scope='col' onclick='sortTable(2)'>PUESTO</th>
    <th scope='col' onclick='sortTable(3)'>AREA</th>
    <th scope='col' onclick='sortTable(4)'>ESTADO</th>
    <th scope='col' onclick='sortTable(5)'>TURNO</th>
    <th scope='col'></th>
        </tr> ";

        foreach ($result_perf as $row) {
            if ($row['ESTADO'] == '') {
                $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
            } else {
                $nuevo = $row['ESTADO'];
            }
            # code...

            $tablita .= "<tr>";
            $tablita .= "<td>" . $row['BADGE'] . "</td>";
            $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
            $tablita .= "<td>" . $row['PUESTO'] . "</td>";
            $tablita .= "<td>" . $row['AREA'] . "</td>";
            $tablita .= "<td><center>" . $nuevo . "</center></td>";
            $tablita .= "<td>" . $row['TURNO'] . "</td>";
            $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo . "' data-turn1='" . $row['TURNO'] . "'>MOD</button></td>";
            // $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "R' class='btn btn-danger' onclick='f_borrar(this.id)'>X</button></td>";
            $tablita .= "</tr>";
        }

        $tablita .= "</table>";

        echo  $tablita;
    } else if ($rol != 'A' || $rol != 'M') {
        $result_perf = $info->get_perfil($sup, $admin);

        $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover' style='table-layout:fixed; width:'4000px'; >
        <tr class='bg-primary'>
       <th scope='col' onclick='sortTable(0)'>BADGE</th>
       <th scope='col' onclick='sortTable(1)'>OPERADORA</th>
       <th scope='col' onclick='sortTable(2)'>PUESTO</th>
       <th scope='col' onclick='sortTable(3)'>AREA</th>
       <th scope='col' onclick='sortTable(4)'>ESTADO</th>
       <th scope='col' onclick='sortTable(5)'>TURNO</th>
       <th scope='col'></th>
       </tr> ";

        foreach ($result_perf as $row) {
            if ($row['ESTADO'] == '') {
                $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
            } else {
                $nuevo = $row['ESTADO'];
            }
            # code...

            $tablita .= "<tr>";
            $tablita .= "<td>" . $row['BADGE'] . "</td>";
            $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
            $tablita .= "<td>" . $row['PUESTO'] . "</td>";
            $tablita .= "<td>" . $row['AREA'] . "</td>";
            $tablita .= "<td><center>" . $nuevo . "</center></td>";
            $tablita .= "<td>" . $row['TURNO'] . "</td>";
            $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo . "' data-turn1='" . $row['TURNO'] . "'>MOD</button></td>";
            // $tablita .= "<td></td>";
            $tablita .= "</tr>";
        }

        $tablita .= "</table>";

        echo  $tablita;
        //  $mipersonal=[];
        //  $mipersonal[0] = $tablita;
        //  $mipersonal[1] = $result_perf;

        //  echo json_encode($mipersonal);
    }


    // if ($estado == 'mostrarturno') {
    //     $sup = $_POST['sup'];


    //     $result_perf2 = $info->fill_oper_sup2($sup);

    //     $tablita = '<input type="hidden" id="turn1" value="' . $result_perf2[0] . '"/><label class="p-3 mb-2 bg-dark text-white" > CAMBIO DE TURNO <b>' . $result_perf2[0] . '</b> (SUPERVISOR) A  : </label> ';

    //     echo $tablita;
    // }
}

if ($estado == 'llenar_detalle') {
    $sup = $_POST['sup'];
    $badge = $_POST['badge'];
    $fini = $_POST['fini'];
    $ffin = $_POST['ffin'];
    $totdays = $_POST['tdays'] + 1;

    $columnas = '';
    $querycr = '';
    $filas = '';
    $filascons =  array();
    $comparador = array();
    $ES = array();

    $date = new DateTime($fini);
    $j = 1;
    $x = 1;
    // cadenas para query, columnas y filas 
    for ($i = 1; $i <= $totdays; $i++) {
        if ($i > 1) {
            $date->modify('+1 day');
        }

        $cadena = $date->format('d-M');
        $cadena2 = $date->format('Y-m-d');


        $columnas .= "<th style='min-width:85px'>" . $cadena . "(E)</th > <th style='min-width:85px'>" . $cadena . "(S)</th>";

        if ($i != $totdays) {
            $querycr .= "MAX(CASE WHEN FMOV = '" . $cadena2 . "' AND ES = 'E' THEN HORA ELSE '' END) AS '" . $cadena . "(E)',MAX(CASE WHEN FMOV = '" . $cadena2 . "' AND ES = 'S' THEN HORA ELSE '' END) AS '" . $cadena . "(S)',";
        } else {
            $querycr .= "MAX(CASE WHEN FMOV = '" . $cadena2 . "' AND ES = 'E' THEN HORA ELSE '' END) AS '" . $cadena . "(E)',MAX(CASE WHEN FMOV = '" . $cadena2 . "' AND ES = 'S' THEN HORA ELSE '' END) AS '" . $cadena . "(S)'";
        }

        $filascons[$j]  =  $cadena . '(E)';
        $j = $j + 1;
        $filascons[$j]  =  $cadena . '(S)';

        $comparador[$x] = $cadena2;
        $ES[$x] = 'E';
        $x = $x + 1;
        $comparador[$x] = $cadena2;
        $ES[$x] = 'S';


        $date = $date;
        $j = $j + 1;
        $x = $x + 1;
    }

    // var_dump($comparador);
    //     var_dump($ES);

    $result_perf = $info->llenar_detalles($sup, $badge, $fini, $ffin, $querycr);

    $tablita = '';


    $tablita .=  "<table id='table2' class='table table-striped table-dark table-bordered table-hover table-sm my_table td a'>
    <thead><tr class='bg-primary'>
    <th style='min-width:50px'>BADGE</th>
    <th style='min-width:300px'>OPER </th>"
        . $columnas .
        "</tr>  </thead> <tbody>";

    // print_r('<b>' . count($result_perf) . '</b>');
    /// 1 rojo
    /// 2 verde
    $opert = '';

    foreach ($result_perf as $row) {

        $opert = substr($row['OPER'], 0, 30);


        $tablita .= "<tr>";
        $tablita .= "<td> " . $row['BADGE'] . "</td>";
        $tablita .= "<td> " . $opert  . "</td>";

        $p = 0;
        foreach ($filascons as $item) {

            //VERIFICACION DE NOTAS AQUI
            //  print_r(' ');
            //  print_r($comparador[$p]);
            //  print_r($ES[$p]);
            //  print_r(' ');
            // print_r($p);
            $p = $p + 1;
            //get log note for this day.... with badge, date, E/S


            //VERIFICACION DE TURNO PARA MARCAR SI ENTRO TARDE O NO
            if ($row[$item] == '') {


                //  print_r($sup);
                //  print_r(' ');
                //  print_r($comparador[$p]);
                //  print_r(' ');
                //  print_r($row['BADGE']);
                //  print_r(' ');

                $result_Q = $info->get_cuenta_notas2($sup, $comparador[$p], $row['BADGE'], $ES[$p]);
                // print_r('<b> ');
                // print_r(count($result_Q));
                // print_r(' </b>');
                // var_dump($result_Q);

                if ($result_Q[0] <> 0) {
                    $tablita .= "<td id='ROW2' >";

                    //   $tablita .=  "<center><img src='img/warn.png' height='20' width='20' id='" . $result_Q[0]. "' title='" . $result_Q[0]  . "' onclick='document.getElementById(" .$row['BADGE']. ").click()' data-dismiss='modal'></center>";
                    // $tablita .=  '<center><img src="img/warn.png" height="20" width="20" id=' . $result_Q[0] . ' title='. $result_Q[0]  .' onclick="ejecutar_busqueda(' . $result_Q[0] . ',' .$comparador[$p].')" data-dismiss="modal"></center>';


                    $tablita .= '<center><img src="img/warn.png" height="20" width="20" id=' . $result_Q[0] . ' title=' . $result_Q[0] . ' onclick="ejecutar_busqueda(' . $row['BADGE'] . ',/' . $comparador[$p] . '/)" data-dismiss="modal"></center>';

                    $tablita .= "</td>";


                    //     foreach ($result_Q as $row) {

                    // //          //   $tablita .=  "<span onclick='getdatab(this.id)' title='Nota " . $row['IDREG'] . "' id='" . $row['IDREG'] . "'><img src='img/warn.png' height='5' width='5'> -" . $row['IDREG'] . "</span>";
                    //      $tablita .=  "NOTA";
                    //     }


                } else {

                    if ($comparador[$p] > date('Y-m-d')) {
                        $tablita .= "<td id='ROW3' > </td>";
                    } else {
                        $tablita .= "<td id='ROW1' > </td>";
                    }
                }
            } else {
                if ($comparador[$p] > date('Y-m-d')) {
                    $tablita .= "<td id='ROW3' > </td>";
                } else {
                    $tablita .= "<td id='ROW2'>  " . $row[$item] . "</td>";
                }
            }
        }


        $tablita .= "</tr>";
    }


    $tablita .= "</tbody></table>";

    echo  $tablita;
}


if ($estado == 'llenar_detalle_cronos') {
    $sup = $_POST['sup'];
    $badge = $_POST['badge'];
    $fini = $_POST['fini'];
    $ffin = $_POST['ffin'];
    $totdays = $_POST['tdays'] + 1;
    $tablita = '';

    $result_perf = $info->llenar_detalles_cronos($sup, $badge, $fini, $ffin);


    $tablita .=  "<table id='table2' class='table table-striped table-dark table-bordered table-hover table-sm'>
    <tr class='bg-primary'>
    <th scope='col' onclick='sortTable(0)'>BADGE</th>
    <th scope='col' onclick='sortTable(1)'>OPERADORA</th>
    <th scope='col' onclick='sortTable(2)'>TURNO</th>
    <th scope='col' onclick='sortTable(3)'>AREA</th>
    <th scope='col' onclick='sortTable(4)'>FECHA</th>
    <th scope='col' onclick='sortTable(5)'>DIA</th>
    <th scope='col' onclick='sortTable(6)'>H_ENTRADA</th>
    <th scope='col' onclick='sortTable(6)'>H_SALIDA</th>
    <th scope='col' onclick='sortTable(6)'>SUPERVISOR</th>
   <th scope='col'></th>
       </tr> ";

    foreach ($result_perf as $row) {
        $tablita .= "<tr>";
        $tablita .= "<td>" . $row['BADGE'] . "</td>";
        $tablita .= "<td>" . $row['EMPLEADO'] . "</td>";
        $tablita .= "<td>" . $row['TURNO'] . "</td>";
        $tablita .= "<td>" . $row['AREA'] . "</td>";
        $tablita .= "<td>" . $row['FECHA'] . "</td>";
        $tablita .= "<td>" . $row['DIA'] . "</td>";
        $tablita .= "<td>" . $row['H_ENTRADA'] . "</td>";
        $tablita .= "<td>" . $row['H_SALIDA'] . "</td>";
        $tablita .= "<td>" . $row['SUPERVISOR'] . "</td>";
        $tablita .= "</tr>";
    }

    $tablita .= "</table>";

    echo  $tablita;

}


if ($estado == 'UpdateBita') {
    $accion = $_POST['accion'];
    $super = $_POST['super'];
    $fechahora = $_POST['fechahora'];
    $operario = $_POST['operario'];
    $puesto = $_POST['puesto'];
    $estado2 = $_POST['estado2'];
    $transfer = $_POST['transfer'];





    $result_y = $info->bitacora_update($accion, $super, $fechahora, $operario, $puesto, $estado2, $transfer);
    echo json_encode($result_y);
}


if ($estado == 'mostrardatos_all') {

    $sup = $_POST['sup'];
    $rol = $_POST['rol'];
    $admin = $_POST['admin'];
    $tablita = '';
    $nuevo = '';


    echo '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN</b> </br> ';


    $result_perf2 = $info->fill_resumen_all($sup);

    foreach ($result_perf2 as $row) {
        # code...


        $tablita .= '' . $row['ESTADO'] . '(' . $row['TOTAL'] . ') ';
    }

    $tablita .= '</label>';


    // resumen puestos

    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS:</b><br> ';


    $result_perf3 = $info->fill_resumen2_all($sup, $admin);

    $ct = 0;
    $ctdiv = '';

    $tablita .= '<table>';

    foreach ($result_perf3 as $row) {
        # code...
        $ct = $ct + 1;

        $ctdiv = $ct / 6;

        $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

        if (strpos($ctdiv, ".") !== false) {
        } else {
            $tablita .= '</table><table>';
        }
    }
    $tablita .= '|</table>';

    $tablita .= '</label>';


    //fin


    $tablita .= '</br><b><label class="p-3 mb-2 bg-dark text-white"> PERSONAL A CARGO  DE SUS SUPERVISORES : </label></b>';

    $result_perf = $info->get_perfil_all($sup, $admin);




    if ($rol == 'A' || $rol == 'M') {


        $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
     <tr class='bg-primary'>
     <th scope='col' onclick='sortTable(0)'>BADGE</th>
     <th scope='col' onclick='sortTable(1)'>OPERADORA</th>
     <th scope='col' onclick='sortTable(2)'>PUESTO</th>
     <th scope='col' onclick='sortTable(3)'>AREA</th>
     <th scope='col' onclick='sortTable(4)'>ESTADO</th>
     <th scope='col' onclick='sortTable(5)'>TURNO</th>
     <th scope='col' onclick='sortTable(6)'>SUPERVISOR</th>
    <th scope='col'></th>
        </tr> ";

        foreach ($result_perf as $row) {
            if ($row['ESTADO'] == '') {
                $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
            } else {
                $nuevo = $row['ESTADO'];
            }
            # code...

            $tablita .= "<tr>";
            $tablita .= "<td>" . $row['BADGE'] . "</td>";
            $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
            $tablita .= "<td>" . $row['PUESTO'] . "</td>";
            $tablita .= "<td>" . $row['AREA'] . "</td>";
            $tablita .= "<td><center>" . $nuevo . "</center></td>";
            $tablita .= "<td>" . $row['TURNO'] . "</td>";
            $tablita .= "<td>" . $row['SUPERVISOR'] . "</td>";
            $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo . "' data-turn1='" . $row['TURNO'] . "'>MOD</button></td>";
            // $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "R' class='btn btn-danger' onclick='f_borrar(this.id)'>X</button></td>";
            $tablita .= "</tr>";
        }

        $tablita .= "</table>";

        echo  $tablita;
    } else if ($rol != 'A' || $rol == 'M') {
    }
}


if ($estado == 'mostrarturno') {
    $sup = $_POST['sup'];


    $result_perf2 = $info->fill_oper_sup2($sup);

    $tablita = '<input type="hidden" id="turn1" value="' . $result_perf2[0] . '"/><label class="p-3 mb-2 bg-dark text-white" > CAMBIO DE TURNO <b>' . $result_perf2[0] . '</b> (SUPERVISOR) A  : </label> ';

    echo $tablita;
}


if ($estado == 'grafs_ausencias') {
    $tipo = $_POST['tipo'];
    $fini = $_POST['fini'];
    $ffin = $_POST['ffin'];
    $sup = $_POST['sup'];

    $ejes = [];

    $ejex = '';
    $ejey = '';


    if ($tipo == 'WK') {
        $result_U = $info->grafs_wk_ausentismo($fini, $ffin, $sup);
    } else if ($tipo == 'MTH') {
        $result_U = $info->grafs_mth_ausentismo($fini, $ffin, $sup);
    } else if ($tipo == 'DLY') {
        $result_U = $info->grafs_dly_ausentismo($fini, $ffin, $sup);
    }



    $ejex = [];
    $ejey = [];

    foreach ($result_U  as $row) {
        $ejex[] = $row['YW'];
        $ejey[] = $row['CT'];
    }

    $ejes[0] = $ejex;
    $ejes[1] = $ejey;

    echo json_encode($ejes);
}

if ($estado == 'grafs_tardias') {
    $tipo = $_POST['tipo'];
    $fini = $_POST['fini'];
    $ffin = $_POST['ffin'];
    $sup = $_POST['sup'];

    $ejes = [];

    $ejex = '';
    $ejey = '';




    if ($tipo == 'WK') {
        $result_U = $info->grafs_wk_tardias($fini, $ffin, $sup);
    } else if ($tipo == 'MTH') {
        $result_U = $info->grafs_mth_tardias($fini, $ffin, $sup);
    } else if ($tipo == 'DLY') {
        $result_U = $info->grafs_dly_tardias($fini, $ffin, $sup);
    }

    $ejex = [];
    $ejey = [];

    foreach ($result_U  as $row) {
        $ejex[] = $row['YW'];
        $ejey[] = $row['CT'];
    }

    $ejes[0] = $ejex;
    $ejes[1] = $ejey;

    echo json_encode($ejes);
}

if ($estado == 'grafs_incapa') {
    $tipo = $_POST['tipo'];
    $fini = $_POST['fini'];
    $ffin = $_POST['ffin'];
    $sup = $_POST['sup'];

    $ejes = [];

    $ejex = '';
    $ejey = '';




    if ($tipo == 'WK') {
        $result_U = $info->grafs_wk_incapa($fini, $ffin, $sup);
    } else if ($tipo == 'MTH') {
        $result_U = $info->grafs_mth_incapa($fini, $ffin, $sup);
    } else if ($tipo == 'DLY') {
        $result_U = $info->grafs_dly_incapa($fini, $ffin, $sup);
    }

    $ejex = [];
    $ejey = [];

    foreach ($result_U  as $row) {
        $ejex[] = $row['YW'];
        $ejey[] = $row['CT'];
    }

    $ejes[0] = $ejex;
    $ejes[1] = $ejey;

    echo json_encode($ejes);
}

if ($estado == 'grafs_permisos') {
    $tipo = $_POST['tipo'];
    $fini = $_POST['fini'];
    $ffin = $_POST['ffin'];
    $sup = $_POST['sup'];

    $ejes = [];

    $ejex = '';
    $ejey = '';




    if ($tipo == 'WK') {
        $result_U = $info->grafs_wk_permisos($fini, $ffin, $sup);
    } else if ($tipo == 'MTH') {
        $result_U = $info->grafs_mth_permisos($fini, $ffin, $sup);
    } else if ($tipo == 'DLY') {
        $result_U = $info->grafs_dly_permisos($fini, $ffin, $sup);
    }

    $ejex = [];
    $ejey = [];

    foreach ($result_U  as $row) {
        $ejex[] = $row['YW'];
        $ejey[] = $row['CT'];
    }

    $ejes[0] = $ejex;
    $ejes[1] = $ejey;

    echo json_encode($ejes);
}

if ($estado == 'update_over') {
    $badge = $_POST['badge'];
    $areaempleado = $_POST['areaempleado'];
    $nomarea = $_POST['nomarea'];
    $user = $_POST['user'];
    $anterior = $_POST['anterior'];



    $result_z = $info->borrar_puesto_over($badge);
    $result_q = $info->insertar_puesto_over($badge, $areaempleado, $nomarea, $user, $anterior);
    echo json_encode($result_z);
    echo json_encode($result_q);
}


if ($estado == 'cambiar_contra') {
    $usuario = $_POST['usuario'];
    $contra = $_POST['contra'];




    $result_z = $info->cambiar_contra($usuario, $contra);
    echo json_encode($result_z);
}

if ($estado == 'actualizarestado') {
    $boxes = $_POST['boxes'];
    $boxes2 = $_POST['boxes2'];
    $boxes3 = $_POST['boxes3'];
    $boxes4 = $_POST['boxes4'];
    $rol = $_POST['rol'];
    $sup = $_POST['sup'];

    $result_z = $info->actualizar_estado($boxes, $sup, $boxes2, $boxes3, $boxes4);
    echo json_encode($result_z);
}

if ($estado == 'actualizarestado2') {
    $boxes = $_POST['boxes'];
    $boxes2 = $_POST['boxes2'];
    $boxes3 = $_POST['boxes3'];
    $boxes4 = $_POST['boxes4'];
    $rol = $_POST['rol'];
    $sup = $_POST['sup'];

    $result_z = $info->actualizar_estado2($boxes, $sup, $boxes2, $boxes3, $boxes4);
    echo json_encode($result_z);
}

if ($estado == 'procesarestado') {
    $boxes = $_POST['boxes'];
    $boxes2 = $_POST['boxes2'];
    $rol = $_POST['rol'];
    $sup = $_POST['sup'];

    $result_z = $info->procesar_estado($boxes, $sup, $boxes2);
    echo json_encode($result_z);
}

if ($estado == 'pagadoestado') {
    $boxes = $_POST['boxes'];
    $boxes2 = $_POST['boxes2'];
    $boxes3 = $_POST['boxes3'];
    $boxes4 = $_POST['boxes4'];
    $rol = $_POST['rol'];
    $sup = $_POST['sup'];

    if ($rol == 'C') {
        $result_z = $info->pagado_estado2($boxes, $sup, $boxes2);
    } else {
        $result_z = $info->pagado_estado($boxes, $sup, $boxes2, $boxes3, $boxes4);
    }

    echo json_encode($result_z);
}

if ($estado == 'procesadoextras') {
    //por contrallor
    $boxes3 = $_POST['boxes3'];
    $boxes4 = $_POST['boxes4'];
    $rol = $_POST['rol'];
    $sup = $_POST['sup'];

         $result_z = $info->procesado_extras($sup, $boxes3 ,$boxes4 );


    echo json_encode($result_z);
}


if ($estado == 'revisadoextras') {
    //por gerente
    $boxes3 = $_POST['boxes3'];
    $boxes4 = $_POST['boxes4'];
    $rol = $_POST['rol'];
    $sup = $_POST['sup'];

         $result_z = $info->revisado_extras($sup, $boxes3 ,$boxes4 );


    echo json_encode($result_z);
}

if ($estado == 'cancelaraccion') {
    $boxes = $_POST['boxes'];
    $boxes2 = $_POST['boxes2'];
    $boxes3 = $_POST['boxes3'];
    $boxes4 = $_POST['boxes4'];
    $rol = $_POST['rol'];
    $sup = $_POST['sup'];


        $result_z = $info->cancelar_accion($boxes, $sup, $boxes2, $boxes3, $boxes4);
  
    echo json_encode($result_z);
}



if ($estado == 'obtenerexento') {
    $oper = $_POST['oper'];

    $result_z = $info->obtenertipo($oper);

    echo json_encode($result_z);
}



if ($estado == 'mostrardatos_rrhh') {

    $sup = $_POST['sup'];
    $rol = $_POST['rol'];
    $admin = $_POST['admin'];
    $tablita = '';
    $nuevo = '';
    $tots = 0;

    $tablita .= '</br><b><label class="p-3 mb-2 bg-dark text-white"> PERSONAL A CARGO  DE <b>' . $sup . '</b> : </label></b>';

    $result_perf = $info->get_perfil_rrhh($sup, $admin);




    $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
     <tr class='bg-primary'>
    <th scope='col' onclick='sortTable(0)'>BADGE</th>
    <th scope='col' onclick='sortTable(1)'>OPERADORA</th>
    <th scope='col' onclick='sortTable(2)'>PUESTO</th>
    <th scope='col' onclick='sortTable(3)'>AREA</th>
    <th scope='col' onclick='sortTable(4)'>ESTADO</th>
    <th scope='col' onclick='sortTable(5)'>TURNO</th>
        </tr> ";

    foreach ($result_perf as $row) {
        if ($row['ESTADO'] == '') {
            $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
        } else {
            $nuevo = $row['ESTADO'];
        }
        # code...

        $tablita .= "<tr>";
        $tablita .= "<td>" . $row['BADGE'] . "</td>";
        $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
        $tablita .= "<td>" . $row['PUESTO'] . "</td>";
        $tablita .= "<td>" . $row['AREA'] . "</td>";
        $tablita .= "<td><center>" . $nuevo . "</center></td>";
        $tablita .= "<td>" . $row['TURNO'] . "</td>";
        $tablita .= "</tr>";

        $tots = $tots + 1;
    }

    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> TOTAL : (<b>' . $tots . '</b>) </label></b>';

    $tablita .= "</table>";

    echo  $tablita;
}

if ($estado == 'mostrardatos_rrhh' || $estado == 'mostrardatos_rrhh_all') {

    $sup = $_POST['sup'];
    $rol = $_POST['rol'];
    $admin = $_POST['admin'];
    $tablita = '';
    $nuevo = '';
    $tots = 0;

    $tablita .= '</br><b><label class="p-3 mb-2 bg-dark text-white"> PERSONAL A CARGO  DE <b>' . $sup . '</b> : </label></b>';


    if ($estado == 'mostrardatos_rrhh') {
        $result_perf = $info->get_perfil_rrhh($sup, $admin);
    } else {
        $result_perf = $info->get_perfil_rrhh_all();
    }




    $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
     <tr class='bg-primary'>
    <th scope='col' onclick='sortTable(0)'>BADGE</th>
    <th scope='col' onclick='sortTable(1)'>OPERADORA</th>
    <th scope='col' onclick='sortTable(2)'>PUESTO</th>
    <th scope='col' onclick='sortTable(3)'>AREA</th>
    <th scope='col' onclick='sortTable(4)'>ESTADO</th>
    <th scope='col' onclick='sortTable(5)'>TURNO</th>
        </tr> ";

    foreach ($result_perf as $row) {
        if ($row['ESTADO'] == '') {
            $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
        } else {
            $nuevo = $row['ESTADO'];
        }
        # code...

        $tablita .= "<tr>";
        $tablita .= "<td>" . $row['BADGE'] . "</td>";
        $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
        $tablita .= "<td>" . $row['PUESTO'] . "</td>";
        $tablita .= "<td>" . $row['AREA'] . "</td>";
        $tablita .= "<td><center>" . $nuevo . "</center></td>";
        $tablita .= "<td>" . $row['TURNO'] . "</td>";
        $tablita .= "</tr>";

        $tots = $tots + 1;
    }

    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> TOTAL : (<b>' . $tots . '</b>) </label></b>';

    $tablita .= "</table>";

    echo  $tablita;
}
