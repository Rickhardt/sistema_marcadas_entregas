<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>ENTREGAS AVX</title>
  <link rel="stylesheet" href="./style.css">
  <meta name="viewport" content="width=device-width, initial-escale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="img/logoAVX.ico">
  
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- <script src="jquery/jquery-3.4.1.min.js"></script>
  <script src="jquery/sweetalert2.all.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script> -->
  <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">  -->
  <script src="js/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
  <link rel="shortcut icon" href="img/AVX Kyocera Logo.png">
  <link rel="stylesheet" href="img/load.css">
</head>

<!-- // LLENAR TABLA ENTREGAS
        
        DELETE FROM ENTREGAS_VIVERES;
        
        INSERT INTO ENTREGAS_VIVERES (BADGE, NOMBRE, AREAEMPLEADO, NOMAREA, TIPO_ENTREGA, FECHAHORA, ESTADO, ENTREGO,CORR,NOTA,PAGO)
        SELECT BADGE, NOMBRE, AREAEMPLEADO, NOMAREA, 'CHOMPIPOLLO',NULL,'PENDIENTE',NULL,'ENTREGA1',NULL,'NA' FROM EMPLEADOSAREAS; -->
<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 10%;
  }

  td,
  th {
    border: 1px solid black;
    text-align: center;
    background-color: lightblue;
    padding: 8px;
  }

  body {
    font-family: Arial, Helvetica, sans-serif;
  }

  /* The Modal (background) */
  .modal3 {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
  }

  /* Modal Content */
  .modal3-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
</style>

