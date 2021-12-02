<?php
   
    setcookie('idioma',0, strtotime('+2 days') );
    
    /*$arrayPalabras=[
      "Hola", "Hello"  
    ];
    echo $arrayPalabras[$_COOKIE['Idioma']];*/
    
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>OLP-DWES - Ejercicio 3</title>
        <link href="webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <h1>Desarrollo Web en Entorno Servidor</h1>
            <h2>Tema 5</h2>
            
            <a href="../214DWESProyectoTema5/indexProyectoTema5.php"><div class="cuadro" id="arriba">&#60;</div></a>
            
        </header>
        <?php
        $arrayPalabras=[
            "Hola", "Hello", "Hallo"  
          ];
        echo $arrayPalabras[$_COOKIE['idioma']];?>
        <main>   
            <a href="codigoPHP/login.php"><div id="loginlogout">LoginLogout</div></a>
            
            <div class="idiomas">
                <form action="index.php">
                    <input id="spanish" type="radio" name="idioma" value="0">
                    <label for="spanish"><img src="webroot/img/spain.svg"></label>
                    <input id="english" type="radio" name="idioma" value="1">
                    <label for="english"><img src="webroot/img/uk.png"></label>
                    <input id="norwish" type="radio" name="idioma" value="2">
                    <label for="norwish"><img src="webroot/img/norway.png"></label>
                    <input type="submit" name="cambiarIdioma" value="Cambiar idioma">
                </form>
            </div>
        </main>
        <footer>
            <p>
                Óscar Llamas Parra &nbsp;
                <a href="https://github.com/OscarLlaPar/" target="__blank"><img src="webroot/img/github.png" alt="Github"></img></a>
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
