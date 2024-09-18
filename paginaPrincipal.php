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
    <nav>
        <div class="logo">
            <a href="https://www.finanzas.cdmx.gob.mx/"><img src="Img/logo.png"></a>
        </div>
        <h2 class="encabezado">SISTEMA DE BUSQUEDA DE EMPLEADOS</h2><a href="cerrarsesion.php"><button>Salir</button></a>
    </nav>

<div class="portfolio" id="portfolio">
        <div class="portfo-items">
            <div class="item">
                <div class="info">
                    <h4>Busqueda de empleado</h4>                           
                <div class="boton">
                    <form method="POST">
                    NUMERO DE EMPLEADO: &nbsp <input type="TEXT" name="id_empleado"> &nbsp <button>Buscar</button> 
                    </form> 
                    <p> BUSQUEDA DE NUMERO DE EMPLEADO POR NOMBRE / RFC / CURP: &nbsp <a href="listaEmpleados.php"><button>Lista de empleados</button></a></p>  
                    <?php
                        // Importar credenciales
                       // include 'conexion.php';
                       session_start();
                        $user = $_SESSION['usuario'];
                        $pass = $_SESSION['password'];

                        $dsn = 'Nomina';
                        $conn2 = odbc_connect($dsn, $user, $pass);

                        if (!$conn2) {

                        exit("Error en la conexión: " . odbc_errormsg());

                        }
                        
                        $idEmpleado = trim($_POST['id_empleado']);

                        $nuevoId = $idEmpleado;

                        $sql = "SELECT A.ID_EMPLEADO,  APELLIDO_1||' '|| APELLIDO_2||' '|| NOMBRE NOMBRE_EMPL , id_legal rfc ,identificador_ciudadano curp, A.ID_MOTIVO_MOVTO_EMP, ID_SINDICATO, N_PUESTO, A.ID_UNIDAD_ADM, N_UNIDAD_ADM
                            FROM m4t_resumen_movtos_emp A, m4t_puestos_trabajo B, m4_unidades_adm C, m4t_empleados D
                            WHERE A.FEC_INICIO IN(SELECT MAX(FEC_INICIO) FROM m4t_resumen_movtos_emp
                                            WHERE ID_EMPLEADO = A.ID_EMPLEADO 
                                            AND ID_EMPLEADO = '$idEmpleado'
                                            AND ID_TIPO_MOVTO_EMP NOT IN(3))
                            and A.ID_NIVEL_SALARIAL = B.ID_NIVEL_SALARIAL
                            AND A.ID_PUESTO = B.ID_PUESTO
                            AND A.ID_EMPLEADO = D.ID_EMPLEADO
                            AND A.ID_UNIDAD_ADM = C.ID_UNIDAD_ADM";
                        $result = odbc_exec($conn2, $sql);

                        if (!$result) {
                            echo "Error en la consulta.<br>";
                            exit;
                        }

                        $sql2 = "SELECT A.ID_EMPLEADO,A.FEC_ALTA_EMPLEADO,A.FEC_INICIO,A.fec_fin ,A.ID_MOTIVO_MOVTO_EMP, N_MOTIVO_MOVTO_EMP, ID_PLAZA,A.ID_UNIVERSO,A.ID_NIVEL_SALARIAL,A.ID_PUESTO,ID_TURNO,ID_SITUACION_EMP,N_UNIDAD_ADM, E.N_PUESTO
                                FROM m4t_resumen_movtos_EMP A, M4T_MOTIVOS_MOVTO_EMP B,M4T_EMPLEADOS C,m4_unidades_adm D, m4t_puestos_trabajo E
                                WHERE A.ID_EMPLEADO ='$idEmpleado'
                                AND A.ID_EMPLEADO = C.ID_EMPLEADO
                                AND A.ID_MOTIVO_MOVTO_EMP = B.ID_MOTIVO_MOVTO_EMP
                                AND A.ID_UNIDAD_ADM = D.ID_UNIDAD_ADM
                                AND A.ID_PUESTO = E.ID_PUESTO
                                AND A.ID_NIVEL_SALARIAL = E.ID_NIVEL_SALARIAL
                                AND A.ID_UNIVERSO = E.ID_UNIVERSO
                                ORDER BY ID_EMPLEADO,FEC_INICIO";
                        $result2 = odbc_exec($conn2, $sql2);

                        if (!$result2) {
                            echo "Error en la consulta.<br>";
                            exit;
                        }
                    ?>                    
                </div>
            </div> 
        </div>
    </div>
