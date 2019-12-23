<?php
    session_start();
    if (!isset($_SESSION['usuario']))
        header("location: /");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['usuario']?> | registra</title>
</head>
<body>
    <header>
        <h1><u>Registrar actividades</u></h1>
    </header>
    
    <nav style="display:flex; justify-content: space-between">
        <a href="/view/inicio.php">Inicio</a>
        <a href="/view/registrar.php">Registrar</a>
        <a href="/salir.php">salir</a>
    </nav>
    <br>

    <main>
        <form id="frm_actividad" method="POST">
            <fieldset>
                <legend><h2>Registra tu actividad</h2></legend>
                <label>Descripción: </label><br>
                <input type="text" name="txt_actividad" style="width:100%" required>  <br><br>

                <button type="submit">Registrar actividad</button>
            </fieldset>
        </form>
        
        <p style="color: green" id="p_mensaje">...</p>
    </main>

    <footer>
        <hr>
        Derechos reservados &copy; 2019-2020
    </footer>

    <script>
        document.getElementById('frm_actividad').addEventListener('submit', event=>{
            event.preventDefault()

            const frmDatos = new FormData(document.getElementById('frm_actividad'))

            fetch('/ajax/usuario.php?action=registrarActividad', {
                method:'POST',
                body: frmDatos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta =>{
                document.getElementById('frm_actividad').reset();
                mostrarMensaje(respuesta.msg)
            })
            .catch(error => console.error(error))
        })

        function mostrarMensaje(mensaje)
        {
            document.getElementById('p_mensaje').innerText = mensaje
        }
    </script>
</body>
</html>