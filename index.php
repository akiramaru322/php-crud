<?php
    session_start();
    if (isset($_SESSION['usuario']))
        header("location: /view/inicio.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>'Fira Code'</title>
</head>
<body>
    <header>
        <h1><u>Actividades</u></h1>
    </header>
    
    <main>
        <form id="frm_login" method="POST">
            <fieldset>
                <legend><h2>Inicia sesión</h2></legend>
                <label>Usuario: </label>
                <input type="text" name="txt_usuario" required>  <br><br>

                <label>Contraceña</label>
                <input type="text" name="txt_contracena" required>  <br><br>

                <button type="submit">Ingresar</button>
            </fieldset>
        </form>
        
        <p style="color: red" id="p_mensaje"></p>
        <a href="/registrate.php">Regístrate</a>
    </main>

    <footer>
        <hr>
        Derechos reservados &copy; 2019-2020
    </footer>
    
    <!--- javascript --->
    <script>
        document.getElementById('frm_login').addEventListener('submit', event => {
            
            event.preventDefault()

            const frmDatos = new FormData( document.getElementById('frm_login') )

            fetch('/ajax/usuarios.php?action=login', {
                method:'POST',
                body: frmDatos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                respuesta.msg === 'bienvenido'
                    ? window.location.href = "/view/inicio.php"
                    : mostrarError(respuesta.msg)
            })
            .catch(error =>{
                console.error(error)
            })
        })

        function mostrarError(msg)
        {
            document.getElementById('p_mensaje').innerText = msg
        }
    </script>
</body>
</html>