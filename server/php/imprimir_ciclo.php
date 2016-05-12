<?php session_start();
require_once('class_ciclos.php');
require_once('../librerias/tcpdf/config/lang/spa.php');
require_once('../librerias/tcpdf/tcpdf.php');

$cod_epl=$_SESSION['cod_epl'];

$obj=new ciclos();
					
	$lista=$obj->ciclos_query($cod_epl);
	
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

	  $pdf->SetHeaderData('imbanaco.jpg', '40', 'PLANILLA DE CICLOS', 'REPORTE DE CICLOS
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
						<th scope="col" width="100px" align="center"><strong>Cod Ciclo</strong></th>
						<th scope="col" width="28px" align="center"><strong>Dias</strong></th>
						<th scope="col" width="45px" align="center"><strong>L</strong></th>
						<th scope="col" width="45px" align="center"><strong>M</strong></th>
						<th scope="col" width="45px" align="center"><strong>M</strong></th>
						<th scope="col" width="45px" align="center"><strong>J</strong></th>
						<th scope="col" width="45px" align="center"><strong>V</strong></th>
						<th scope="col" width="45px" align="center"><strong>S</strong></th>
						<th scope="col" width="45px" align="center"><strong>D</strong></th>						
						<th scope="col" width="45px" align="center"><strong>Horas Ciclo</strong></th>
						<th scope="col"width="170px" align="center"><strong>Observacion</strong></th>
					</tr>
				</thead>
				<tbody>
				';
			for($i=0;$i<count($lista);$i++){
			$html.='
				    <tr>
					   <td align="center" width="100px">'.$lista[$i]['codigo_ciclo'].'</td>
					   <td align="center"  width="28px">'.$lista[$i]['dias'].'</td>
					   <td align="center" width="45px">'.$lista[$i]['uno'].'</td>
					   <td align="center" width="45px">'.$lista[$i]['dos'].'</td>
					   <td align="center" width="45px">'.$lista[$i]['tres'].'</td>
					   <td align="center" width="45px">'.$lista[$i]['cuatro'].'</td>
					   <td align="center" width="45px">'.$lista[$i]['cinco'].'</td>
					   <td align="center" width="45px">'.$lista[$i]['seis'].'</td>
					   <td align="center" width="45px">'.$lista[$i]['siete'].'</td>
					   <td align="center" width="45px">'.number_format(@$lista[$i]['horas'],0,",",".").'</td>
					   <td align="center" width="170px">'.$lista[$i]['observacion'].'</td> 
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