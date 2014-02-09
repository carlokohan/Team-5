<?=$this->load->view("includes/header")?>

	<?php 
	if($rows != null){
		foreach ($rows as $r) {
			echo anchor('home/search_reference', '<< Back to home');
			echo '<h5><p>'.$r->title.'</h5>';
			echo '<p> Author: '.$r->author.'.';
			echo '<p> Year of Publication: '.$r->publication_year.'</p>';
			echo '<p> Description: '.$r->description.'</p>';
			echo '<p> Publisher: '.$r->publisher.'</p>';
			echo '<p> Course Code: '.strtoupper($r->course_code).'</p>';
			echo '<p> Total Available:  '.$r->total_available.'/'.$r->total_stock.'</p>';
			echo '<p> Times Borrowed: '.$r->times_borrowed.'</p>';
			echo anchor('home/load_advanced_search', 'Advanced Search >>');
			echo ' ';
			echo anchor('cart_controller/add_to_cart/'.$r->id, 'Add to Cart');	
		}
	}
	else{
		echo '<p>No reference material found for that keyword.</p>';
	}
	?>

<?=$this->load->view("includes/footer")?>