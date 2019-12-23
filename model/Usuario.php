<?php
require_once 'Model.php';

class Usuario extends Model
{
    public function crearCuenta(string $nombre, string $usuario, string $contracena):bool
    {
        return count( Model::obtenerDatos('sp_obtener_usuario', [$usuario]) )
            ? false
            : Model::guardarDatos(
                'sp_crear_cuenta',
                [$nombre, $usuario, $contracena]
            );
    }

    public function ingresar(string $usuario, $contracena):array
    {
        return Model::obtenerDatos(
            'sp_ingresar',
            [$usuario, $contracena]
        );
    }

    public function registrarActividad(string $usuario, $actividad):bool
    {
        return Model::guardarDatos(
            'sp_registrar_actividad',
            [$usuario, $actividad]
        );
    }

    public function listarActividadesNoRealizadas(string $usuario):array
    {
        return Model::obtenerDatos(
            'sp_listar_actividades_no_realizadas',
            [$usuario]
        );
    }

    public function listarActividadesRealizadas(string $usuario):array
    {
        return Model::obtenerDatos(
            'sp_listar_actividades_realizadas',
            [$usuario]
        );
    }

    public function eliminarUnaActividad(string $usuario, int $actividad_id):bool
    {
        return Model::guardarDatos(
            'sp_eliminar_actividad',
            [$usuario, $actividad_id]
        );
    }

    public function realizarUnaActividad(string $usuario, int $actividad_id):bool
    {
        return Model::guardarDatos(
            'sp_realizar_actividad',
            [$usuario, $actividad_id]
        );
    }
}