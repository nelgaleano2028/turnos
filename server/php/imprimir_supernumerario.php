<?php
require_once('class_supernumerario.php');
require_once('../librerias/tcpdf/config/lang/spa.php');
require_once('../librerias/tcpdf/tcpdf.php');

$obj=new supernumerario();				
$lista=$obj->get_supernumerarios("");
	
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

	  $pdf->SetHeaderData('imbanaco.jpg', '40', 'PLANILLA DE SUPERNUMERARIOS', 'REPORTE DE SUPERNUMERARIOS
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
						<th align="center" style="font-weight:bold">Cedula</th>
						<th align="center" style="font-weight:bold">Nombre Completo</th>
						<th align="center" style="font-weight:bold">Centro de Costo</th>
						<th align="center" style="font-weight:bold">Cargo</th>
						<th align="center" style="font-weight:bold">Estado</th>
					</tr>
				</thead>
				<tbody>
				';
			for($i=0;$i<count($lista);$i++){
			$html.='
				    <tr>
					   <td align="center" >'.$lista[$i]['cedula'].'</td>
					   <td align="center">'.$lista[$i]['nombre_completo'].'</td>
					   <td align="center">'.$lista[$i]['centro_costo'].'</td>
					   <td align="center">'.$lista[$i]['cargo'].'</td>
					   <td align="center">'.$lista[$i]['estado'].'</td>
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