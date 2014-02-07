<?=$this->load->view("includes/header")?>
	<!-- Insert contents here -->
	<?php //echo form_open('home/search_reference'); 
	
	?>
	<form action="<?php echo base_url('index.php/home/search_reference'); ?>" method="get" accept-charset="utf-8">		
		<input type="text" name="keyword" size="50"/>
		<input type="submit" value="Search" /> 
	</form>

		<div id = "search-whole">
				<a href="#" class = "search-toggle">Advanced Search</a>
			<div class = "search-hidden">
				<?php echo form_open('home/advanced_view_reference'); ?>
				
				<table>
					<tr><td><input value="title" type="checkbox" name="projection[]" checked="true">Title:</td><td><input type="text" name="title" size = "30"><br/></td></tr>
					<tr><td><input value="author" type="checkbox" name="projection[]">Author:</td><td><input type="text" name="author" size = "30"><br/></td></tr>
					<tr><td><input value="year_published" type="checkbox" name="projection[]">Year Published:</td><td><input type="text" name="year_published" size = "30"><br/></td></tr>
					<tr><td><input value="publisher" type="checkbox" name="projection[]">Publisher:</td><td><input type="text" name="publisher" size = "30"><br/></td></tr>
					<tr><td><input value="course_code" type="checkbox" name="projection[]">Subject:</td><td><input type="text" name="course_code" size = "30"><br/></td></tr>
					<tr>
						<td>Category:</td>
						<td>
							<select>
								<option value="B">Book</option>
								<option value="J">Journal</option>
								<option value="T">Thesis</option>
								<option value="D">CD</option>
								<option value="C">Catalog</option>
							</select><br/>
						</td>
					</tr>	
				</table>
				<input type="submit" value="Advanced Search" />	
				</form>		
			</div>
		</div>

		<?php 
		echo anchor('email', 'Click for mail').'<br/>';
		echo anchor('report_controller', 'Generate Report');
		?>
	
<?=$this->load->view("includes/footer")?>
