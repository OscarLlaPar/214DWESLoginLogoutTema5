<?php
    //Si no se ha creado cookie del idioma
    if(!isset($_COOKIE['idioma'])){
        setcookie('idioma', 0); //Cookie de idioma por defecto
        header("Location: indexLoginLogoutTema5.php"); //Recargar la página
        exit;
    }
    //Si se ha pulsado un botón de idioma
    if(isset($_REQUEST['idioma'])){
        setcookie('idioma', $_REQUEST['idioma']); //Asignación a la cookie del valor elegido
        header("Location: indexLoginLogoutTema5.php"); //Recargar la página
        exit;
    }
    //Si no se ha creado cookie del gato
    if(!isset($_COOKIE['gato'])){
        setcookie('gato', 0);   //Cookie del gato por defecto
        header("Location: indexLoginLogoutTema5.php");   //Recargar la página
        exit;
    }
    //Si se ha pulsado un botón de gato
    if(isset($_REQUEST['gato'])){
        setcookie('gato', $_REQUEST['gato']); //Asignación a la cookie del valor elegido
        header("Location: indexLoginLogoutTema5.php"); //Recargar la página
    }
    //Si se ha pulsado el botón para entrar
    if(isset($_REQUEST['entrar'])){
        header("Location: codigoPHP/login.php"); //Llevar al login
        exit;
    }
    //Array con los saludos en distintos idiomas
    $aIdiomas=[
        "Bienvenido/a", "Welcome", "Velkommen", "어서 오십시오"  
    ];
?>
<!DOCTYPE html>
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
            <?php echo $aIdiomas[$_COOKIE['idioma']]?>
            <a href="../214DWESProyectoTema5/indexProyectoTema5.php"><div class="cuadro" id="arriba">&#60;</div></a>
            
        </header>
        <main class="mainIndex">  
            
            <form action="<?php echo $_SERVER['PHP_SELF']?>">    
            <button type="submit" name="entrar"><div id="loginlogout">LoginLogout</div></button>
                <div class="idiomas">
                        <h4>Idioma de bienvenida:</h4>
                        <button type="submit" name="idioma" value="0" <?php echo ($_COOKIE['idioma']==0)?"class=\"activado\"":"" ?>><img src="webroot/img/spain.svg"></button>
                        <button type="submit" name="idioma" value="1" <?php echo ($_COOKIE['idioma']==1)?"class=\"activado\"":"" ?>><img src="webroot/img/uk.png"></button>
                        <button type="submit" name="idioma" value="2" <?php echo ($_COOKIE['idioma']==2)?"class=\"activado\"":"" ?>><img src="webroot/img/norway.png"></button>
                        <button type="submit" name="idioma" value="3" <?php echo ($_COOKIE['idioma']==3)?"class=\"activado\"":"" ?>><img src="webroot/img/korea.png"></button>
                </div>
                <h4>¿Qué gato prefieres?</h4>
                <table class="gatos">
                    <tr>
                        <td>
                            <button type="submit" name="gato" value="0" <?php echo ($_COOKIE['gato']==0)?"class=\"activado\"":"" ?>>DD</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="1" <?php echo ($_COOKIE['gato']==1)?"class=\"activado\"":"" ?>>TT</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="2" <?php echo ($_COOKIE['gato']==2)?"class=\"activado\"":"" ?>>CoCo</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="3" <?php echo ($_COOKIE['gato']==3)?"class=\"activado\"":"" ?>>MoMo</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="4" <?php echo ($_COOKIE['gato']==4)?"class=\"activado\"":"" ?>>ChuChu</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" name="gato" value="5" <?php echo ($_COOKIE['gato']==5)?"class=\"activado\"":"" ?>>LaLa</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="6" <?php echo ($_COOKIE['gato']==6)?"class=\"activado\"":"" ?>>LuLu</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="7" <?php echo ($_COOKIE['gato']==7)?"class=\"activado\"":"" ?>>NaNa</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="8" <?php echo ($_COOKIE['gato']==8)?"class=\"activado\"":"" ?>>ToTo</button>
                        </td>
                        <td>
                            <button type="submit" name="gato" value="9" <?php echo ($_COOKIE['gato']==9)?"class=\"activado\"":"" ?>>DoDo</button>
                        </td>
                    </tr>
                </table>
            </form>
        </main>
        <footer>
            <p>
                <a href="http://daw214.ieslossauces.es/">Óscar Llamas Parra </a>&nbsp;
                <a href="https://github.com/OscarLlaPar/214DWESLoginLogoutTema5" target="__blank"><img src="webroot/img/github.png" alt="Github"></img></a>
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
