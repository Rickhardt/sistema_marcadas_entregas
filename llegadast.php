<?php

function llegadast($turno, $hora, $fecha, $radio)
{
   $dia = '';

   $dia = date('D', strtotime($fecha));

   if ($radio == 'E') {

      if ($turno == '1') {
         if ($dia == 'Mon' || $dia == 'Tue' || $dia == 'Wed' || $dia == 'Thu' || $dia == 'Fri' || $dia == 'Sat') {
            if ($hora > '06:10:00') {
               $horareal = 'danger';
            } else {
               $horareal =  'info';
            }
         } else {
            $horareal = 'warning';
         }
      } else if ($turno == '2') {
         if ($dia == 'Mon' || $dia == 'Tue' || $dia == 'Wed' || $dia == 'Thu' || $dia == 'Fri' || $dia == 'Sat') {
            if ($hora > '13:10:00') {
               $horareal = 'danger';
            } else {
               $horareal =  'info';
            }
         } else {
            $horareal = 'warning';
         }
      } else if ($turno == '3') {
         if ($dia == 'Mon' || $dia == 'Tue' || $dia == 'Wed') {
            if ($hora > '20:10:00') {
               $horareal = 'danger';
            } else {
               $horareal =  'info';
            }
         } else if ($dia == 'Sun') {
            if ($hora > '06:10:00') {
               $horareal = 'danger';
            } else {
               $horareal =  'info';
            }
         } else {
            $horareal = 'warning';
         }
      } else if ($turno == '4' || $turno == '5') {
         if ($dia == 'Thu' || $dia == 'Fri' || $dia == 'Sat' || $dia == 'Sun') {
            if ($hora > '20:10:00') {
               $horareal = 'danger';
            } else {
               $horareal =  'info';
            }
         } else {
            $horareal = 'warning';
         }
      } else if ($turno == 'A') {
         if ($dia == 'Mon' || $dia == 'Tue' || $dia == 'Wed' || $dia == 'Thu' || $dia == 'Fri' || $dia == 'Sat') {
            if ($hora > '07:40:00') {
               $horareal = 'danger';
            } else {
               $horareal =  'info';
            }
         } else {
            $horareal = 'warning';
         }
      }
   } else {
      $horareal =  'info';
   }




   return $horareal;
}
