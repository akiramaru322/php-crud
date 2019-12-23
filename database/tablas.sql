
DROP DATABASE IF EXISTS db_actividades;
CREATE DATABASE db_actividades;
USE db_actividades;

CREATE TABLE USUARIOS(
    `usuario_id`    INT UNSIGNED AUTO_INCREMENT,
    `nombre`        VARCHAR(30) NOT NULL,
    `usuario`       VARCHAR(12) UNIQUE NOT NULL,
    `contracena`    VARCHAR(20) NOT NULL,
    PRIMARY KEY(`usuario_id`)
);

CREATE TABLE ACTIVIDADES(
    `actividad_id`  INT UNSIGNED AUTO_INCREMENT,
    `usuario_id`    INT UNSIGNED NOT NULL,
    `descripcion`   VARCHAR(40) NOT NULL,
    `realizado`     BOOLEAN DEFAULT FALSE,
    `fecha`         DATETIME  DEFAULT NOW(),
    FOREIGN KEY(`usuario_id`) REFERENCES USUARIOS(`usuario_id`),
    PRIMARY KEY(`actividad_id`)
);

