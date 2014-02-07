	<?php
		
		
require('fpdf/code128.php');
/*
				$choice = $_POST["print_by"];
				if (strcmp($choice,"daily")==0) {
					//if the choice is by day
					$query_result = $this->db->query("Select title, author, course_code, times_borrowed from transactions where date_borrowed like ");	
				} else if (strcmp($choice,"weekly")==0) {
					//if the choice is by week
					$query_result = $this->db->query("Select title, author, course_code, times_borrowed from transactions where date_borrowed like ");
				} else if (strcmp($choice,"monthly")==0) {
					//if the choice is by month
					$query_result = $this->db->query("Select title, author, course_code, times_borrowed from transactions where date_borrowed like ");
				}
			*/
				
				//test PDF
				$pdf = new PDF_Code128();
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',16);
				$pdf->Cell(40,10,'Hello World!');
				$pdf->Output();

		
	?>

