<?php
session_start(); // Inicia la sesión

$dsn = 'Nomina'; // El nombre del DSN configurado
$usuario = strtoupper(trim($_POST['user'])); // El nombre de usuario de la base de datos
$password = strtolower(trim($_POST['pass'])); // La contraseña de la base de datos

$_SESSION['usuario'] = $usuario;
$_SESSION['password'] = $password;

$conn = odbc_connect($dsn, $usuario, $password);

if (!$conn) {
        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="css/style2.css">
                    <title>Gobierno de la Ciudad de México</title>
                </head>
                <body>
                    <nav>
                        <div class="logo">
                            <a href="https://www.finanzas.cdmx.gob.mx/"><img src="Img/logo.png"></a>
                        </div>
                        <h2 class="encabezado">SISTEMA DE BUSQUEDA DE EMPLEADOS</h2></a> <a href="cerrarsesion.php"><button>Salir</button></a>
                    </nav>
                <h3 style="color: red;
                            font-size: 50px;
                            font-weight: 600;
                            text-align: center;
                            margin-top: 300px;">Nombre de usuario o contraseña incorrectos.</h3> 
                </body>
                </html>';
    exit();
    
}else{
    header("Location: paginaPrincipal.php");
}
// Cerrar la conexión
  odbc_close($conn);
?>


