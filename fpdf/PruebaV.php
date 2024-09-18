<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

      // //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      $this->Image('LOGOCDMX.png', 10, 5, 75); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      $this->SetTextColor(104); //color

    
      $this->SetTextColor(0, 0, 0);
      $this->Cell(82);  // mover a la derecha
      $this->SetFont('Arial', 'B', 8);
      $this->Cell(96, 0, utf8_decode("SECRETARÍA DE ADMINISTRACIÓN Y FINANZAS"), 0, 0, '', 0);
      $this->Ln(5);

     
      $this->SetTextColor(0, 0, 0);
      $this->Cell(80);  // mover a la derecha
      $this->SetFont('Arial', 'B', 7);
      $this->Cell(59, 0, utf8_decode("DIRECCIÓN GENERAL DE ADMINISTRACION DE PERSONAL Y DESARROLLO ADMINISTRATIVO"), 0, 0, '', 0);
      $this->Ln(5);

 
      $this->SetTextColor(0, 0, 0);
      $this->Cell(120);  // mover a la derecha
      $this->SetFont('Arial', 'B', 7);
      $this->Cell(85, 0, utf8_decode("DIRECCIÓN EJECUTIVA DE ADMINISTRACIÓN DE PERSONAL"), 0, 0, '', 0);
      $this->Ln(5);

   
      $this->SetTextColor(0, 0, 0);
      $this->Cell(138);  // mover a la derecha
      $this->SetFont('Arial', 'B', 7);
      $this->Cell(85, 0, utf8_decode("DIRECCIÓN DE ADMINISTRACIÓN DE NÓMINA"), 0, 0, '', 0);
      $this->Ln(10);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 0, 0);
      $this->Cell(50); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("HISTORIAL"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(144, 12, 31); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(0,0,0); //colorBorde
      $this->SetFont('Arial', 'B', 7);
      $this->Cell(18, 10, utf8_decode('FECHA DE ALTA'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('FECHA DE INICIO'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('FECHA DE FIN'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('MOTIVO MOVIMIENTO'), 1, 0, 'C', 1);
      $this->Cell(70, 10, utf8_decode('DESCRIPCION DEL MOVIMIENTO'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('UNIVERSO'), 1, 1, 'C', 1);
      $this->Cell(25, 10, utf8_decode('NIVEL SALARIAL'), 1, 1, 'C', 1);
      $this->Cell(25, 10, utf8_decode('TURNO'), 1, 1, 'C', 1);
      $this->Cell(25, 10, utf8_decode('PUESTO'), 1, 1, 'C', 1);
      $this->Cell(25, 10, utf8_decode('DESCRIPCION DEL PUESTO'), 1, 1, 'C', 1);
      $this->Cell(25, 10, utf8_decode('SITUACION DEL EMPLEADO'), 1, 1, 'C', 1);
      $this->Cell(25, 10, utf8_decode('UNIDAD ADMINISTRATIVA'), 1, 1, 'C', 1);
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
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(0,0,0); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;
/* TABLA */
$pdf->Cell(18, 10, utf8_decode('FECHA DE ALTA'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('FECHA DE INICIO'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('FECHA DE FIN'), 1, 0, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('MOTIVO MOVIMIENTO'), 1, 0, 'C', 1);
$pdf->MultiCell(70, 10, utf8_decode('DESCRIPCION DEL MOVIMIENTO'), 1, 0, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('UNIVERSO'), 1, 1, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('NIVEL SALARIAL'), 1, 1, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('TURNO'), 1, 1, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('PUESTO'), 1, 1, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('DESCRIPCION DEL PUESTO'), 1, 1, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('SITUACION DEL EMPLEADO'), 1, 1, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('UNIDAD ADMINISTRATIVA'), 1, 1, 'C', 1);

$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
