<?php
include '../config/confDB.php';
try{ //Dentro va el código susceptible de dar error
    //Establecimiento de la conexión 
    $miDB = new PDO(HOST, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $consulta = $miDB->prepare(<<<QUERY
            create table if not exists T01_Usuario(
                T01_CodUsuario varchar(8) primary key,
                T01_Password varchar(64) not null,
                T01_DescUsuario varchar(255) not null,
                T01_FechaHoraUltimaConexion int default null,
                T01_NumConexiones int unsigned default 0,
                T01_Perfil enum('usuario','administrador') default 'usuario',
                T01_ImagenUsuario mediumblob default null
            )engine=InnoDB;
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
            create table if not exists T02_Departamento(
                T02_CodDepartamento varchar(3) primary key not null,
                T02_DescDepartamento varchar(255) not null,
                T02_FechaCreacionDepartamento date not null,
                T02_VolumenDeNegocio decimal(6,2) not null,
                T02_FechaBajaDepartamento date
            )engine=InnoDB;
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


