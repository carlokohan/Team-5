<?=$this->load->view("includes/header")?>

	<?php 
		echo anchor('home/', '<< Back to Home');
		echo '  '; 
	?>
	<h1>Advanced Search</h1>
	<form action="<?php echo base_url('index.php/home/advanced_search_reference'); ?>" method="get" accept-charset="utf-8"  >
				<table>
					<tr><td><input value="title" type="checkbox" name="projection[]" checked="true">Title:</td><td><input type="text" name="title" size = "30"><br/></td></tr>
					<tr><td><input value="author" type="checkbox" name="projection[]">Author:</td><td><input type="text" name="author" size = "30"><br/></td></tr>
					<tr><td><input value="year_published" type="checkbox" name="projection[]">Year Published:</td><td><input type="text" name="year_published" size = "30"><br/></td></tr>
					<tr><td><input value="publisher" type="checkbox" name="projection[]">Publisher:</td><td><input type="text" name="publisher" size = "30"><br/></td></tr>
					<tr><td><input value="course_code" type="checkbox" name="projection[]">Subject:</td><td><input type="text" name="course_code" size = "30" patter="^cs [0-9]{2,3}$"><br/></td></tr>
					<tr>
						<td>Category:</td>
						<td>
							<select name="category">
								<option value="B" >Book</option>
								<option value="J">Journal</option>
								<option value="T">Thesis</option>
								<option value="D">CD</option>
								<option value="C">Catalog</option>
							</select><br/>
						</td>
					</tr>
					<tr>
						<td><input type="radio" name="sort" value="sortalpha"checked="true" />Sort from A to Z</td>
						<td><input type="radio" name="sort" value="sortbeta" />Sort from Z to A</td>
					</tr>	
					<tr>
						<td><input type="radio" name="sort" value="sortyear" />Sort by year</td>
						<td><input type="radio" name="sort" value="sortauthor" />Sort by author(A-Z)</td>
					</tr>	
				</table>
				<input type="submit" value="Advanced Search" />	
				</form>		

<?=$this->load->view("includes/footer")?>