<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      session_start();
      $user5 = $_SESSION['usuario'];
      $pass5 = $_SESSION['password'];

      $dsn = 'Nomina';

      $conn5 = odbc_connect($dsn, $user5, $pass5);

      if (!$conn5) {
         exit("Error en la conexión: " . odbc_errormsg());
      }

      $id = $_GET['variable'];

      $sqlDatos = "SELECT A.ID_EMPLEADO,  APELLIDO_1||' '|| APELLIDO_2||' '|| NOMBRE NOMBRE_EMPL , id_legal rfc ,identificador_ciudadano curp, A.ID_MOTIVO_MOVTO_EMP, ID_SINDICATO, N_PUESTO, A.ID_UNIDAD_ADM, N_UNIDAD_ADM
                            FROM m4t_resumen_movtos_emp A, m4t_puestos_trabajo B, m4_unidades_adm C, m4t_empleados D
                            WHERE A.FEC_INICIO IN(SELECT MAX(FEC_INICIO) FROM m4t_resumen_movtos_emp
                                            WHERE ID_EMPLEADO = A.ID_EMPLEADO 
                                            AND ID_EMPLEADO = '$id'
                                            AND ID_TIPO_MOVTO_EMP NOT IN(3))
                            and A.ID_NIVEL_SALARIAL = B.ID_NIVEL_SALARIAL
                            AND A.ID_PUESTO = B.ID_PUESTO
                            AND A.ID_EMPLEADO = D.ID_EMPLEADO
                            AND A.ID_UNIDAD_ADM = C.ID_UNIDAD_ADM";
                        $resultDatos = odbc_exec($conn5, $sqlDatos);

      if (!$resultDatos) {
            echo "Error en la consulta.<br>";
            exit;
      }

      while(odbc_fetch_row($resultDatos)){
         $idEmp = odbc_result($resultDatos, "ID_EMPLEADO");
         $nombreEmp = odbc_result($resultDatos, "NOMBRE_EMPL");
         $curpEmp = odbc_result($resultDatos, "CURP");
         $rfcEmp = odbc_result($resultDatos, "rfc");
         $uniadmEmp = odbc_result($resultDatos, "ID_UNIDAD_ADM");
         $nomuniadmEmp = odbc_result($resultDatos, "N_UNIDAD_ADM");
         $puestoEmp = odbc_result($resultDatos, "N_PUESTO");
         $sindicatoEmp = odbc_result($resultDatos, "ID_SINDICATO");
         $comisionSindicalEmp = odbc_result($resultDatos, "ID_MOTIVO_MOVTO_EMP");
      }

      $this->Image('LOGOCDMX.png', 10, 5, 75); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG


      $this->SetTextColor(0, 0, 0);
      $this->Cell(212);  // mover a la derecha
      $this->SetFont('Arial', 'B', 8);
      $this->Cell(96, 0, utf8_decode("SECRETARÍA DE ADMINISTRACIÓN Y FINANZAS"), 0, 0, '', 0);
      $this->Ln(5);


      $this->SetTextColor(0, 0, 0);
      $this->Cell(165);  // mover a la derecha
      $this->SetFont('Arial', 'B', 7);
      $this->Cell(59, 0, utf8_decode("DIRECCIÓN GENERAL DE ADMINISTRACION DE PERSONAL Y DESARROLLO ADMINISTRATIVO"), 0, 0, '', 0);
      $this->Ln(5);


      $this->SetTextColor(0, 0, 0);
      $this->Cell(205);  // mover a la derecha
      $this->SetFont('Arial', 'B', 7);
      $this->Cell(85, 0, utf8_decode("DIRECCIÓN EJECUTIVA DE ADMINISTRACIÓN DE PERSONAL"), 0, 0, '', 0);
      $this->Ln(5);


      $this->SetTextColor(0, 0, 0);
      $this->Cell(223);  // mover a la derecha
      $this->SetFont('Arial', 'B', 7);
      $this->Cell(85, 0, utf8_decode("DIRECCIÓN DE ADMINISTRACIÓN DE NÓMINA"), 0, 0, '', 0);
      $this->Ln(10);

      //DATOS EMPLEADO
      $this->SetTextColor(0, 0, 0);
      $this->Cell(1);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 0, utf8_decode("DATOS ACTUALES DEL EMPLEADO"), 0, 0, '', 0);
      $this->Ln(5);

     $this->SetTextColor(0, 0, 0);
     $this->Cell(1);  // mover a la derecha
     $this->SetFont('Arial', 'B', 7);
     $this->Cell(50, 0, utf8_decode("NUMERO DE EMPLEADO: $idEmp"), 0, 0, '', 0);
     $this->SetTextColor(0, 0, 0);
     $this->Cell(1);  // mover a la derecha
     $this->SetFont('Arial', 'B', 7);
     $this->Cell(90, 0, utf8_decode("NOMBRE DE EMPLEADO: $nombreEmp"), 0, 0, '', 0);
     $this->Cell(1);  // mover a la derecha
     $this->SetFont('Arial', 'B', 7);
     $this->Cell(50, 0, utf8_decode("CURP: $curpEmp"), 0, 0, '', 0);
     $this->Cell(1);  // mover a la derecha
     $this->SetFont('Arial', 'B', 7);
     $this->Cell(60, 0, utf8_decode("RFC: $rfcEmp"), 0, 0, '', 0);
     $this->Ln(5);

     $this->SetTextColor(0, 0, 0);
     $this->Cell(1);  // mover a la derecha
     $this->SetFont('Arial', 'B', 7);
     $this->Cell(51, 0, utf8_decode("UNIDAD ADMINISTRATIVA: $uniadmEmp"), 0, 0, '', 0);
     $this->Cell(91, 0, utf8_decode("NOMBRE DE LA UNIDAD: $nomuniadmEmp"), 0, 0, '', 0);
     $this->Ln(5);

     $this->SetTextColor(0, 0, 0);
     $this->Cell(1);  // mover a la derecha
     $this->SetFont('Arial', 'B', 7);
     $this->Cell(90, 0, utf8_decode("PUESTO: $puestoEmp"), 0, 0, '', 0);
     $this->Cell(40, 0, utf8_decode("DIGITO SINDICAL: $sindicatoEmp"), 0, 0, '', 0);

      $sindi ="";
     if($comisionSindicalEmp ==  2753): $sindi = "MENSUAL"; elseif($comisionSindicalEmp == 2754 ): $sindi = "ANUAL"; else: $sindi = "SIN COMISION"; endif;
      $this->Cell(40, 0, utf8_decode("COMISION SINDICAL: $sindi"), 0, 0, '', 0);
     $this->Ln(5);



      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor( 0, 0, 0);
      $this->Cell(80); // mover a la derecha
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(100, 10, utf8_decode("HISTORIAL"), 0, 1, 'C', 0);
      $this->Ln(2);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(144, 12, 31); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(0,0,0); //colorBorde
      $this->SetFont('Arial', 'B', 6);
      $this->Cell(13, 10, utf8_decode('FEC. ALTA'), 1, 0, 'C', 1);
      $this->Cell(8, 10, utf8_decode('MOV.'), 1, 0, 'C', 1);
      $this->Cell(55, 10, utf8_decode('DESCRIPCION DEL MOVIMIENTO'), 1, 0, 'C', 1);
      $this->Cell(13, 10, utf8_decode('FEC. INICIO'), 1, 0, 'C', 1);
      $this->Cell(13, 10, utf8_decode('FEC. FIN'), 1, 0, 'C', 1);
      $this->Cell(12, 10, utf8_decode('UNIVERSO'), 1, 0, 'C', 1);
      $this->Cell(18, 10, utf8_decode('NVL SALARIAL'), 1, 0, 'C', 1);
      $this->Cell(11, 10, utf8_decode('TURNO'), 1, 0, 'C', 1);
      $this->Cell(13, 10, utf8_decode('PUESTO'), 1, 0, 'C', 1);
      //$this->Cell(42, 10, utf8_decode('DESCRIPCION DEL PUESTO'), 1, 0, 'C', 1);
      $this->Cell(13, 10, utf8_decode('SIT. EMPL'), 1, 0, 'C', 1);
      $this->Cell(107, 10, utf8_decode('UNIDAD ADMINISTRATIVA'), 1, 1, 'C', 1);
      odbc_close($conn5);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(255, 255, 255); //colorFondo
