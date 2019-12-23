<?php
if ($_GET)
{
    $action = $_GET['action'];
    if (function_exists($action))
        call_user_func($action);
}

function login()
{
    require_once '../model/Usuario.php';
    $user = new Usuario();

    $usuario    = $_POST['txt_usuario'];
    $contracena = $_POST['txt_contracena'];

    $dato = $user->ingresar($usuario, $contracena);

    if(count($dato))
    {
        session_start();
        $_SESSION['usuario'] = $dato[0]['usuario'];
        echo json_encode(["msg"=>"bienvenido"]);
    }
    else
        echo json_encode(["msg"=>"El usuario o la contraceña son incorrectos."]);

    exit;
}

function registro()
{
    require_once '../model/Usuario.php';
    $user = new Usuario();

    $nombre     = $_POST['txt_nombre'];
    $usuario    = $_POST['txt_usuario'];
    $contracena = $_POST['txt_contracena'];

    $creado = $user->crearCuenta($nombre, $usuario, $contracena);
    $dato   = $user->ingresar($usuario, $contracena);

    if ($creado && count($dato))
    {
        session_start();
        $_SESSION['usuario'] = $dato[0]['usuario'];
        echo json_encode(["msg"=>"bienvenido"]);
    }
    else
        echo json_encode(["error"=>"El nombre de usuario está en uso."]);

    exit;
}