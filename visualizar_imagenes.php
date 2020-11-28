<?php
var_dump($_GET);
require "class/Directorio.php";
//Inicializamos varialbes
$idiomas = new Directorio();

$idioma = filter_input(INPUT_GET, "idioma", FILTER_SANITIZE_STRING);

$imagenes = $idiomas->get_ficheros("./idiomas",$idioma);
if ($imagenes ===false) {
    header("Location:index.php?msj=No se ha podido leer imágenes de $idioma");
    exit();
}


$listado="null";
foreach ($imagenes as $imagen) {
    $listado.="<img src ='./idiomas/$idioma/$imagen'/>";
    $pos = strpos($imagen, ".");
    $nombre = substr($imagen, 0, $pos);
    $nombre = strtoupper($nombre);
    $listado.="$nombre<br /><hr />";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?=$listado?>
</body>
</html>
