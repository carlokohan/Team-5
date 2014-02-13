<?php
<<<<<<< HEAD
class PDF extends FPDF{
	function Header(){
		// Logo
	    $this->Image('img/ics_logo.jpg',15,7,-120);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(50,25,'OnLib: Institute of Computer Science Library Log',0,1,'C');
	    // Line break
	    $this->Ln(20);
	}
}
	$pdf = new PDF();
	$pdf->Header();	
=======
	/*	
	function Header(){
		$pdf->Image('ics_logo.jpg',10,6,30);
		$pdf->SetFont('Arial', 'B',15);
		$pdf->Cell(70);
		$pdf->Cell(30,10,'OnLib: Institute of Computer Science Library Log',1,0,'C');
		$pdf->Ln(20);
	}
	*/
	$pdf = new FPDF();
	
>>>>>>> 34043240dd6e0e434b1df41c6bfa892cd8cefe0e
	//column headers
	$header = array('Ref. ID', 'Borrower ID', 'Date Waitlisted', 'Date Reserved', 'Date Borrowed', 'Date Returned');
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);

	// insert header to table
	foreach($header as $col){
		$pdf->Cell(30,7,$col,1);
	}
	$pdf->Ln();

	// insert data to table
	foreach($result as $row){
		foreach($row as $col)
			$pdf->Cell(30,6,$col,1);
		$pdf->Ln();
	}

	$pdf->SetFont('Arial','',10);
	foreach($mostBorrowed as $row){
		$pdf->Cell(0,50,"Most Borrowed: ".$row->title.'.  Times borrowed: '.$row->times_borrowed.'. Course code: '.strtoupper($row->course_code),0,1);
	}
	$pdf->Output();

?>

