<?php

abstract class Model
{
    private static
        $server     = 'localhost',
        $user       = 'root',
        $password   = 'pass',
        $database   = 'db_actividades';


    protected function guardarDatos(string $pa, array  $datos):bool
    {
        $guarda = self::conectar()->query(
            self::generarConsulta($pa, $datos)
        );

        self::conectar()->close();
        return $guarda;
    }


    protected function obtenerDatos(string $pa, array  $datos):array
    {
        $resultado = [];
        $misDatos = self::conectar()->query( self::generarConsulta($pa, $datos) );

        if ($misDatos)
            foreach($misDatos as $fila)
                array_push($resultado, $fila);

        $misDatos->free();
        self::conectar()->close();

        return $resultado;
    }

    /* la funciones privadas */
    /* Conectar a la base de datos */
    private function conectar()
    {
        return new mysqli(
            self::$server,
            self::$user,
            self::$password,
            self::$database
        );
    }

    /* Generar la cadena de consulta */
    private function generarConsulta(string $nombreProcedimiento, array  $datos):string
    {
        $texto = "";

        for (
            $indice = 0;
            $indice < $total = count($datos);
            $indice++
        )
        {
            $indice < $total-1
                ? $texto = $texto."'".$datos[$indice]."',"
                : $texto = $texto."'".$datos[$indice]."'";
        }

        return "CALL $nombreProcedimiento($texto)";
    }
}