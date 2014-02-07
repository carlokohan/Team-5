<?=$this->load->view("includes/header")?>

		<?php 
		echo anchor('home/', '<< Back to Home');
		echo '  '; 
		?>
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
		echo '  ';
		echo anchor('cart_controller/view_cart', 'View Cart');
		echo '<br/>';

		echo $this->pagination->create_links();
		
		if($rows != null){
			foreach ($rows as $r) {
				echo '<h5><p>'.$r->title.'</h5>';
				echo '<p> Author: '.$r->author.'.<br/>';
				echo ' Year of Publication : '.$r->publication_year.'. Publisher: '. $r->publisher.'</p>';
				echo anchor('home/view_reference/'.$r->id, 'View Book');
				echo ' ';
				echo anchor('cart_controller/add_to_cart/'.$r->id, 'Add to Cart');
				echo ' '."<a href='#' >Reserve</a>";
			}
		}
		else{
			echo '<p>No reference material found for that keyword.</p>';
		}
		?>

		</div>
	</body>
</html>

<?=$this->load->view("includes/footer")?>