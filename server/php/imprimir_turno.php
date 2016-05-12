<?php session_start();
require_once('class_turnos.php');
require_once('../librerias/tcpdf/config/lang/spa.php');
require_once('../librerias/tcpdf/tcpdf.php');

$cod_epl=$_SESSION['cod_epl'];

$obj=new turnos();
					
	
	
	$obj2=new turnos();
	$lista2=$obj2->turnos_creados($cod_epl);
	$lista=$obj->turnos_predeterminados();
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

	  $pdf->SetHeaderData('imbanaco.jpg', '40', 'PLANILLA DE TURNOS', 'REPORTE DE TURNOS
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
	ini_set('memory_limit', '-1');

	// set font
	$pdf->SetFont('', '',10);

	set_time_limit(0);


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// Print a table

	// add a page
	$pdf->AddPage();

	$html = '<table width="100%">
			<tr> 
			<td>';
	$html .= '<table border="1" width="300px">
				<tr>
					<td align="center"><strong>Cod Turno</strong></td>
					<td align="center"><strong>Hora</strong></td>
					<td align="center"><strong>Hora Inicial</strong></td>
					<td align="center"><strong>Hora Final</strong></td>
				</tr>';
			for($v=0;$v<count($lista);$v++){
			$html.='<tr>
					   <td align="center">'.@$lista[$v]['codigo_turno'].'</td>
					   <td align="center">'.@$lista[$v]['horas'].'</td>
					   <td align="center">'.@$lista[$v]['hora_ini'].':00</td>
					   <td align="center">'.@$lista[$v]['hora_fin'].':00</td> 
				  </tr>';
			}
	$html.='</table>
			</td>
			<td>';
	$html .= '<table border="1" width="300px">
				<tr>
					<td align="center"><strong>Cod Turno</strong></td>
					<td align="center"><strong>Hora</strong></td>
					<td align="center"><strong>Hora Inicial</strong></td>
					<td align="center"><strong>Hora Final</strong></td>
				</tr>';
			
			for($p=0;$p<count($lista2);$p++){
			$html.='<tr>
					   <td align="center">'.@$lista2[$p]['codigo_turno'].'</td>
					   <td align="center">'.@$lista2[$p]['horas'].'</td>
					   <td align="center">'.@$lista2[$p]['hora_ini'].':00</td>
					   <td align="center">'.@$lista2[$p]['hora_fin'].':00</td> 
				  </tr>';
			}
			
	$html.='</table>
			</td>		
			</tr></table>';

	// output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');

	// reset pointer to the last page
	$pdf->lastPage();

	// ---------------------------------------------------------

	//Close and output PDF document
	$pdf->Output('reporte.pdf', 'I');

?>