<?php
require_once("class_supernumerario.php");
require_once('../librerias/tcpdf/config/lang/spa.php');
require_once('../librerias/tcpdf/tcpdf.php');


	$obj=new supernumerario();				
	$lista=$obj->get_super_nov();
	
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
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	  $pdf->SetHeaderData('imbanaco.jpg', '40', 'PLANILLA DE MOVIMIENTOS DE SUPERNUMERARIOS', 'REPORTE DE MOVIMIENTOS DE SUPERNMERARIOS
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
	$pdf->SetFont('', '',10);




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// Print a table

	// add a page
	$pdf->AddPage();

	$html = '<table border="1" >
				<thead>
					<tr>
				
				<td  align="center">Nombre</td>
				<td  align="center">Area</td>
				<td  align="center">Fecha ing</td>
				<td  align="center">Supernumerario</td>
				<td  align="center">Tipo de Baja</td>
				<td  align="center">Inicio</td>
				<td  align="center">Fin</td>
				<td  align="center">Jefe</td>
				<td  align="center">Observaciones</td>
							
				</tr>
				</thead>
				<tbody>
				';
			for($j=0;$j<count($lista);$j++){
			$html.='
				    <tr>
								<td>'.@$lista[$j]['reemplazo'].'</td>
								<td>'.@$lista[$j]['area'].'</td>
								<td>'.@$lista[$j]['ingreso'].'</td>
								<td>'.@$lista[$j]['supernumerario'].'</td>
								<td>'.@$lista[$j]['baja'].'</td>
								<td>'.@$lista[$j]['fec_ini'].'</td>
								<td>'.@$lista[$j]['fec_fin'].'</td>
								<td>'.@$lista[$j]['jefe'].'</td>
								<td>'.@$lista[$j]['observaciones'].'</td>
							</tr>';
			}
	$html.='</tbody>
			</table>';

		// var_dump($html);die("erert");
	// output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');



	// ---------------------------------------------------------

	//Close and output PDF document
	$pdf->Output('reporte.pdf', 'I');
	
	 

?>