<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style2.css">
    <link rel="shortcut icon" href="Img/logo.ico">
    <title>Gobierno de la Ciudad de México</title>
</head>
<body>
<body>
    <nav>
        <div class="logo">
            <a href="https://www.finanzas.cdmx.gob.mx/"><img src="Img/logo.png"></a>
        </div>
        <a href="paginaPrincipal.php"><h2 class="encabezado">SISTEMA DE BUSQUEDA DE EMPLEADOS</h2></a><a href="cerrarsesion.php"><button>Salir</button></a>
    </nav>
    <div class="portfolio" id="portfolio">
        <div class="portfo-items">
            <div class="item">
                <div class="info">
                    <h4>Busqueda de empleado </h4>                 
                    
                
                    <div class="boton">
                        <form method="POST">
                        NOMBRE: &nbsp <input type="TEXT" name="NOMBRE" id="GRANDE"> &nbsp PRIMER APELLIDO: &nbsp <input type="TEXT" name="APELLIDO1" id="GRANDE"> &nbsp
                        SEGUNDO APELLIDO: &nbsp <input type="TEXT" name="APELLIDO2" id="GRANDE"> &nbsp  CURP: &nbsp <input type="TEXT" name="CURP" id="GRANDE"> &nbsp
                        RFC: &nbsp <input type="TEXT" name="RFC" id="GRANDE"> &nbsp <button>Buscar</button> 
                        </form> 
                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                        &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                        &nbsp &nbsp &nbsp  <a href="paginaPrincipal.php"><button>Regresar</button></a> 
                        <?php
                            // Importar credenciales
                            session_start();
                            $user2 = $_SESSION['usuario'];
                            $pass2 = $_SESSION['password'];
    
                            $dsn = 'Nomina';
                            $conn4 = odbc_connect($dsn, $user2, $pass2);
    
                            if (!$conn4) {
    
                            exit("Error en la conexión: " . odbc_errormsg());
    
                            }
                            $nombreEmpleado = trim(strtoupper($_POST['NOMBRE']));
                            $apellidoUno = trim(strtoupper($_POST['APELLIDO1']));
                            $apellidoDos = trim(strtoupper($_POST['APELLIDO2']));
                            $curp = trim(strtoupper($_POST['CURP']));
                            $rfc = trim(strtoupper($_POST['RFC']));

                            $sql3 = "SELECT * FROM m4t_empleados
                                    WHERE  NOMBRE LIKE '%$nombreEmpleado%'
                                    AND APELLIDO_1 LIKE '%$apellidoUno%'
                                    AND APELLIDO_2 LIKE '%$apellidoDos%'
                                    AND IDENTIFICADOR_CIUDADANO LIKE '%$curp%'
                                    AND ID_LEGAL LIKE '%$rfc%'";
                            $result3 = odbc_exec($conn4, $sql3);

                            if (!$result3) {
                                echo "Error en la consulta.<br>";
                                exit;
                            }
                        ?>
                        
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="tabla">
            <h2>RESULTADO DE LA BUSQUEDA</h2> 
                 <table style ="width: 80%">
                            <tr>
                                <th>NUMERO DE EMPLEADO</th>
                                <th>NOMBRE</th>
                                <th>PRIMER APELLIDO</th>
                                <th>SEGUNDO APELLIDO</th>
                                <th>CURP</th>
                                <th>RFC</th>
                            </tr>

                            <?php
                                while(odbc_fetch_row($result3)){
                                    $idEmpleado = odbc_result($result3, "ID_EMPLEADO");
                                    $nombre = odbc_result($result3, "NOMBRE");
                                    $apellido1 = odbc_result($result3, "APELLIDO_1");
                                    $apellido2 = odbc_result($result3, "APELLIDO_2");
                                    $curp = odbc_result($result3, "IDENTIFICADOR_CIUDADANO");
                                    $rfc = odbc_result($result3, "ID_LEGAL");

                                echo "
                                <tr>
                                    <th>$idEmpleado</th>
                                    <th>$nombre</th>
                                    <th>$apellido1</th>
                                    <th>$apellido2</th>
                                    <th>$curp</th>
                                    <th>$rfc</th>
                                </tr>";
                            }
                            ?>

                    </table>     
        </div>
    <footer>
        <div class="top">
            <div class="logo">
            <a href="https://www.finanzas.cdmx.gob.mx/"><img src="Img/logo.png"></a>
            </div>
                 <div class="bottom">
            <div class="links">
                <a href="https://www.finanzas.cdmx.gob.mx/terminos-y-condiciones">Politica de Privacidad</a>
                <a href="https://www.finanzas.cdmx.gob.mx/terminos-y-condiciones">Terminos y Condiciones</a>
                <a href="#">Cookies Setting</a>
            </div>
        </div>
            <div class="social-links">
                <a href="https://www.facebook.com/AdministracionyFinanzasCiudadDeMexico/"><i class='bx bxl-facebook'></i></a>
                <a href="https://www.instagram.com/safcdmx/"><i class='bx bxl-instagram'></i></a>
                <a href="https://x.com/finanzas_cdmx"><i class='bx bxl-twitter'></i></a>
            </div>
        </div>
    </footer>
    <?
    odbc_close($conn4);
    ?>

    <script src="script.js"></script> 
</body>
</html>