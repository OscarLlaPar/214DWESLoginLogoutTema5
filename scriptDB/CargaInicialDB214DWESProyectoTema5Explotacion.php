<?php
include '../config/confDB.php';
try{ //Dentro va el código susceptible de dar error
    //Establecimiento de la conexión 
    $miDB = new PDO(HOST, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $consulta = $miDB->prepare(<<<QUERY
            insert into T01_Usuario values
            ('admin', SHA2('adminpaso',256), 'Usuario administrador', null, 0, 'administrador', null),
            ('albertoF',SHA2('albertoFpaso',256),'AlbertoF', null, 0, 'usuario', null),
            ('outmane',SHA2('outmanepaso',256),'Outmane', null, 0, 'usuario', null),
            ('rodrigo',SHA2('rodrigopaso',256),'Rodrigo', null, 0, 'usuario', null),
            ('isabel',SHA2('isabelpaso',256),'Isabel', null, 0, 'usuario', null),
            ('david',SHA2('davidpaso',256),'David', null, 0, 'usuario', null),
            ('aroa',SHA2('aroapaso',256),'Aroa', null, 0, 'usuario', null),
            ('johanna',SHA2('johannapaso',256),'Johanna', null, 0, 'usuario', null),
            ('oscar',SHA2('oscarpaso',256),'Oscar', null, 0, 'usuario', null),
            ('sonia',SHA2('soniapaso',256),'Sonia', null, 0, 'usuario', null),
            ('heraclio',SHA2('heracliopaso',256),'Heraclio', null, 0, 'usuario', null),
            ('amor',SHA2('amorpaso',256),'Amor', null, 0, 'usuario', null),
            ('antonio',SHA2('antoniopaso',256),'Antonio', null, 0, 'usuario', null),
            ('albertoB',SHA2('albertoBpaso',256),'AlbertoB', null, 0, 'usuario', null);
        QUERY);
    $consulta->execute();
}
catch(PDOException $miExceptionPDO){ //Lo que se muestra en caso de error
    echo "Error: ".$miExceptionPDO->getMessage(); //Mensaje de error
    echo "<br>";
    echo "Código de error: ".$miExceptionPDO->getCode(); //Código de error
}
finally{ //Ocurre tanto si da error como si no lo da
 //Cerrar la conexión
 unset($miDB);
            }
try{ //Dentro va el código susceptible de dar error
    //Establecimiento de la conexión 
    $miDB = new PDO(HOST, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $consulta = $miDB->prepare(<<<QUERY
            insert into T02_Departamento values
            ("UNO", "Primer departamento", curdate(), 30.45, null),
            ("DOS", "Segundo departamento", curdate(), 66.66, null),
            ("TRE", "Tercer departamento", curdate(), 1.11, null);
        QUERY);
    $consulta->execute();
}
catch(PDOException $miExceptionPDO){ //Lo que se muestra en caso de error
    echo "Error: ".$miExceptionPDO->getMessage(); //Mensaje de error
    echo "<br>";
    echo "Código de error: ".$miExceptionPDO->getCode(); //Código de error
}
finally{ //Ocurre tanto si da error como si no lo da
 //Cerrar la conexión
 unset($miDB);
}


