-- stored procedures | procedimientos almacenado

-- 1.- usuario | crear una cuenta nueva
DROP PROCEDURE IF EXISTS sp_crear_cuenta;
DELIMITER $$
CREATE PROCEDURE sp_crear_cuenta(
    IN _nombre      VARCHAR(30),
    IN _usuario     VARCHAR(12),
    IN _contracena  VARCHAR(20)
)
BEGIN
    INSERT INTO USUARIOS(
        nombre,
        usuario,
        contracena
    )
    VALUES(
        _nombre,
        _usuario,
        _contracena
    );
END $$
DELIMITER ;

-- 2.- internamente | obtener usuario existente
DROP PROCEDURE IF EXISTS sp_obtener_usuario;
DELIMITER $$
CREATE PROCEDURE sp_obtener_usuario(
    IN _usuario     VARCHAR(12)
)
BEGIN
    SELECT  usuario
    FROM    USUARIOS
    WHERE   usuario LIKE _usuario;
END $$
DELIMITER ;

-- 3.- usuario | login
DROP PROCEDURE IF EXISTS sp_ingresar;
DELIMITER $$
CREATE PROCEDURE sp_ingresar(
    IN _usuario     VARCHAR(12),
    IN _contracena  VARCHAR(20)
)
BEGIN
    SELECT  usuario
    FROM    USUARIOS
    WHERE   usuario LIKE _usuario AND contracena LIKE _contracena;
END $$
DELIMITER ;

-- 4.- Registrtar actividad
DROP PROCEDURE IF EXISTS sp_registrar_actividad;
DELIMITER $$
CREATE PROCEDURE sp_registrar_actividad(
    IN _usuario  VARCHAR(12),
    IN _descripcion VARCHAR(40)
)
BEGIN
    START TRANSACTION;
        SET @usuario_id = (
            SELECT  usuario_id
            FROM    USUARIOS
            WHERE   usuario LIKE _usuario
        );

        INSERT INTO ACTIVIDADES(usuario_id, descripcion)
        VALUES(@usuario_id, _descripcion);
    COMMIT;
END $$
DELIMITER ;

-- 5.- Listar Todas las actividades que no esten realizadas
DROP PROCEDURE IF EXISTS sp_listar_actividades_no_realizadas;
DELIMITER $$
CREATE PROCEDURE sp_listar_actividades_no_realizadas(
    IN _usuario VARCHAR(12)
)
BEGIN
    START TRANSACTION;
        SET @usuario_id = (
            SELECT  usuario_id
            FROM    USUARIOS
            WHERE   usuario LIKE _usuario
        );

        SELECT  actividad_id AS 'id', descripcion, fecha
        FROM    ACTIVIDADES
        WHERE   usuario_id LIKE @usuario_id AND realizado LIKE FALSE
        ORDER BY fecha DESC;
    COMMIT;
END $$
DELIMITER ;

-- 6.- Listar Todas las actividades realizadas
DROP PROCEDURE IF EXISTS sp_listar_actividades_realizadas;
DELIMITER $$
CREATE PROCEDURE sp_listar_actividades_realizadas(
    IN _usuario VARCHAR(12)
)
BEGIN
    START TRANSACTION;
        SET @usuario_id = (
            SELECT  usuario_id
            FROM    USUARIOS
            WHERE   usuario LIKE _usuario
        );

        SELECT  actividad_id AS 'id', descripcion, fecha
        FROM    ACTIVIDADES
        WHERE   usuario_id LIKE @usuario_id AND realizado LIKE TRUE
        ORDER BY fecha DESC;
    COMMIT;
END $$
DELIMITER ;


-- 7.- Eliminar una actividad del usuario un usuario puede eliminar solo sus tareas
DROP PROCEDURE IF EXISTS sp_eliminar_actividad;
DELIMITER $$
CREATE PROCEDURE sp_eliminar_actividad(
    IN _usuario         VARCHAR(12),
    IN _actividad_id    INT UNSIGNED
)
BEGIN
    START TRANSACTION;
        SET @usuario_id = (
            SELECT  usuario_id
            FROM    USUARIOS
            WHERE   usuario LIKE _usuario
        );

        DELETE FROM ACTIVIDADES
        WHERE actividad_id LIKE _actividad_id AND usuario_id LIKE @usuario_id;
    COMMIT;
END $$
DELIMITER ;

-- 8.- Actualizar una actividad a realizada
DROP PROCEDURE IF EXISTS sp_realizar_actividad;
DELIMITER $$
CREATE PROCEDURE sp_realizar_actividad(
    IN _usuario         VARCHAR(12),
    IN _actividad_id    INT UNSIGNED
)
BEGIN
    START TRANSACTION;
        SET @usuario_id = (
            SELECT  usuario_id
            FROM    USUARIOS
            WHERE   usuario LIKE _usuario
        );

        UPDATE  ACTIVIDADES
        SET     realizado = TRUE
        WHERE   actividad_id LIKE _actividad_id AND usuario_id LIKE @usuario_id;
    COMMIT;
END $$
DELIMITER ;


