create database if not exists DB214DWESProyectoTema5;



/*SET GLOBAL validate_password.length = 2;
SET GLOBAL validate_password.number_count = 0;
SET GLOBAL validate_password.policy=LOW;*/

create user 'user214DWESProyectoTema5'@'%' identified by 'paso';
grant all privileges on DB214DWESProyectoTema5.* to 'user214DWESProyectoTema5'@'%';
flush privileges;

use DB214DWESProyectoTema5;

create table if not exists T01_Usuario(
    T01_CodUsuario varchar(8) primary key,
    T01_Password varchar(64) not null,
    T01_DescUsuario varchar(255) not null,
    T01_FechaHoraUltimaConexion int default null,
    T01_NumConexiones int unsigned default 0,
    T01_Perfil enum('usuario','administrador') default 'usuario',
    T01_ImagenUsuario mediumblob default null
)engine=InnoDB;

create table if not exists T02_Departamento(
    T02_CodDepartamento varchar(3) primary key not null,
    T02_DescDepartamento varchar(255) not null,
    T02_FechaCreacionDepartamento date not null,
    T02_VolumenDeNegocio decimal(6,2) not null,
    T02_FechaBajaDepartamento date
)engine=InnoDB;