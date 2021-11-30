<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
            
            <a href="programa.php"><div class="cuadro" id="arriba">&#60;</div></a>
        </header>
        <main>   
            <h1>$_SERVER</h1>
            <pre>
            <?php
                print_r($_SERVER);
            ?>
            </pre>
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
                Óscar Llamas Parra &nbsp;
                <a href="https://github.com/OscarLlaPar/" target="__blank"><img src="../webroot/img/github.png" alt="Github"></img></a>
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