<body>

    <nav class="navbar navbar-expand-md fixed-top bg-dark">
        <a class="navbar-brand text-center text-uppercase font-weight-bolder text-light" style="font-size: x-large;" href="#" onclick="javascript:window.location.reload();"><img class="d-inline-block pr-2" src="img/AVX Kyocera Logo.png" title="Logo AVX" style="height: 75px;">Entrega de badge</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item btn btn-dark font-weight-bolder ml-2" style="background-color: rgb(0, 60, 90);">
                    <a id="mostrar_aql_electrico" name="mostrar_aql_electrico" class="nav-link" onclick="showLogin()">Login</a>
                </li>

                <li class="nav-item btn btn-dark font-weight-bolder ml-2" style="background-color: rgb(0, 163, 224);">
                    <a id="mostrar_test_house" name="mostrar_test_house" class="nav-link" onclick="cargar_entregas()">Entrega</a>
                </li>

                <li class="nav-item btn btn-danger font-weight-bolder ml-2">
                    <a id="mostrar_aql_final" name="mostrar_aql_final" class="nav-link">Resumen</a>
                </li>
            </ul>
        </div>
    </nav>

  <!-- partial:index.partial.html -->
  <!-- <ul class="nav"> -->
    <!-- <li onclick="showLogin()">Login</li>
    <li onclick="cargar_entregas()">Entrega</li>
    <li onclick="mostrar_resumen()">Resumen</li> -->
    <!-- <li onclick="showForgotPassword()">Forgot password</li> -->
    <!-- <li onclick="showContactUs()">Soporte</li>
  </ul> -->

  <div class="container pt-5 mt-5">
    <div class="row pr-5">
      <div class="col-md-7 align-items-right">
        <img src="img/Chompi Sistema.jpg" alt="" title="Información cambio de badge" style="height: 30%;">
      </div>

      <div class="col-md-auto pr-5">
        <div class="wrapper">
          <div class="rec-prism">
            <div class="face face-top">
              <div class="content">
                <small><label>Usuario entregando :</label></small>
                <label id="usc"></label>
                <!-- <input type="button" onclick="verificar()" value="VERIFICAR"> -->
                <form onsubmit="event.preventDefault()">

                  <!-- <input type="text" name="nota" id="nota" placeholder="NOTA" maxlength="50" autocomplete="off">
                  <input type="checkbox" id="PAGO" name="PAGO" value="PAGO" disabled><small>Pago </small>
                  <input type="checkbox" id="AGOTADO" name="AGOTADO" value="AGOTADO" ><small>Agotado </small> -->

                  <input type="number" name="badge" id="badge" placeholder="BADGE" maxlength="5" autocomplete="off">
                  <div class="field-wrapper">
                    <input type="submit" onclick="guardar_entrega()" value="ENTREGAR">
                  </div>
                </form>
              </div>
            </div>
            <div class="face face-front">
              <div class="content">
                <h2>Logeo</h2>
                <form onsubmit="event.preventDefault()">
                  <div class="field-wrapper">
                    <input type="text" name="username" id="username" placeholder="username" autocomplete="off">
                    <label>usuario</label>
                  </div>
                  <div class="field-wrapper">
                    <input type="password" name="password" id="password" placeholder="password" autocomplete="new-password">
                    <label>contraseña</label>
                  </div>
                  <div class="field-wrapper">
                    <input type="submit" onclick="logearse()" value="INGRESAR">
                  </div>
                  <span class="psw" onclick="showForgotPassword()">Olvido su contraseña? </span>

                </form>
              </div>
            </div>
            <div class="face face-back">
              <div class="content">
                <div class="content">
                  <h2>Soporte</h2>
                  <form onsubmit="event.preventDefault()">

                  </form>

                </div>
                </form>
              </div>
            </div>
            <div class="face face-right">
              <div class="content">
                <h2>Resumen : <button id="myBtn">Detalle</button><button id="refr" onclick="get_graf_data()">R</button></h2>
                <form onsubmit="event.preventDefault()">

                  <div id="canv">
                    <canvas id="oilChart" width="100" height="50"></canvas>
                  </div>
                  <label id="resumen"> </label>
                </form>
              </div>
            </div>
            <div class="face face-left">
              <div class="content">
                <h2>Soporte</h2>
                <form onsubmit="event.preventDefault()">
                  <h2>Contactar IT Ext 481</h2>
                  <h2>Version 2.2.0 </h2>
                  <h2>14/12/2020</h2>
                  <div id='especial'></div>
                </form>
              </div>
            </div>
            <div class="face face-bottom">
              <div class="content">

                MUCHAS GRACIAS : <br>
                <div id="entregado"></div>
                <div class="thank-you-msg" onfocus="doAdelay()">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>      
  </div>
  <!-- <img src="img/avxlogo.jpg" width="400px" height="300px" title='AVX INDUSTRIES Ltd.'> -->
  <!-- <img src="img/hdays.png" width="400px" height="300px" title='AVX INDUSTRIES Ltd.'> -->
  <!-- partial -->
  <script src="./script.js"></script>

  <!-- The Modal -->
  <div id="myModal" class="modal3">

    <!-- Modal content -->
    <div class="modal3-content">
      <span class="close">&times;</span>
      <p><b>
          <h1>DETALLES DE ENTREGAS :
        </b></h1>
      </p>

      <div id="detallesd3" style="display: inline-block; width: 325px; height: 700px; overflow-y: scroll;"></div>
      <div id="detallesd2" style="display: inline-block; width: 400px; height: 700px; overflow-y: scroll;"></div>
      <div id="detallesd" style="display: inline-block; width: 475px; height: 700px; overflow-y: scroll;"></div>

      <br><br>
      <label> FILTRAR AREA : </label>
      <input type="text" id="areab" name="areab" style="background-color:lightblue" /> <br>
      <label> DIGITE UNA AREA A BUSCAR (PRESIONE ENTER) </label>
    </div>

  </div>

  <!-- Modal para ingreso de credenciales de QC -->
  <div class="modal fade " id="usarioIngresoDatos" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="usarioIngresoDatosLabel" aria-hidden="true" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usarioIngresoDatosLabel">Por favor, ingrese el correlativo correspondiente</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formModal" name="formModal" autocomplete="off">
                            <div class="row justify-content-center">
                                <div class="mt-1 ml-1 col-md border border-dark rounded">
                                    <div class="justify-content-center">
                                        <div class="row mt-3 ml-1 mb-3">
                                            <div class="form-group mb-2 col-md-4">
                                                <label for="camaras" class="sr-only">Correlativo</label>
                                                <input type="text" readonly class="form-control-plaintext" value="Correlativo">
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <input maxlength = "4" type="number" class="form-control" id="correlativo" name="correlativo" placeholder="" value="" required pattern="[0-9]+">
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="boton_cerrar_qc" type="button" class="btn btn-secondary" data-dismiss="modal" onclick="javascript:boton_qc_cerrar();">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="javascript:oir_boton_qc();">Autorizar</button>
                </div>
                </div>
            </div>
    </div>
  <!----------------------------------------------------------------------------------------------------->

        <script src="jquery/jquery-3.4.1.min.js"></script>
        <script src="jquery/sweetalert2.all.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">

