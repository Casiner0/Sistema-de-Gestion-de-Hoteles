CREATE SCHEMA IF NOT EXISTS hotel;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS hotel.usuario (
 id_usuario  int auto_increment primary key,
  usuario     varchar(100) not null,
  contrasenna varchar(100) not null
) ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO hotel.usuario (`usuario`, `contrasenna`) VALUES
('usuario', '0cc175b9c0f1b6a831c399e269772661'); -- la clave es a

-- --------------------------------------------------------
-- NOMENCLADORES
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE IF NOT EXISTS hotel.sexo (
id_sexo int not null primary key,
  descripcion varchar(100) not null
) ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO hotel.sexo (`id_sexo`, `descripcion`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE IF NOT EXISTS hotel.nacionalidad (
  id_nacionalidad int auto_increment primary key,
  descripcion varchar(100) not null
) ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO hotel.nacionalidad (`descripcion`) VALUES
('CANADA'),
('ESTADOS UNIDOS'),
('MEXICO'),
('CUBA'),
('URUGUAY'),
('PANAMA'),
('HONDURAS'),
('ARGENTINA'),
('CHILE'),
('PERU'),
('DOMINICANA'),
('HAITI'),
('JAMAICA'),
('PUERTO RICO'),
('BOLIVIA'),
('ECUADOR'),
('VENEZUELA'),
('BRASIL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turoperador`
--


create table IF NOT EXISTS hotel.turoperador
(
  nacionalidad   int         not null,
  nombre         varchar(50) not null,
  codigo         varchar(50) not null,
  id_turoperador int auto_increment primary key,
  constraint turoperador_nacionalidad_fk
  foreign key (nacionalidad) references hotel.nacionalidad (id_nacionalidad)
)ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `turoperador`
--

INSERT INTO hotel.turoperador (`nombre`,`codigo`,`nacionalidad`) VALUES
('CUBATUR','CUBT',4),
('HABANATUR','HABT',4),
('GAVIOTATUR','GAVT',4),
('VELATUR','VELT',4),
('VARATUR','VART',4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

create table IF NOT EXISTS hotel.habitacion
(
  numero  int auto_increment PRIMARY KEY
) ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `habitacion`
-- OJO: No se especifica ningun valor pues las habitaciones deben
-- ser siempre libres por defecto y el numero es generado solo.

INSERT INTO hotel.habitacion () VALUES
(),(),(),(),(),(),(),(),(),(),
(),(),(),(),(),(),(),(),(),(),
(),(),(),(),(),(),(),(),(),(),
(),(),(),(),(),(),(),(),(),(),
(),(),(),(),(),(),(),(),(),();

-- --------------------------------------------------------
-- FIN DE NOMENCLADORES
-- --------------------------------------------------------
-- TABLAS DEL NEGOCIO
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

create table IF NOT EXISTS hotel.cliente
(
  nombre       varchar(50)            not null,
  edad         int                    not null,
  sexo         int           not null,
  nacionalidad int(11)            not null,
  reiterado    tinyint(1) default '0' not null,
  id_cliente   int auto_increment PRIMARY KEY,
  constraint cliente_nacionalidad_id_nacionalidad_fk
  foreign key (nacionalidad) references hotel.nacionalidad (id_nacionalidad),
  constraint cliente_sexo_id_sexo_fk
  foreign key (sexo) references hotel.sexo (id_sexo)
) ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO hotel.cliente (`nombre`,`edad`,`sexo`,`nacionalidad`) VALUES
('Pedro Glez Perez',30,1,1),
('Juana Glez Perez',35,2,2),
('Dina Veraldini Rutia',25,2,3),
('Daniel Perez Paret',42,1,4),
('Juan Ponze Piedra',34,1,5),
('Ana Aldini Drith',24,2,6),
('Dagne Nedre Mercha',28,2,9),
('Perla Nazaret Pimienta',24,2,8),
('Lauren French Ashle',27,2,6),
('Jose Uriart Arti',24,1,7);



-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `reservacion`
--


create table if not exists hotel.reservacion
(
  id_reservacion int auto_increment
    primary key,
  codigo         varchar(50)                        not null,
  cliente        int                                not null,
  turoperador    int                                null,
  habitacion     int                                not null,
  fecha_entrada  datetime default CURRENT_TIMESTAMP null,
  cantidad_dias  int default '1'                    not null,
  pertenece_tur  tinyint(1) default '0'             not null,
  constraint reservacion_codigo_uindex
  unique (codigo),
  constraint Refcliente
  foreign key (cliente) references hotel.cliente (id_cliente),
  constraint Refhabitacion
  foreign key (habitacion) references hotel.habitacion (numero),
  constraint Refturoperador
  foreign key (turoperador) references hotel.turoperador (id_turoperador)
  ) ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `reservacion`
--

INSERT INTO hotel.reservacion (codigo,fecha_entrada,cantidad_dias,habitacion,cliente,turoperador,pertenece_tur) VALUES
('000000000000001','2020-11-23 09:00:00','5','1','1','1','1'),
('000000000000011','2020-06-13 09:00:00','5','28','1','1','0'),
('000000000000021','2020-06-03 09:00:00','5','38','1',null,'0'),
('000000000000002','2020-10-22 09:00:00','5','2','2','4','1'),
('000000000000012','2020-09-12 09:00:00','5','29','2','3','0'),
('000000000000022','2020-09-02 09:00:00','5','39','2',null,'0'),
('000000000000003','2020-09-21 09:00:00','5','20','3','1','1'),
('000000000000013','2020-04-11 09:00:00','5','30','3','2','0'),
('000000000000023','2020-05-01 09:00:00','5','40','3',null,'0'),
('000000000000004','2020-08-20 09:00:00','5','21','4','1','0'),
('000000000000014','2020-07-10 09:00:00','5','31','4',null,'0'),
('000000000000005','2020-07-19 09:00:00','5','22','5','4','1'),
('000000000000015','2020-05-09 09:00:00','5','32','5',null,'0'),
('000000000000006','2020-05-18 09:00:00','5','23','6',null,'0'),
('000000000000016','2020-08-08 09:00:00','5','33','6',null,'0'),
('000000000000007','2020-04-17 09:00:00','5','24','7','3','1'),
('000000000000017','2020-12-07 09:00:00','5','34','7',null,'0'),
('000000000000008','2020-03-16 09:00:00','5','25','8','1','0'),
('000000000000018','2020-02-06 09:00:00','5','35','8',null,'0'),
('000000000000009','2020-02-15 09:00:00','5','26','9','2','1'),
('000000000000019','2020-11-05 09:00:00','5','36','9',null,'0'),
('000000000000010','2020-01-14 09:00:00','5','27','10','3','1'),
('000000000000020','2020-10-04 09:00:00','5','37','10',null,'0');
-- --------------------------------------------------------
-- FIN TABLAS DEL NEGOCIO
-- --------------------------------------------------------








