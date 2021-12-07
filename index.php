<?php
    if(isset($_REQUEST['entrar'])){
        setcookie('idioma', $_REQUEST['idioma']);
        setcookie('gato', $_REQUEST['gato']);
        header("Location: codigoPHP/login.php");
    }
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
        <main class="mainIndex">  
            <form action="index.php">    
            <button type="submit" name="entrar"><div id="loginlogout">LoginLogout</div></button>
                <div class="idiomas">
                        <h4>Idioma de bienvenida:</h4>
                        <input id="spanish" type="radio" name="idioma" value="0" checked>
                        <label for="spanish"><img src="webroot/img/spain.svg"></label>
                        <input id="english" type="radio" name="idioma" value="1">
                        <label for="english"><img src="webroot/img/uk.png"></label>
                        <input id="norwegian" type="radio" name="idioma" value="2">
                        <label for="norwegian"><img src="webroot/img/norway.png"></label>
                        <input id="korean" type="radio" name="idioma" value="3" >
                        <label for="korean"><img src="webroot/img/korea.png"></label>
                </div>
                <h4>¿Qué gato prefieres?</h4>
                <table class="gatos">
                    <tr>
                        <td>
                            <input id="dd" type="radio" name="gato" value="0" checked>
                            <label for="dd" class="boton">DD</label>
                        </td>
                        <td>
                            <input id="tt" type="radio" name="gato" value="1">
                            <label for="tt" class="boton">TT</label>
                        </td>
                        <td>
                            <input id="coco" type="radio" name="gato" value="2">
                            <label for="coco" class="boton">CoCo</label>
                        </td>
                        <td>
                            <input id="momo" type="radio" name="gato" value="3">
                            <label for="momo" class="boton">MoMo</label>
                        </td>
                        <td>
                            <input id="chuchu" type="radio" name="gato" value="4">
                            <label for="chuchu" class="boton">ChuChu</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input id="lala" type="radio" name="gato" value="5">
                            <label for="lala" class="boton">LaLa</label>
                        </td>
                        <td>
                            <input id="lulu" type="radio" name="gato" value="6">
                            <label for="lulu" class="boton">LuLu</label>
                        </td>
                        <td>
                            <input id="nana" type="radio" name="gato" value="7">
                            <label for="nana" class="boton">NaNa</label>
                        </td>
                        <td>
                            <input id="toto" type="radio" name="gato" value="8">
                            <label for="toto" class="boton">ToTo</label>
                        </td>
                        <td>
                            <input id="dodo" type="radio" name="gato" value="9">
                            <label for="dodo" class="boton">DoDo</label>
                        </td>
                    </tr>
                </table>
            </form>
        </main>
        <footer>
            <p>
                <a href="http://daw214.ieslossauces.es/">Óscar Llamas Parra </a>&nbsp;
                <a href="https://github.com/OscarLlaPar/" target="__blank"><img src="webroot/img/github.png" alt="Github"></img></a>
            </p>
            <p>
                DAW 2
            </p>
            <p>
                IES Los Sauces, Benavente 2021-2022
            </p>
            <p>
                Versión 1.2
            </p>
            <div class="cuadro" id="abajo"></div>
        </footer>
    </body>
</html>
