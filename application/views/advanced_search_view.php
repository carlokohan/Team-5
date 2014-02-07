<?=$this->load->view("includes/header")?>

<!DOCTYPE html>
<html>
	<head>
		<script src=<?php base_url("themes/jquery-2.0.3.min.js"); ?>></script>		
	</head>
		<body>
		<br/>
		<div id = "search-whole">
			<div class = "search-hidden">
				<?php echo form_open('home/advanced_view_reference'); ?>
				<table>
					<tr><td>|	<input value="title" type="radio" name="projection[]" checked="true">Search by Title |
					<td><input value="author" type="radio" name="projection[]">Search by Author	|
					<td><input value="publisher" type="radio" name="projection[]">Search by Publisher	|
					<td><input value="course_code" type="radio" name="projection[]">Search by Course 	|
					<td><input value="year_published" type="radio" name="projection[]">Search by Year 	|
				</table>
						<input type="text" name="keyword"/>
						<input type="submit" value="Advanced Search"/> 
					</form>	
			</div>
		</div>	
	</body>
</html>
	
<?=$this->load->view("includes/footer")?>