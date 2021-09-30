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
    $area1 = $_POST['area1'];
    $estado1 = $_POST['estado1'];
    $turno1 = $_POST['turno1'];

    $result_d = $info->update_registro($responsable1, $badge1, $nombre1, $puesto1,$puesto2,$puesto3, $area1, $estado1, $turno1);
    $result_d = $info->update_registro_sup($badge1,$turno1);
    echo json_encode($result_d);
}

if ($estado == 'InsertOper') {
    $badge1 = $_POST['badge1'];
    $responsable1 = $_POST['responsable1'];
    $nombre1 = $_POST['nombre1'];
    $puesto1 = $_POST['puesto1'];
    $puesto2 = $_POST['puesto2'];
    $puesto3 = $_POST['puesto3'];
    $area1 = $_POST['area1'];
    $estado1 = $_POST['estado1'];
    $turno1 = $_POST['turno1'];

    $result_e = $info->insertar_registro($responsable1, $badge1, $nombre1, $puesto1,$puesto2,$puesto3, $area1, $estado1, $turno1);
    echo json_encode($result_e);
}

if ($estado == 'BuscarMarc') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $badge = $_POST['badge'];
    $radio = $_POST['radio'];
    $horareal = '';

    $result_f = $info->fill_marcadas($supervisor, $fecha, $area, $badge, $radio);
    
    $tablita = '';
    


    if ($_POST['fecha'] == '') {
    } elseif (count($result_f) != 0) {

       

        if ($radio == 'E') 
        {
           
        $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS- </b>:  " . count($result_f) . " MARCADAS !   </label>";

        }else if ($radio == 'S') {

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
        </tr> ";

        foreach ($result_f as $row) {
            
            # code...

           $horareal = llegadast($row['TURNO'],$row['HORA']);
     

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td class='text-" .$horareal ."'>" . $row['HORA'] ."</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'>ACCIONES</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "'  class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
        }

        $tablita .=  "</table> ";


        echo $tablita;
    }
}

