
<!DOCTYPE html>
<html lang="es-Es">

<head>
    <title>AVX-ES</title>
    <meta meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-escale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/logoAVX.ico">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body>
 
<?php

$usuario = $_POST["user1"];
$passw = $_POST["pass1"];
echo $usuario;
echo "<br>";
echo $passw;
echo "<br>";
echo sha1($passw);



?>
 

</body>

</html>