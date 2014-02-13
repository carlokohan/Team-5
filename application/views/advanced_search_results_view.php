<?=$this->load->view("includes/header")?>

	<?php 
	if($rows != null){
	?>
		<?php foreach ($rows as $r): ?>
			<h5><p>Title: <?php echo $r->title; ?></p></h5>
			<h5><p>Author: <?php echo $r->author; ?></p></h5>
			<h5><p>Year of Publication: <?php echo $r->publication_year; ?></p></h5>
			<h5><p>Description: <?php echo $r->description; ?></p></h5>
			<h5><p>Publisher: <?php echo $r->publisher; ?></p></h5>
			<h5><p>Course Code: <?php echo strtoupper($r->course_code); ?></p></h5>
			<h5><p>Total Available: <?php echo $r->total_available.'/'.$r->total_stock; ?></p></h5>
			<h5><p>Times Borrowed: <?php echo $r->times_borrowed; ?></p></h5>

			<?php echo anchor('home', '<< Back'); ?>
			<?php echo " <a href='#' > Add to cart</a>"; ?>	
			<?php endforeach; ?>
	<?php else:?>
		<p>No reference material found for that keyword.</p>
	<?php endif; ?>

<?=$this->load->view("includes/footer")?>
