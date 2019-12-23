<?php
    session_start();
    if (!isset($_SESSION['usuario']))
        header("location: /");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['usuario']?> | lista</title>
</head>
<body>
    <header>
        <h1><u>Mis actividades</u></h1>
    </header>

    <nav style="display:flex; justify-content: space-between">
        <a href="/view/inicio.php">Inicio</a>
        <a href="/view/registrar.php">Registrar</a>
        <a href="/salir.php">salir</a>
    </nav>
    <br>

    <main>
        <div style="display: flex; justify-content: space-between">
            <button id="btn_sinRealizar">Sin realizar</button>
            <span   id="p_msg" style="color:green">...</span>
            <button id="btn_realizados">Realizados</button>
        </div>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Fecha</th>
                    <th>Realizado</th>
                    <th colspan=2>Opciones</th>
                </tr>
            </thead>
            <tbody id="tb_actividades">
            </tbody>
        </table>
    </main>

    <footer>
        <hr>
        Derechos reservados &copy; 2019-2020
    </footer>

    <script>
        const btnRealizados = document.getElementById('btn_realizados')
        const btnSinRealizar= document.getElementById('btn_sinRealizar')
        const pMensaje      = document.getElementById("p_msg")
        const tbActividades = document.getElementById('tb_actividades');
        
        btnRealizados.addEventListener('click', ()=>{
            traerActividadesRealizadas();
        })

        btnSinRealizar.addEventListener('click', ()=>{
            traerActividadesNoRealizadas();
        })

        function eliminarActividadNoRealizada(actividad)
        {
            const frmDatos = new FormData()
            frmDatos.append("codigo", actividad)

            fetch('/ajax/usuario.php?action=eliminarActividad', {
                method:'POST',
                body: frmDatos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta =>{
                mostrarMensaje(respuesta.msg)                
            })
            .catch(error => console.error(error))

            traerActividadesNoRealizadas()
        }

        function eliminarActividadRealizada(actividad)
        {
            const frmDatos = new FormData()
            frmDatos.append("codigo", actividad)

            fetch('/ajax/usuario.php?action=eliminarActividad', {
                method:'POST',
                body: frmDatos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta =>{
                mostrarMensaje(respuesta.msg)                  
            })
            .catch(error => console.error(error))

            traerActividadesRealizadas()
        }

        function cambiaActividadRealizada(actividad)
        {
            const frmDatos = new FormData()
            frmDatos.append("codigo", actividad)

            fetch('/ajax/usuario.php?action=actividadRealizada', {
                method:'POST',
                body: frmDatos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta =>{
                mostrarMensaje(respuesta.msg)                  
            })
            .catch(error => console.error(error))

            traerActividadesNoRealizadas()
        }

        function traerActividadesRealizadas()
        {
            fetch('/ajax/usuario.php?action=listarActividadesHechas', {
                method:'GET'
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                let listado = ''

                for (let indice = 0; indice < respuesta.length; indice++)
                    listado += `
                        <tr>
                            <td>${respuesta[indice].descripcion}</td>
                            <td>${respuesta[indice].fecha}</td>
                            <td>SI</td>
                            <td>
                                <button
                                    style="color:red"
                                    onclick="eliminarActividadRealizada('${respuesta[indice].id}')"
                                >X
                                </button>
                            </td>
                        </tr>
                    `                
                    tbActividades.innerHTML = listado
            })
            .catch(error => console.error(error))
        }

        function traerActividadesNoRealizadas()
        {
            fetch('/ajax/usuario.php?action=listarActividadesNoHechas', {
                method:'GET'
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                let listado = ''

                for (let actividad of respuesta)
                    listado += `
                        <tr>
                            <td>${actividad.descripcion}</td>
                            <td>${actividad.fecha}</td>
                            <td>NO</td>
                            <td>
                                <button
                                    style="color:red"
                                    onclick="eliminarActividadNoRealizada('${actividad.id}')"
                                >X
                                </button>
                            </td>
                            <td>
                                <button
                                style="color:green"
                                onclick="cambiaActividadRealizada(${actividad.id})"
                                >_Ok_
                                </button>
                            </td>
                        </tr>
                    `                
                    tbActividades.innerHTML = listado
            })
            .catch(error => console.error(error))
        }

        function mostrarMensaje(mensaje)
        {
            pMensaje.innerText = mensaje
        }
        
        /* Funcion anónina se ejecunta automáticamente */
        (function(){
            traerActividadesNoRealizadas()
        })()
    </script>

    <style>
    td, th, table{
        border: 1px solid gray;
    }
    </style>
</body>
</html>