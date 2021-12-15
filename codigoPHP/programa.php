<?php
/*
    * Ventana de Programa
    * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
    * Última modificación: 01/12/2021
*/
//Recuperación de la sesión
session_start();
//Inicialización del array de saludos en distinos idiomas
$aIdiomas=[
  "Bienvenido/a", "Welcome", "Velkommen", "어서 오십시오"  
];
//Array con imagenes y mensajes de los distintos gatos
$aGatos=[
    'imagen' => [
        "../webroot/img/dd.jpg",
        "../webroot/img/tt.jpg",
        "../webroot/img/coco.jpg",
        "../webroot/img/momo.jpg",
        "../webroot/img/chuchu.jpg",
        "../webroot/img/lala.png",
        "../webroot/img/lulu.png",
        "../webroot/img/nana.jpg",
        "../webroot/img/toto.jpg",
        "../webroot/img/dodo.jpg",
    ],
    'mensaje' => [
        "DD dice: \"DD es lindo. DD quiere pan.\"",
        "TT dice: \"Yo soy la reina\"",
        "CoCo dice: \"Hmm... Interesante uso de las cookies...\"",
        "MoMo dice: \"En mi juventud yo tambien hice muchos LoginLogout.\"",
        "ChuChu dice: \"¿Chu? Chu...\"",
        "LaLa dice: \"¡¡Myah, myah!!\"",
        "LuLu dice: \"Perdone, soy LuLu, ¿puedo comer una cookie?\"",
        "NaNa dice: \"¡¡Yo solo quiero amor!!\"",
        "Toto dice: *beep-beep*",
        "DoDo dice: \"¿LoginLogout? ¿Eso es comida?\"",
    ]
];
//Si no hay sesión
if (!isset($_SESSION['usuario214LoginLogout'])) {
    header('Location: login.php'); //Regreso al login
}
//Si se ha pulsado el boton de cerrar sesión
if (isset($_REQUEST['logout'])) {
    session_destroy(); //Eliminar la sesión
    header('Location: login.php'); //Volver al login
}
//Incluir configuración de la base de datos
include "../config/confDB.php";
//Creación de un objeto DateTime para ser usado posteriormente
$oFecha=new DateTime();
try{
    //Conexión con la base de datos
    $miDB = new PDO(HOST, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Creación de la consulta
    $consulta=<<<QUERY
            SELECT T01_NumConexiones, T01_DescUsuario, T01_ImagenUsuario FROM T01_Usuario
            WHERE T01_CodUsuario ='{$_SESSION['usuario214LoginLogout']}'
            QUERY;
    //Preparación de la consulta        
    $resultadoConsulta = $miDB->prepare($consulta);
    //Ejecución de la consulta
    $resultadoConsulta->execute();
    $oRegistro = $resultadoConsulta->fetchObject();
    //Si ha habido un resultado, almacenar los datos en variables
    if($oRegistro){
        $numConexiones=$oRegistro->T01_NumConexiones;
        $usuarioCompleto=$oRegistro->T01_DescUsuario;
    }
}    
//Gestión de errores relacionados con la base de datos
catch(PDOException $miExceptionPDO){
    echo "Error: ".$miExceptionPDO->getMessage();
    echo "<br>";
    echo "Código de error: ".$miExceptionPDO->getCode();
}
finally{
 //Cerrar la conexión
 unset($miDB);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Programa - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <h1>LoginLogout</h1>
            <h2>Tema 5</h2>
            <form id="logout" name="logout" action="programa.php">
                <input type="submit" class="boton" name="logout" value="Cerrar sesión" type="button"/>
            </form>
        </header>
        <main class="mainPrograma">   
            
            <div class="info">
                <p> <?php echo $aIdiomas[$_COOKIE['idioma']].", ".$usuarioCompleto;?>!</p>
                <p><?php echo ($numConexiones==1)?"Es la primera vez que te conectas!": "Te has conectado {$numConexiones} veces en total";?> </p>
                <p><?php  echo ($numConexiones==1)?"":"Última conexión:".$oFecha->setTimestamp($_SESSION['conexionAnterior'])->format("d-m-Y h:i:s")?></p>
                <a href="editarPerfil.php"><div class="boton">Editar perfil</div></a>
                <a href="detalle.php"><div class="boton">Detalle</div></a>
                <div class="perfil">
                    <?php
                    if($oRegistro->T01_ImagenUsuario){
                    ?>
                        <img class="fotoPerfil" src="data:image/gif;base64, <?php echo $oRegistro->T01_ImagenUsuario ?>" alt="Foto de perfil">
                    <?php
                    }
                    else{
                    ?>
                        <img class="fotoPerfil" src="../webroot/img/perfil.png" alt="Foto de perfil">
                    <?php
                    }
                    ?>
                    
                    <p><?php echo $oRegistro->T01_DescUsuario;?></p>
                </div>
            </div>
            
            
           <div class="gato">
                <?php echo "<img src=\"".$aGatos['imagen'][$_COOKIE['gato']]."\"";?>
                <p><?php echo $aGatos['mensaje'][$_COOKIE['gato']]?></p>
            </div>
            
        </main>
        <footer>
            <p>
                <a href="http://daw214.ieslossauces.es/">Óscar Llamas Parra </a>&nbsp;
                <a href="https://github.com/OscarLlaPar/214DWESLoginLogoutTema5" target="__blank"><img src="../webroot/img/github.png" alt="Github"></img></a>
            </p>
            <p>
                DAW 2
            </p>
            <p>
                IES Los Sauces, Benavente 2021-2022
            </p>
            <div class="cuadro" id="abajo"></div>
        </footer>
    </body>
</html>