</div>

    <div class="portfolio" id="portfolio">
        <div class="portfo-items">
            <div class="item">
                <div class="info">
                    <h4>Datos actuales del empleado</h4><br><br>
                        <?php
                        while(odbc_fetch_row($result)){
                            $id = odbc_result($result, "ID_EMPLEADO");
                            $nombre = odbc_result($result, "NOMBRE_EMPL");
                            $curp = odbc_result($result, "CURP");
                            $rfc = odbc_result($result, "rfc");
                            $uniadm = odbc_result($result, "ID_UNIDAD_ADM");
                            $nomuniadm = odbc_result($result, "N_UNIDAD_ADM");
                            $puesto = odbc_result($result, "N_PUESTO"); 
                            $sindicato = odbc_result($result, "ID_SINDICATO"); 
                            $comisionSindical = odbc_result($result, "ID_MOTIVO_MOVTO_EMP");                        
                        }?>

                        <p> <b>NUMERO DE EMPLEADO: &nbsp</b> <?php echo "$id"?> <br><br><br>                       
                        <b>NOMBRE DEL EMPLEADO: &nbsp </b><?php echo "$nombre"?>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <b>CURP: &nbsp </b><?php echo "$curp"?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <b>RFC: &nbsp </b><?php echo "$rfc"?><br><br><br>
                        <b>UNIDAD ADMINISTRATIVA: &nbsp </b><?php echo "$uniadm"?>  &nbsp &nbsp &nbsp  &nbsp &nbsp <b>NOMBRE UNIDAD ADMINISTRATIVA: &nbsp </b><?php echo "$nomuniadm"?><br><br>
                        <b>PUESTO: &nbsp </b><?php echo "$puesto"?> &nbsp &nbsp &nbsp <b>DIGITO SINDICAL: &nbsp </b><?php echo "$sindicato";?> &nbsp &nbsp &nbsp 
                        <b>COMISION SINDICAL: &nbsp </b><?php if($comisionSindical==2753): echo "MENSUAL"; elseif($comisionSindical==2754): echo "ANUAL"; else: echo "SIN COMISION"; endif; ?>
                        <a href="fpdf/PruebaH.php?variable=<?php echo $nuevoId;?>" target="_blank"> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                        &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp <button> DESCARGAR EN PDF</button></a></p>                        
                </div>
            </div>
        </div>
    </div>

    <div class="tabla">
            <h2>HISTORIAL</h2>
                 <table style ="width: 80%">
                            <tr>
                                <th>FECHA DE ALTA</th>
                                <th>FECHA DE INICIO</th>
                                <th>FECHA DE FIN</th>
                                <th>MOTIVO MOVIMIENTO</th>
                                <th>DESCRIPCION DEL MOVIMIENTO</th>
                                <th>PLAZA</th>
                                <th>UNIVERSO</th>
                                <th>NIVEL SALARIAL</th>
                                <th>TURNO</th>
                                <th>PUESTO</th>
                                <th>DESCRIPCION DEL PUESTO</th>
                                <th>SITUACION DEL EMPLEADO</th>
                                <th>UNIDAD ADMINISTRATIVA</th>
                            </tr>
                         
                            <?php
                                while(odbc_fetch_row($result2)){
                                    $fecAlta = odbc_result($result2, "FEC_ALTA_EMPLEADO");
                                    $fecInicio = odbc_result($result2, "FEC_INICIO");
                                    $fecFin = odbc_result($result2, "FEC_FIN");
                                    $motiMov = odbc_result($result2, "ID_MOTIVO_MOVTO_EMP");
                                    $motivoEmp = odbc_result($result2, "N_MOTIVO_MOVTO_EMP");
                                    $idPlaza = odbc_result($result2, "ID_PLAZA");
                                    $idUniverso = odbc_result($result2, "ID_UNIVERSO");
                                    $nivelSalarial = odbc_result($result2, "ID_NIVEL_SALARIAL");
                                    $idTurno = odbc_result($result2, "ID_TURNO");
                                    $idPuesto = odbc_result($result2, "ID_PUESTO");
                                    $puesto2 = odbc_result($result2, "N_PUESTO");
                                    $situaEmp = odbc_result($result2, "ID_SITUACION_EMP");
                                    $nomUniadm = odbc_result($result2, "N_UNIDAD_ADM"); 
                               
                                    if($fecFin == null): echo "
                                <tr>
                                    <th>", date("d/m/Y", strtotime($fecAlta)), "</th>
                                    <th>", date("d/m/Y", strtotime($fecInicio)), "</th>
                                    <th>  </th>
                                    <th>$motiMov</th>
                                    <th>$motivoEmp</th>
                                    <th>$idPlaza</th>
                                    <th>$idUniverso</th>
                                    <th>$nivelSalarial</th>
                                    <th>$idTurno</th>
                                    <th>$idPuesto</th>
                                    <th>$puesto2</th>
                                    <th>$situaEmp</th>
                                    <th>$nomUniadm</th>
                                </tr>
                                ";else: echo "
                                <tr>
                                    <th>", date("d/m/Y", strtotime($fecAlta)), "</th>
                                    <th>", date("d/m/Y", strtotime($fecInicio)), "</th>
                                    <th> ", date("d/m/Y", strtotime($fecFin)), " </th>
                                    <th>$motiMov</th>
                                    <th>$motivoEmp</th>
                                    <th>$idPlaza</th>
                                    <th>$idUniverso</th>
                                    <th>$nivelSalarial</th>
                                    <th>$idTurno</th>
                                    <th>$idPuesto</th>
                                    <th>$puesto2</th>
                                    <th>$situaEmp</th>
                                    <th>$nomUniadm</th>
                                </tr>";
                                endif;
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
    odbc_close($conn2);
    ?>

    <script src="script.js"></script>
</body>

</html>