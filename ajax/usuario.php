<?php
if ($_GET)
{
    session_start();
    if (!isset($_SESSION['usuario']))
    {
        echo json_encode(["msg"=>"No tienes acceso."]);
    }
    else
    {
        $action = $_GET['action'];
        if (function_exists($action))
            call_user_func($action);
        else
            echo json_encode(["msg"=>"Error: No entiendo tu peticion."]);
    }
}

function registrarActividad()
{
    require_once '../model/Usuario.php';
    $user = new Usuario();

    $usuario    = $_SESSION['usuario'];
    $actividad  = $_POST['txt_actividad'];

    if ($user->registrarActividad($usuario, $actividad))
        echo json_encode(["msg"=>"Registrado: $actividad"]);
    else
        echo json_encode(["msg"=>"[-|-|Error: No hay sistema|-|-]"]);

    exit;
}

function listarActividadesNoHechas()
{
    require_once '../model/Usuario.php';
    $user = new Usuario();

    $usuario    = $_SESSION['usuario'];

    echo json_encode(
        $user->listarActividadesNoRealizadas($usuario)
    );
    
    exit;
}

function listarActividadesHechas()
{
    require_once '../model/Usuario.php';
    $user = new Usuario();

    $usuario    = $_SESSION['usuario'];

    echo json_encode(
        $user->listarActividadesRealizadas($usuario)
    );
    
    exit;
}

function eliminarActividad()
{
    require_once '../model/Usuario.php';
    $user = new Usuario();

    $usuario        = $_SESSION['usuario'];
    $actividad_id   = $_POST['codigo'];

    if ($user->eliminarUnaActividad($usuario, intval($actividad_id)))
        echo json_encode(["msg"=>"Actividad eliminada correctamente."]);
    else
        echo json_encode(["msg"=>"[-|-|Error: No hay sistema|-|-]"]);
    
    exit;
}

function actividadRealizada()
{
    require_once '../model/Usuario.php';
    $user = new Usuario();

    $usuario        = $_SESSION['usuario'];
    $actividad_id   = $_POST['codigo'];

    if ($user->realizarUnaActividad($usuario, intval($actividad_id)))
        echo json_encode(["msg"=>"Actividad realizada."]);
    else
        echo json_encode(["msg"=>"[-|-|Error: No hay sistema|-|-]"]);

    exit;
}