<?php
session_start();
require_once('../librerias/tcpdf/config/lang/spa.php');
require_once('../librerias/tcpdf/tcpdf.php');

$anio=$_GET['anio']; 
$mes=$_GET['mes'];
$cargo=$_GET['cargo'];
$centro_costo=$_GET['cc'];
$perfil=@$_SESSION['nom']; //pERFIL JEFE

if($perfil=="TURNOSHE"){
	
	$perfil=@$_GET['perfil'];

}



switch ($mes){

	case 1:
		$return='ENERO';
	break;
	case 2:
		$return='FEBRERO';
	break;
	case 3:
		$return='MARZO';
	break;
	case 4:
		$return='ABRIL';
	break;
	case 5:
		$return='MAYO';
	break;
	case 6:
		$return='JUNIO';
	break;
	case 7:
		$return='JULIO';
	break;
	case 8:
		$return='AGOSTO';
	break;
	case 9:
		$return='SEPTIEMBRE';
	break;
	case 10:
		$return='OCTUBRE';
	break;
	case 11:
		$return='NOVIEMBRE';
	break;
	case 12:
		$return='DICIEMBRE';
	break;
	default :
		$return='VACIO';
				
}

include("tabla_programacion.php");



class MYPDF extends TCPDF {

		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
    }

	// create new PDF document
	$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); //P O L orientacion de la pagina

	  $pdf->SetHeaderData('imbanaco.jpg', '40', 'PLANILLA DE PROGRAMACIÓN DE TURNOS', 'REPORTE DEL MES DE '.$return.'
Dirección Cra 38ª No. 5ª-100');
	 
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	//set margins
	//$pdf->SetMargins(5, 10, 20, 10);


	$pdf->SetMargins(15,35,15);
	//$pdf->SetMargins(PDF_MARGIN_LEFT,15);
	//$pdf->SetMargins(PDF_MARGIN_RIGHT,15);


	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	//$pdf->SetHeaderMargin(5, 10, 20, 10);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//set some language-dependent strings
	$pdf->setLanguageArray($l);

	// ---------------------------------------------------------


	// set font
	$pdf->SetFont('', '',8);




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// Print a table

	// add a page
	$pdf->AddPage();

	//echo $html;die();
	
	
	$pdf->writeHTML($html, true, false, true, false, '');



	// ---------------------------------------------------------

	//Close and output PDF document
	$pdf->Output('reporte.pdf', 'I');

?>