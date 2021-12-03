<?php
   
     
    if(isset($_REQUEST['idioma'])){
        setcookie("idioma", $_REQUEST['idioma'], strtotime('+5 days')); 
    }
    if(isset($_REQUEST['gato'])){
        setcookie("gato", $_REQUEST['gato'], strtotime('+5 days')); 
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
        <main>   
            <a href="codigoPHP/login.php"><div id="loginlogout">LoginLogout</div></a>
            
            <div class="idiomas">
                <form action="index.php">
                    <h4>Idioma de bienvenida:</h4>
                    <button type="submit" name="idioma" value="0" <?php echo ($_REQUEST['idioma']=="0")?"class=\"activado\"":""?>><img src="webroot/img/spain.svg"></button>
                    <button type="submit" name="idioma" value="1" <?php echo ($_REQUEST['idioma']=="1")?"class=\"activado\"":""?>><img src="webroot/img/uk.png"></button>
                    <button type="submit" name="idioma" value="2" <?php echo ($_REQUEST['idioma']=="2")?"class=\"activado\"":""?>><img src="webroot/img/norway.png"></button>
                    <button type="submit" name="idioma" value="3" <?php echo ($_REQUEST['idioma']=="3")?"class=\"activado\"":""?>><img src="webroot/img/korea.png"></button>
                </form>
            </div>
            <form action="index.php">
                <h4>¿Qué gato prefieres?</h4>
                <table>
                    <tr>
                        <td><button type="submit" name="gato" value="0" <?php echo ($_REQUEST['gato']=="0")?"class=\"activado\"":""?>>DD</button></td>
                        <td><button type="submit" name="gato" value="1" <?php echo ($_REQUEST['gato']=="1")?"class=\"activado\"":""?>>TT</button></td>
                        <td><button type="submit" name="gato" value="2" <?php echo ($_REQUEST['gato']=="2")?"class=\"activado\"":""?>>CoCo</button></td>
                        <td><button type="submit" name="gato" value="3" <?php echo ($_REQUEST['gato']=="3")?"class=\"activado\"":""?>>MoMo</button></td>
                        <td><button type="submit" name="gato" value="4" <?php echo ($_REQUEST['gato']=="4")?"class=\"activado\"":""?>>ChuChu</button></td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="gato" value="5" <?php echo ($_REQUEST['gato']=="5")?"class=\"activado\"":""?>>LaLa</button></td>
                        <td><button type="submit" name="gato" value="6" <?php echo ($_REQUEST['gato']=="6")?"class=\"activado\"":""?>>LuLu</button></td>
                        <td><button type="submit" name="gato" value="7" <?php echo ($_REQUEST['gato']=="7")?"class=\"activado\"":""?>>NaNa</button></td>
                        <td><button type="submit" name="gato" value="8" <?php echo ($_REQUEST['gato']=="8")?"class=\"activado\"":""?>>ToTo</button></td>
                        <td><button type="submit" name="gato" value="9" <?php echo ($_REQUEST['gato']=="9")?"class=\"activado\"":""?>>DoDo</button></td>
                    </tr>
                </table>
            </form>
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
