<?php
    /*
        * Ventana de Detalle
        * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
        * Última modificación: 01/12/2021
    */
    //Recuperar la sesión
    session_start();
    //Si no hay sesión
    if (!isset($_SESSION['usuario214LoginLogout'])) {
        header('Location: login.php'); //Regresar al login
    }
    //Inicialización del array de saludos en distinos idiomas
    $aIdiomas=[
            "Bienvenido/a", "Welcome", "Velkommen", "어서 오십시오"  
    ];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Detalle - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <h1>Desarrollo Web en Entorno Servidor</h1>
            <h2>Tema 5</h2>
            <?php echo $aIdiomas[$_COOKIE['idioma']]?>
            <a href="programa.php"><div class="cuadro" id="arriba">&#60;</div></a>
        </header>
        <main>   
            
            <h1>$_SESSION</h1>
            <pre>
            <?php
                print_r(!isset($_SESSION)?"Variable no inicializada":$_SESSION);
            ?>
            </pre>
            <h1>$_COOKIE</h1>
            <pre>
            <?php
                print_r($_COOKIE);
            ?>
            </pre>
            <h1>$_SERVER</h1>
            <pre>
            <?php
                print_r($_SERVER);
            ?>
            </pre>
            <h1>$_REQUEST</h1>
            <pre>
            <?php
                print_r($_REQUEST);
            ?>
            </pre>
            <h1>$_FILES</h1>
            <pre>
            <?php
                print_r($_FILES);
            ?>
            </pre>
            <h1>phpinfo()</h1>
            <div class="phpinfo">
                <?php
                    phpinfo();
                ?>
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
    </body>
</html>