if ($estado == 'BuscarMarc2') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $badge = $_POST['badge'];
    $radio = $_POST['radio'];
    $tablita = '';

    $tablita .= "<div id='divh' class='bg-primary'>";
    // resumen puestos

    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS MARCADOS:</b><br> ';


    $result_perf3 = $info->fill_marcadas_resumen($supervisor, $fecha, $area, $badge, $radio);

    $ct = 0;
    $ctdiv = '';

    $tablita .= '<table>';

    foreach ($result_perf3 as $row) {
    # code...
    $ct = $ct+1;

    $ctdiv = $ct/6;

    $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

    if ( strpos( $ctdiv, "." ) !== false ) {
    }else{
    $tablita .= '</table><table>';
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
                $ct = $ct+1;
            
                $ctdiv = $ct/6;
            
                $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';
            
            if ( strpos( $ctdiv, "." ) !== false ) {
            }else{
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

             $result_g = $info->get_perfil($supervisor);





              if (count($result_f) == count($result_g)) {
             } elseif (count($result_f) != '') {


     


            if ($radio == 'E') 
            {
               
                $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS-</b>  :  " . count($result_f) . " AUSENTE(S) !   </label>";
    
            }else if ($radio == 'S') {
    
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
            </tr> ";

            foreach ($result_f as $row) {
                # code...

                $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' >ACCIONES</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
                //$tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' onclick='abrircerrar('algo')'>NOTA</button></td></tr>";
            }

            $tablita .=  "</table> ";


            echo $tablita;
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

        if ($radio == 'E') 
        {
           
        $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS- </b>:  " . count($result_f) . " MARCADAS !   </label>";

        }else if ($radio == 'S') {

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
     </tr> ";

        foreach ($result_f as $row) {
            # code...

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td>" . $row['supervisor'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "'>ACCIONES</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "'  class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
        }

        $tablita .=  "</table> ";


        echo $tablita;
    }
}

/*malo */
if ($estado == 'BuscarMarc2_all') {
    $supervisor = $_POST['sup'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $badge = $_POST['badge'];
    $radio = $_POST['radio'];
     $tablita = '';


    if ($_POST['fecha'] == '') {
    } else {

        $tablita .= "<div id='divh' class='bg-primary'>";
        // resumen puestos
    
    $tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS MARCADOS:</b><br> ';
    
    
    $result_perf3 = $info->fill_marcadas_all_resumen($supervisor, $fecha, $area, $badge, $radio);
    
    $ct = 0;
    $ctdiv = '';
    
    $tablita .= '<table>';
    
    foreach ($result_perf3 as $row) {
        # code...
        $ct = $ct+1;
    
        $ctdiv = $ct/6;
    
        $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';
    
    if ( strpos( $ctdiv, "." ) !== false ) {
    }else{
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
   $ct = $ct+1;
                
   $ctdiv = $ct/6;
                
   $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';
                
   if ( strpos( $ctdiv, "." ) !== false ) {
   }else{
   $tablita .= '</table><table>';
    }
                
                
    }
    $tablita .= '</table>';
                
     $tablita .= '</label>';
                
                
    //fin
    $tablita .= "</div>";
     

        $result_f = $info->fill_marcadas_no_all($supervisor, $fecha, $area, $badge, $radio);

        $result_g = $info->get_perfil_all($supervisor);



        if (count($result_f) == count($result_g)) {
        } elseif (count($result_f) != '') {


            // $tablita = '';


            if ($radio == 'E') 
            {
               
                $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS-</b>  :  " . count($result_f) . " AUSENTE(S) !   </label>";
    
            }else if ($radio == 'S') {
    
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
     </tr> ";

            foreach ($result_f as $row) {
                # code...

                $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' >ACCIONES</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
                //$tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['NOMBRE_TRABAJADOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' onclick='abrircerrar('algo')'>ACCIONES</button></td></tr>";
            }

            $tablita .=  "</table> ";


            echo $tablita;
        }
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

        if ($radio == 'E') 
        {
           
            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS SUPERVISORES-</b>  :  " . count($result_f) . " MARCADAS !  </label>";

        }else if ($radio == 'S') {

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
        </tr> ";


        foreach ($result_f as $row) {
            # code...

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "' >ACCIONES</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
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

        if ($radio == 'E') 
        {
           
            $tablita .= "</br><label class='p-1 mb-2 bg-dark text-white'> MOSTRANDO <b> -ENTRADAS SUPERVISORES-</b>  :  " . count($result_f) . " AUSENTES !  </label>";

        }else if ($radio == 'S') {

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
        </tr> ";


        foreach ($result_f as $row) {
            # code...

            $tablita .=  "<tr><td>" . $row['BADGE'] . "</td><td>" . $row['SUPERVISOR'] . "</td><td>" . $row['PUESTO'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['ESTADO'] . "</td><td>" . $row['HORA'] . "</td><td>" . $row['TURNO'] . "</td><td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "' >ACCIONES</button></td><td><button type='button' data-ids='" . $row['BADGE'] . "' class='btn btn-info' data-toggle='modal' data-target='#exampleModal2'><img src='img/searchi.png' height='26' width='25'></button></td></tr>";
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
    $tipo = $_POST['tipo'];
    $septimo = $_POST['septimo'];

    $result_z = $info->insertar_log($supervisor, $fecha, $fecha_s, $oper, $nombre, $area, $observacion, $notas, $tipo, $septimo);
    echo json_encode($result_z);
}

if ($estado == 'BuscarNotas') {
    $supervisor = $_POST['supervisor'];
    $fecha = $_POST['fecha'];
    $fechaf = $_POST['fechaf'];
    $badge = $_POST['badge'];

    $result_Q = $info->fill_logs($supervisor, $fecha, $fechaf, $badge);

    $tablita = '';


    $tablita .= "</br><label class='p-3 mb-2 bg-dark text-white'> MOSTRANDO :  " . count($result_Q) . " LOGS! </label>";

    $tablita .=    " </br><table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>



    <tr class='bg-primary'>
    <th scope='col'>SUPERVISOR</th>
    <th scope='col'>FECHA</th>
    <th scope='col'>OPERARIA(O)</th>
    <th scope='col'>NOMBRE</th>
    <th scope='col'>AREA</th>
    <th scope='col'>OBSERVACION</th>
    <th scope='col'>NOTAS</th>
    
     </tr> ";

    foreach ($result_Q as $row) {


        $tablita .=  "<tr><td>" . $row['SUPERVISOR'] . "</td><td>" . $row['FECHA'] . "</td><td>" . $row['OPERARIO'] . "</td><td>" . $row['NOMBRE'] . "</td><td>" . $row['AREA'] . "</td><td>" . $row['OBSERVACION'] . "</td><td>" . $row['NOTAS'] . "</td></tr>";
    }

    $tablita .=  "</table> ";



    echo $tablita;
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


if ($estado == 'GetDetails') {
    $idn = $_POST['idn'];

    $result_Q = $info->get_nota_click($idn);

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


    $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
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
           if ($row['ESTADO'] == '')
           {
           $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
           }else{
               $nuevo = $row['ESTADO'] ;
           }
           # code...

           $tablita .= "<tr>";
           $tablita .= "<td>" . $row['BADGE'] . "</td>";
           $tablita .= "<td>" . $row['SUPERVISOR'] . "</td>";
           $tablita .= "<td>" . $row['PUESTO'] . "</td>";
           $tablita .= "<td>" . $row['AREA'] . "</td>";
           $tablita .= "<td><center>" . $nuevo. "</center></td>";
           $tablita .= "<td>" . $row['TURNO'] . "</td>";
           $tablita .= "<td>" . $row['ASIGNADO'] . "</td>";
           $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['SUPERVISOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo. "' data-turn1='" . $row['TURNO'] . "' data-asignado='" . $row['ASIGNADO'] . "' data-rolclick='A'>MOD</button></td>";
           // $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "R' class='btn btn-danger' onclick='f_borrar(this.id)'>X</button></td>";
           $tablita .= "</tr>";
       }

       $tablita .= "</table>";

      

    echo  $tablita;
}

if ($estado == 'mostrardatos') {

    $sup = $_POST['sup'];
    $rol = $_POST['rol'];
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


    $result_perf3 = $info->fill_resumen2($sup);

    $ct = 0;
    $ctdiv = '';

    $tablita .= '<table>';

    foreach ($result_perf3 as $row) {
    # code...
    $ct = $ct+1;

    $ctdiv = $ct/6;

    $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

    if ( strpos( $ctdiv, "." ) !== false ) {
    }else{
    $tablita .= '</table><table>';
    }


    }   
    $tablita .= '</table>';

    $tablita .= '</label>';


    //fin




    $tablita .= '</br><b><label class="p-3 mb-2 bg-dark text-white"> PERSONAL A CARGO  DE <b>' . $sup . '</b> : </label></b>';

    $result_perf = $info->get_perfil($sup);




    if ($rol == 'A') {


        $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
     <tr class='bg-primary'>
    <th scope='col'>BADGE</th>
    <th scope='col'>OPERADORA</th>
    <th scope='col'>PUESTO</th>
    <th scope='col'>AREA</th>
    <th scope='col'>ESTADO</th>
    <th scope='col'>TURNO</th>
    <th scope='col'></th>
        </tr> ";

        foreach ($result_perf as $row) {
            if ($row['ESTADO'] == '')
            {
            $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
            }else{
                $nuevo = $row['ESTADO'] ;
            }
            # code...

            $tablita .= "<tr>";
            $tablita .= "<td>" . $row['BADGE'] . "</td>";
            $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
            $tablita .= "<td>" . $row['PUESTO'] . "</td>";
            $tablita .= "<td>" . $row['AREA'] . "</td>";
            $tablita .= "<td><center>" . $nuevo. "</center></td>";
            $tablita .= "<td>" . $row['TURNO'] . "</td>";
            $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo. "' data-turn1='" . $row['TURNO'] . "'>MOD</button></td>";
            // $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "R' class='btn btn-danger' onclick='f_borrar(this.id)'>X</button></td>";
            $tablita .= "</tr>";
        }

        $tablita .= "</table>";

        echo  $tablita;
    } else if ($rol != 'A') {

        $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover' style='table-layout:fixed; width:'4000px'; >
        <tr class='bg-primary'>
       <th scope='col'>BADGE</th>
       <th scope='col'>OPERADORA</th>
       <th scope='col'>PUESTO</th>
       <th scope='col'>AREA</th>
       <th scope='col'>ESTADO</th>
       <th scope='col'>TURNO</th>
       <th scope='col'></th>
       </tr> ";

        foreach ($result_perf as $row) {
            if ($row['ESTADO'] == '')
            {
            $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
            }else{
                $nuevo = $row['ESTADO'] ;
            }
            # code...

            $tablita .= "<tr>";
            $tablita .= "<td>" . $row['BADGE'] . "</td>";
            $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
            $tablita .= "<td>" . $row['PUESTO'] . "</td>";
            $tablita .= "<td>" . $row['AREA'] . "</td>";
            $tablita .= "<td><center>" . $nuevo . "</center></td>";
            $tablita .= "<td>" . $row['TURNO'] . "</td>";
            $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo. "' data-turn1='" . $row['TURNO'] . "'>MOD</button></td>";
            // $tablita .= "<td></td>";
            $tablita .= "</tr>";
        }

        $tablita .= "</table>";

        echo  $tablita;
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
        
        $opert = substr($row['OPER'],0,30);
    

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
             

                    $tablita .= '<center><img src="img/warn.png" height="20" width="20" id='. $result_Q[0] . ' title=' . $result_Q[0] . ' onclick="ejecutar_busqueda(' . $row['BADGE'] .',/' .$comparador[$p].'/)" data-dismiss="modal"></center>';     

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



if ($estado == 'UpdateBita') {
    $accion = $_POST['accion'];
    $super = $_POST['super'];
    $fechahora = $_POST['fechahora'];
    $operario = $_POST['operario'];
    $puesto = $_POST['puesto'];
    $estado2 = $_POST['estado2'];
    $transfer = $_POST['transfer'];

    
     
    

    $result_y = $info->bitacora_update($accion,$super,$fechahora,$operario,$puesto,$estado2,$transfer);
    echo json_encode($result_y);



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

    $ejex = '';
    $ejey = '';

    $result_U = $info->grafs_wk_ausentismo($fini,$ffin);
    
    foreach ($result_U  as $row) {
     $ejex .= $row['YW'];
     $ejey .= $row['CT'];
    }


 

     echo $ejey;

 
    
}




if ($estado == 'mostrardatos_all') {

    $sup = $_POST['sup'];
    $rol = $_POST['rol'];
    $tablita = '';
    $nuevo = '';


    echo '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN</b> </br> ';


    $result_perf2 = $info->fill_resumen_all($sup);

    foreach ($result_perf2 as $row) {
        # code...


        $tablita .= '' . $row['ESTADO'] . '(' . $row['TOTAL'] . ') ';
    }

   $tablita .= '</label>';




$tablita .= '<label class="p-3 mb-2 bg-dark text-white"> <b>RESUMEN PUESTOS:</b><br> ';


$result_perf3 = $info->fill_resumen2_all($sup);

$ct = 0;
$ctdiv = '';

$tablita .= '<table>';

foreach ($result_perf3 as $row) {
    # code...
    $ct = $ct+1;

    $ctdiv = $ct/6;

    $tablita .= '<th scope="col"><tr class="bg-primary">| ' . $row['PUESTO'] . '(' . $row['TOTAL'] . ') </tr></th>';

if ( strpos( $ctdiv, "." ) !== false ) {
}else{
    $tablita .= '</table><table>';
}
}


$tablita .= '|</table>';

$tablita .= '</label>';



   

    $tablita .= '</br><b><label class="p-3 mb-2 bg-dark text-white"> PERSONAL A CARGO  DE SUS SUPERVISORES : </label></b>';

    $result_perf = $info->get_perfil_all($sup);




    if ($rol == 'A') {


        $tablita .=  "<table id='table' class='table table-striped table-dark table-bordered table-hover table-sm'>
     <tr class='bg-primary'>
    <th scope='col'>BADGE</th>
    <th scope='col'>OPERADORA</th>
    <th scope='col'>PUESTO</th>
    <th scope='col'>AREA</th>
    <th scope='col'>ESTADO</th>
    <th scope='col'>TURNO</th>
    <th scope='col'>SUPERVISOR</th>
    <th scope='col'></th>
        </tr> ";

        foreach ($result_perf as $row) {
            if ($row['ESTADO'] == '')
            {
            $nuevo = '<img src="img/warn.png" height="15" width="15">NUEVO<img src="img/warn.png" height="15" width="15">';
            }else{
                $nuevo = $row['ESTADO'] ;
            }
            # code...

            $tablita .= "<tr>";
            $tablita .= "<td>" . $row['BADGE'] . "</td>";
            $tablita .= "<td>" . $row['NOMBRE_TRABAJADOR'] . "</td>";
            $tablita .= "<td>" . $row['PUESTO'] . "</td>";
            $tablita .= "<td>" . $row['AREA'] . "</td>";
            $tablita .= "<td><center>" . $nuevo. "</center></td>";
            $tablita .= "<td>" . $row['TURNO'] . "</td>";
            $tablita .= "<td>" . $row['SUPERVISOR'] . "</td>";
            $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $row['BADGE'] . "' data-nombre='" . $row['NOMBRE_TRABAJADOR'] . "' data-area='" . $row['AREA'] . "' data-puesto='" . $row['PUESTO'] . "'  data-estado='" . $nuevo. "' data-turn1='" . $row['TURNO'] . "'>MOD</button></td>";
            // $tablita .= "<td><button type='button' id='" . $row['BADGE'] . "R' class='btn btn-danger' onclick='f_borrar(this.id)'>X</button></td>";
            $tablita .= "</tr>";
        }

        $tablita .= "</table>";

        echo  $tablita;
    } else if ($rol != 'A') {

    }

}




    






