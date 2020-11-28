<?php
require "class/Directorio.php";
//Inicializamos varialbes
$idiomas = new Directorio();

$idioma = filter_input(INPUT_GET, "idioma", FILTER_SANITIZE_STRING);

$imagenes = $idiomas->get_ficheros("./idiomas",$idioma);
if ($imagenes ===false) {
    header("Location:index.php?msj=No se ha podido leer imágenes de $idioma");
    exit();
}


$listado="";
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
    <link rel="stylesheet" href="estilo/estilo.css">
    <title>Listado de imágenes</title>
</head>
<body>
<fieldset>
    <form action="index.php">
        <input type="submit" value="Volver al index">
    </form>
    
</fieldset>
<fieldset>
<h1>Listado de imágenes de <?=$idioma?></h1>
<?=$listado?>
</fieldset>

</body>
</html>