$('#usarioIngresoDatos').modal('hide');
  var x;
  var y;
  var nombreEmpleado = "";
  var entregado;
  var nameArr;
  var areadt;
  var notag = '';
  var badge = 0;
  var user = "";
  var value = false;

  $('#usarioIngresoDatos').on('shown.bs.modal', function (event) {
    document.getElementById('correlativo').focus();
  });

  $('#usarioIngresoDatos').on('keypress',function(e) {
    if(e.which == 13) {

      correlativo = document.getElementById("correlativo").value;

      if(correlativo.length < 4) return;
      else if(correlativo.length > 4) {
        swal.fire({
              title: "Error con el correlativo ingresado",
              text: "El correlativo debe cualquier valor entre 0001 y 3000.                   Se ha ingresado: " + correlativo,
              showConfirmButton: true,
              icon: "error",
              width: 750,
        });

        document.getElementById("correlativo").value = "";
        return;
      } else oir_boton_qc();

    }
  });


  function mostrar_resumen() {
    if (document.getElementById('usc').innerHTML != '') {
      showSignup()
      get_graf_data()
    } else {
      swal.fire({
        title: "Error!",
        text: "No hay usuario conectado!",
        showConfirmButton: false,
        icon: "error",
        timer: 2000
      }).then(function() {

      });
    }

  }

  function guardar_entrega() {
    document.getElementById('badge').focus();
    // notag = document.getElementById('nota').value

    var str = document.getElementById('badge').value;
    var n = str.length;

    //* ver si existe*//
    if (document.getElementById('badge').value == '') {
      document.getElementById('badge').value = ''
      swal.fire({
        title: "Error!",
        text: "No ha ingresado un badge!",
        showConfirmButton: false,
        icon: "error",
        timer: 2000
      }).then(function() {

      });
    } else if (n < 5) {
      document.getElementById('badge').value = ''
      swal.fire({
        title: "Error!",
        text: "Badge incompleto",
        showConfirmButton: false,
        icon: "error",
        timer: 2000
      }).then(function() {

      });
    } else {
      // document.getElementById('badge').value = '%' + document.getElementById('badge').value + '_';

      var str1 = document.getElementById('badge').value;
      var res1 = str.replace("%", "");
      var res2 = res1.substring(0, 5);

      document.getElementById('badge').value = res2;
      console.log(res2);

      $.ajax({
        type: "POST",
        url: "inter_entregas.php",
        data: {
          badge: res2,
          estado: 'buscar'
        },
        success: function(r) {
          r = parseInt(r);
          if (r != 1) {
            swal.fire({
              title: "Error!",
              text: "Badge NO ENCONTRADO!",
              showConfirmButton: false,
              icon: "error",
              timer: 2000
            }).then(function() {
              document.getElementById('badge').focus();
              document.getElementById('badge').value = '';
            });
          } else {
            function_guardar();
          }

        }
      });


    }
  }

  function function_guardar() {
    // console.log(document.getElementById('badge').value);
    // console.log(document.getElementById('usc').innerHTML);

    var nombre = '';

    $.ajax({
      type: "POST",
      url: "inter_entregas.php",
      data: {
        badge: document.getElementById('badge').value,
        estado: 'entregado'
      },
      success: function(r) {
        r = parseInt(r);
        if (r == 1) {

          swal.fire({
            title: "Error!",
            text: "¡Ya se entrego su badge!",
            showConfirmButton: false,
            icon: "error",
            timer: 3000
          }).then(function() {
            document.getElementById('badge').focus();
            document.getElementById('badge').value = '';
          });
        } else {
          badge = parseInt(document.getElementById('badge').value);
          user = document.getElementById('usc').innerHTML;
          
          $.ajax({
                    type: "POST",
                    url: "inter_entregas.php",
                    datatype: "html",
                    data: {
                      badge: document.getElementById('badge').value,
                      estado: 'nombre'
                    },
                    success: function(r) {

                      nombreEmpleado = r;

                      swal.fire({
                          title: "¿Es la persona correcta?",
                          //text: "Debe ingresar el correlativo",
                          html: "<div class='container'><div class='row justify-content-center'><div class='col-md-auto align-items-center'><img src='<?= 'https://sistemas.avxels.com/tools/empimg.php?name=' ?>" + $('#badge').val() + "' title='Información cambio de badge' width='300px' height='300px'></div></div><div class='row justify-content-center'><h5>" + nombreEmpleado + "</h5></div></div><center><img src='img/AVX Kyocera Logo.png' style='height: 100px;' title='Kyocera AVX Components Corporation.'></center>",
                          showDenyButton: true,
                          showCancelButton: true,
                          reverseButtons: true,
                          confirmButtonText: 'Sí, es esta persona',
                          denyButtonText: 'No, es la persona equivocada',
                          icon: "question",
                          allowOutsideClick: false,
                      }).then((result) =>{
                        if (result.value) {
                          GuardarDatos();
                        } else if (result.dismiss === 'cancel') {
                          swal.fire({
                            title: "Operación cancelada por el usuario",
                            text: "No se ha guardado nada",
                            showConfirmButton: false,
                            icon: "info",
                            timer: 3000,
                            width: 550,
                          });

                          document.getElementById('badge').value = '';
                        }
                      });
                      return;
                    }
                  })
        }
      }
    });
  }

  function GuardarDatos() {
    $.ajax({
            type: "POST",
            url: "inter_entregas.php",
            data: {
              badge: badge,
              user: user,
              notag: notag,
              estado: 'actualizar'
            },
            success: function(r) {

              if(r != "\r\n\r\n\r\n\r\n\r\n"){
                (async () => {

                    const { value: status } = await swal.fire({

                        title: "¡Uy! Ha habido un problema",
                        text: r,
                        showConfirmButton: true,
                        icon: "info",
                        width: 750,
                        inputValidator: (value) => {
                            return new Promise((resolve) => {
                                if (dismiss === 'close') {
                                  resolve();
                                }
                            })
                        }
                    })
                    // ModalCorrelativo();
                    document.getElementById('badge').value = '';
                    document.getElementById('badge').focus();
                })()
                return;
              } else MensajeFinalizacion();
              //get_graf_data()
            }
          });
  }

  //Modal para ingresar correlativo de badge de transporte.
  function ModalCorrelativo(){
    $('#usarioIngresoDatos').modal('show');
    document.getElementById('correlativo').focus();
    //$('#usarioIngresoDatos').modal('hide');
  }

  function boton_qc_cerrar() {
    
      enviarDatos = false
      $('#usarioIngresoDatos').modal('hide');

      (async () => {

          const { value: status } = await swal.fire({

              title: "Se ha abortado el ingresado de datos.",
              text: "No se han guardado datos. Debera ingresar el badge nuevamente.",
              showConfirmButton: true,
              icon: "info",
              inputValidator: (value) => {
                  return new Promise((resolve) => {
                      if (dismiss === 'close') {
                        resolve();
                      }
                  })
              }
          })
          document.getElementById('badge').value = '';
          document.getElementById('correlativo').value = '';
          document.getElementById('badge').focus();
      })()
      return;
  }

  function oir_boton_qc() {

      // badge = document.getElementById("badge_qc").value;
      correlativo = document.getElementById("correlativo").value;

      if (correlativo == "") {

          swal.fire({
              title: "Error en datos ingresados",
              text: "Debe ingresar el correlativo",
              showConfirmButton: true,
              icon: "error",
          });

          document.getElementById("formModal").reset();
          return;
      } else if(correlativo.length > 4 || correlativo.length < 4 || correlativo == '') {
        swal.fire({
              title: "Error con el correlativo ingresado",
              text: "El correlativo debe cualquier valor entre 0001 y 3000.                   Se ha ingresado: " + correlativo,
              showConfirmButton: true,
              icon: "error",
              width: 750,
        });

        document.getElementById("correlativo").value = "";
        return;
      }

      $.ajax({
          type: "POST",
          url: "inter_entregas.php",
          data: {
                 badge: badge,
                 correlativo: correlativo,
                 user: user,
                 notag: notag,
                 estado: "ingreso_correlativo"
                },
          success: function(response) {
                  
              console.log(response);

              if(response.trim() != ""){

                  if(response.trim() == 1) {
                    (async () => {

                        const { value: status } = await swal.fire({

                            title: "Al Parece existe un problema",
                            text: "El correlativo ingresado ya ha sido usado con otro usuario.",
                            showConfirmButton: true,
                            icon: "info",
                            inputValidator: (value) => {
                                return new Promise((resolve) => {
                                    if (dismiss === 'close') {
                                      resolve();
                                    }
                                })
                            }
                        })
                        document.getElementById('badge').value = '';
                        document.getElementById('correlativo').value = '';
                        document.getElementById('badge').focus();
                    })()
                    document.getElementById("correlativo").value = '';
                    return;

                  } else {
                    document.getElementById("formModal").reset();
                    swal.fire({
                        title: "Al Parece existe un problema",
                        text: "Hubo un error al ingresar datos, verifique en consola que pudo haber salido mal",
                        showConfirmButton: true,
                        icon: "error",
                    })
                  }
                  return;
                  
              } else {

                  enviarDatos = true;
                  $('#usarioIngresoDatos').modal('hide');
                  document.getElementById("correlativo").value = '';
                  MensajeFinalizacion();
              }
          },             //End of response function
      });                //End of AJAX (verificación badge)
  }

  function MensajeFinalizacion(){
    $.ajax({
              type: "POST",
              url: "inter_entregas.php",
              datatype: "html",
              data: {
                badge: document.getElementById('badge').value,
                estado: 'nombre'
              },
              success: function(r) {
                // new Audio('navidad.mp3').play()

                // document.getElementById('nota').value = ''

                (async () => {

                    const { value: status } = await swal.fire({

                        title: "Chompipollo entregado",
                        text: 'Se registró la entrega a: ' + nombreEmpleado + '. Ya puede regresarle su badge',
                        //html: "<img src='https://sistemas.avxslv.com/marcadas/ids/" + document.getElementById('badge').value + ".jpg' width='400px' height='300px'><br> " + r + "   <center><img src='img/navidad.jpg' width='400px' height='200px' title='AVX INDUSTRIES Ltd.'></center>",
                        //html: "<img src='ids/" + document.getElementById('badge').value + ".jpg' style='height: 50%;'><br> " + r + "   <center><img src='img/AVX Kyocera Logo.png' style='height: 100px;' title='Kyocera AVX Components Corporation.'></center>",
                        showConfirmButton: true,
                        icon: "info",
                        width: 750,
                        inputValidator: (value) => {
                            return new Promise((resolve) => {
                                if (dismiss === 'close') {
                                  resolve();
                                }
                            })
                        }
                    })
                    // ModalCorrelativo();
                    document.getElementById('badge').value = '';
                    document.getElementById('badge').focus();
                })()
              }
            })
  }



  function cargar_entregas() {

    if (document.getElementById('usc').innerHTML == '') {
      swal.fire({
        title: "Error!",
        text: "No hay usuario conectado!",
        showConfirmButton: false,
        icon: "error",
        timer: 5000
      }).then(function() {
        window.location.reload();
      });
    } else {
      showSubscribe()
      document.getElementById('badge').focus();
    }

  }


  function logearse() {
    document.getElementById('usc').innerHTML != ''
    get_graf_data()
    x = document.getElementById('username').value;
    y = document.getElementById('password').value;

    if (x == "") {
      Swal.fire({
        icon: 'error',
        title: 'Error...',
        text: 'Ingrese un usuario valido!'
      }).then(function() {
        window.location.reload();

      });

    } else if (y == "") {
      Swal.fire({
        icon: 'error',
        title: 'Error...',
        text: 'Ingrese un Password valido!'
      }).then(function() {
        window.location.reload();

      });


    } else {
      /* Ingresos de datos */
      // var datos = $('#FormLog').serialize();
      $.ajax({
        type: "POST",
        url: "inter_entregas.php",
        data: {
          username: x,
          password: y,
          estado: 'logearse'
        },
        success: function(r) {
          r = parseInt(r);
          if (r == 1) {
            document.getElementById('usc').innerHTML = x
            showSubscribe()
            document.getElementById('badge').focus();

            if (document.getElementById('username').value == 'DANIELE') {
              $('#especial').html('<input type="text" name="espe" id="espe" placeholder="BADGE" maxlength="5" autocomplete="off"> <input type="text" name="espen" id="espen" placeholder="NOTA" maxlength="50" autocomplete="off"> <input type="button" onclick="update_oper()" value="BORRAR ENTREGA"><input type="button" onclick="update_operN()" value="AGREGAR NOTA">');

            } else {
              $('#especial').html('');
            }

          } else if (r == 99) {
            document.getElementById('usc').innerHTML = ''
            swal.fire({
              title: "Error!",
              text: "Usuario o password incorrecto!",
              showConfirmButton: false,
              icon: "error",
              timer: 5000
            }).then(function() {
              window.location.reload();
            });
          } else {
            alert("ERROR DESCONOCIDO" + r);
          }


        }
      });

      return false;
    }
  }

  function get_graf_data() {

    $.ajax({
      type: "POST",
      datatype: "JSON",
      url: "inter_entregas.php",
      data: {
        username: x,
        password: y,
        estado: 'data_graf'
      },
      success: function(r) {
        nameArr = JSON.parse(r);
        grafs()
      }
    });
  }

  truncateDecimals = function(number, digits) {
    var multiplier = Math.pow(10, digits),
      adjustedNum = number * multiplier,
      truncatedNum = Math[adjustedNum < 0 ? 'ceil' : 'floor'](adjustedNum);

    return truncatedNum / multiplier;
  };

  function grafs() {
    $('#canv').html('');
    $('#canv').html(' <canvas id="oilChart" width="100" height="50"></canvas>');

    var total = parseInt(nameArr[0]) + parseInt(nameArr[1]) + parseInt(nameArr[2]);
    var porcE = ((parseInt(nameArr[0]) * 100) / parseInt(total));
    var porcP = (parseInt((nameArr[1]) * 100) / parseInt(total));
    var porcPE = (parseInt((nameArr[2]) * 100) / parseInt(total));

    var truncatedE = truncateDecimals(porcE, 2)
    var truncatedP = truncateDecimals(porcP, 2)
    var truncatedPE = truncateDecimals(porcPE, 2)

    var oilCanvas = document.getElementById("oilChart");

    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 12;

    var oilData = {
      // labels: [
      //   "Pendientes",
      //   "Entregados",
      //   "Pend-Entre"
      // ],
      datasets: [{
        data: [truncatedE, truncatedP,truncatedPE ],
        backgroundColor: [
          "#FF6384",
          "#63FF84",
          "#ffff00"
        ],
        borderColor: "black",
        borderWidth: 2
      }]
    };

    var chartOptions = {
      rotation: -Math.PI,
      cutoutPercentage: 15,
      circumference: Math.PI,
      legend: {
        position: 'bottom',

      },
      animation: {
        animateRotate: true,
        animateScale: true,
      },
      plugins: {
        datalabels: {
          color: 'black',
          Size: 5,
          formatter: (value) => {
            return value + ' %';
          }

        }
      }
    };


    var pieChart = new Chart(oilCanvas, {
      type: 'doughnut',
      data: oilData,
      options: chartOptions
    });
    document.getElementById('resumen').innerHTML = '';
    document.getElementById('resumen').innerHTML = '<table id="table1"><tr><td  style="background-color:#FF6384">PENDIENTES</td><td>' + nameArr[0] + ' (' + truncatedE + '%)</td></tr><tr><td  style="background-color:#63FF84">ENTREGADOS</td><td>' + nameArr[1] + ' (' + truncatedP + '%)</td></tr><tr><td  style="background-color:#ffff00">AGOTADOS</td><td>' + nameArr[2] + ' (' + truncatedPE + '%)</td></tr></table><br>TOTAL ' + total + '';


  }

  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks the button, open the modal 
  btn.onclick = function() {
    modal.style.display = "block";
    alldata()
  }

  function alldata() {
    areadt = document.getElementById('areab').value;
    detalle_datos()
    detalle_datos2()
    detalle_datos3()
    get_graf_data()
  }



  $("#areab").keypress(function(event) {
    if (event.keyCode === 13) {
      alldata();
    }
  });


  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  function detalle_datos() {
    $.ajax({
      type: "POST",
      url: "inter_entregas.php",
      datatype: "html",
      data: {
        estado: 'graf_quiebre',
        areadt: areadt
      },
      beforeSend: function() {
        $("#detallesd").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>Cargando..Quiebre area/turno<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
      },
      success: function(r) {
        $('#detallesd').html('');
        $('#detallesd').html(r);

      }
    });
  }

  function detalle_datos2() {

    $.ajax({
      type: "POST",
      url: "inter_entregas.php",
      datatype: "html",
      data: {
        estado: 'graf_quiebre_area',
        areadt: areadt
      },
      beforeSend: function() {
        $("#detallesd2").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>Cargando..Quiebre area<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
      },
      success: function(r) {
        $('#detallesd2').html('');
        $('#detallesd2').html(r);
      }
    });
  }


  function detalle_datos3() {

    $.ajax({
      type: "POST",
      url: "inter_entregas.php",
      datatype: "html",
      data: {
        estado: 'graf_quiebre_turno',
        areadt: areadt
      },
      beforeSend: function() {
        $("#detallesd3").html("<center><div class='loadingio-spinner-dual-ring-kg7694wxz0m'>Cargando..Quiebre turno<div class='ldio-g231xinhegs'><div></div><div><div></div></div></div></div></center>");
      },
      success: function(r) {
        $('#detallesd3').html('');
        $('#detallesd3').html(r);


      }

    });
  }


  function verificar() {
    $.ajax({
      type: "POST",
      url: "inter_entregas.php",
      datatype: "html",
      data: {
        badge: document.getElementById('badge').value,
        estado: 'verificar2'
      },
      beforeSend: function() {

      },
      success: function(r) {

        if (r != '') {
          swal.fire({
            title: "INFORMACION DE EMPLEADO(A)!",
            html: r,
            showConfirmButton: true,
            icon: "info"
          }).then(function() {
            document.getElementById('badge').focus();
          });
        } else {
          swal.fire({
            title: "INFORMACION DE EMPLEADO(A)!",
            html: r + "NO SE ENCONTRARON RESULTADOS",
            showConfirmButton: true,
            icon: "info"
          }).then(function() {
            document.getElementById('badge').focus();
          });
        }

      }
    });



  }

  function update_oper() {

    if (document.getElementById('espe').value != '') {
      $.ajax({
        type: "POST",
        url: "inter_entregas.php",
        datatype: "html",
        data: {
          estado: 'update_oper',
          badge: document.getElementById('espe').value
        },
        beforeSend: function() {},
        success: function(r) {
          document.getElementById('espe').value = '';
          swal.fire({
            title: "PROCESADO!",
            text: "SE RESETEO OPERADOR",
            showConfirmButton: true,
            icon: "info"
          }).then(function() {
            document.getElementById('badge').focus();
          });

        }

      });
    } else {
      swal.fire({
        title: "Error!",
        text: "Ingrese BADGE!",
        showConfirmButton: false,
        icon: "error",
        timer: 2000
      }).then(function() {

      });
    }

  }

  function update_operN() {

    if (document.getElementById('espe').value != '' ) {
        $.ajax({
          type: "POST",
          url: "inter_entregas.php",
          datatype: "html",
          data: {
            estado: 'update_operN',
            badge: document.getElementById('espe').value,
            nota: document.getElementById('espen').value,
          },
          beforeSend: function() {},
          success: function(r) {
            document.getElementById('espe').value = '';
            document.getElementById('espen').value = '';
            swal.fire({
              title: "PROCESADO!",
              text: "SE AGREGO NOTA",
              showConfirmButton: true,
              icon: "info"
            }).then(function() {
              document.getElementById('badge').focus();
            });

          }

        });
    } else {

      swal.fire({
          title: "Error!",
          text: "Ingrese BADGE!",
          showConfirmButton: false,
          icon: "error",
          timer: 2000
        }).then(function() {

        });

    }
  }

</script>
</body>

</html>