$pdf->SetDrawColor(0, 0, 0); //colorBorde


session_start();
$user6 = $_SESSION['usuario'];
$pass6 = $_SESSION['password'];

$dsn = 'Nomina';

$conn6 = odbc_connect($dsn, $user6, $pass6);

if (!$conn6) {
   exit("Error en la conexión: " . odbc_errormsg());
}


$id = $_GET['variable'];

$sqlnew ="SELECT A.ID_EMPLEADO,A.FEC_ALTA_EMPLEADO,A.FEC_INICIO,A.fec_fin ,A.ID_MOTIVO_MOVTO_EMP, N_MOTIVO_MOVTO_EMP, ID_PLAZA,A.ID_UNIVERSO,A.ID_NIVEL_SALARIAL,A.ID_PUESTO,ID_TURNO,ID_SITUACION_EMP,N_UNIDAD_ADM, E.N_PUESTO
                                FROM m4t_resumen_movtos_EMP A, M4T_MOTIVOS_MOVTO_EMP B,M4T_EMPLEADOS C,m4_unidades_adm D, m4t_puestos_trabajo E
                                WHERE A.ID_EMPLEADO ='$id'
                                AND A.ID_EMPLEADO = C.ID_EMPLEADO
                                AND A.ID_MOTIVO_MOVTO_EMP = B.ID_MOTIVO_MOVTO_EMP
                                AND A.ID_UNIDAD_ADM = D.ID_UNIDAD_ADM
                                AND A.ID_PUESTO = E.ID_PUESTO
                                AND A.ID_NIVEL_SALARIAL = E.ID_NIVEL_SALARIAL
                                AND A.ID_UNIVERSO = E.ID_UNIVERSO
                                ORDER BY ID_EMPLEADO,FEC_INICIO";
$resultnew = odbc_exec($conn6, $sqlnew);


while(odbc_fetch_row($resultnew)){

   $fecAlta = odbc_result($resultnew, "FEC_ALTA_EMPLEADO");
   $motiMov = odbc_result($resultnew, "ID_MOTIVO_MOVTO_EMP");
   $motivoEmp = odbc_result($resultnew, "N_MOTIVO_MOVTO_EMP");
   $fecInicio = odbc_result($resultnew, "FEC_INICIO");
   $fecFin = odbc_result($resultnew, "FEC_FIN");
   $idPlaza = odbc_result($resultnew, "ID_PLAZA");
   $idUniverso = odbc_result($resultnew, "ID_UNIVERSO");
   $nivelSalarial = odbc_result($resultnew, "ID_NIVEL_SALARIAL");
   $idTurno = odbc_result($resultnew, "ID_TURNO");
   $idPuesto = odbc_result($resultnew, "ID_PUESTO");
   $situaEmp = odbc_result($resultnew, "ID_SITUACION_EMP");
   $nomUniadm = odbc_result($resultnew, "N_UNIDAD_ADM");


   if($fecFin == null):
   $pdf->Cell(13, 10, utf8_decode(date("d/m/Y", strtotime($fecAlta))), 1, 0, 'C', 1);
   $pdf->Cell(8, 10, utf8_decode($motiMov), 1, 0, 'C', 1);
   $pdf->Cell(55, 10, utf8_decode($motivoEmp), 1, 0, 'C', 1);
   $pdf->Cell(13, 10, utf8_decode(date("d/m/y", strtotime($fecInicio))), 1, 0, 'C', 1);
   $pdf->Cell(13, 10, utf8_decode(" "), 1, 0, 'C', 1);
   $pdf->Cell(12, 10, utf8_decode($idUniverso), 1, 0, 'C', 1);
   $pdf->Cell(18, 10, utf8_decode($nivelSalarial), 1, 0, 'C', 1);
   $pdf->Cell(11, 10, utf8_decode($idTurno), 1, 0, 'C', 1);
   $pdf->Cell(13, 10, utf8_decode($idPuesto), 1, 0, 'C', 1);
   //$pdf->Cell(42, 10, utf8_decode($puesto2), 1, 0, 'C', 1);
   $pdf->Cell(13, 10, utf8_decode($situaEmp), 1, 0, 'C', 1);
   $pdf->Cell(107, 10, utf8_decode($nomUniadm), 1, 1, 'J', 1);
   ;else: 
      $pdf->Cell(13, 10, utf8_decode(date("d/m/Y", strtotime($fecAlta))), 1, 0, 'C', 1);
      $pdf->Cell(8, 10, utf8_decode($motiMov), 1, 0, 'C', 1);
      $pdf->Cell(55, 10, utf8_decode($motivoEmp), 1, 0, 'C', 1);
      $pdf->Cell(13, 10, utf8_decode(date("d/m/y", strtotime($fecInicio))), 1, 0, 'C', 1);
      $pdf->Cell(13, 10, utf8_decode(date("d/m/Y", strtotime($fecFin))), 1, 0, 'C', 1);
      $pdf->Cell(12, 10, utf8_decode($idUniverso), 1, 0, 'C', 1);
      $pdf->Cell(18, 10, utf8_decode($nivelSalarial), 1, 0, 'C', 1);
      $pdf->Cell(11, 10, utf8_decode($idTurno), 1, 0, 'C', 1);
      $pdf->Cell(13, 10, utf8_decode($idPuesto), 1, 0, 'C', 1);
      //$pdf->Cell(42, 10, utf8_decode($puesto2), 1, 0, 'C', 1);
      $pdf->Cell(13, 10, utf8_decode($situaEmp), 1, 0, 'C', 1);
      $pdf->Cell(107, 10, utf8_decode($nomUniadm), 1, 1, 'J', 1);
   endif;
}

odbc_close($conn6);
$pdf->Output('HistorialEmpleado.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)

