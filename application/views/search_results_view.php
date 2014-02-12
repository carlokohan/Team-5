<?=$this->load->view("includes/header")?>

		
		<form action="<?php echo base_url('index.php/home/search_reference'); ?>" method="get" accept-charset="utf-8">		
			<input type="text" name="keyword" size="50" value="<?php if(isset($_GET['keyword'])) echo $_GET['keyword']; ?>"/>
			<input type="submit" value="Search" /> 
		</form>
		<div id = "search-whole">
				<a href="#" class = "search-toggle">Advanced Search</a>
			<div class = "search-hidden">
				<form action="<?php echo base_url('index.php/home/advanced_search_reference'); ?>" method="get" accept-charset="utf-8">
				<table>
					<tr>
						<td><input value="title" type="checkbox" name="projection[]" checked="true">Title:</td>
						<td><input type="text" name="title" size = "30" value="<?php if(isset($temparray) && in_array('title',$temparray)) echo $temparrayvalues[array_search('title', $temparray)]?>"><br/></td></tr>
					<tr><td><input value="author" type="checkbox" name="projection[]">Author:</td><td><input type="text" name="author" size = "30" value="<?php if(isset($temparray) && in_array('author',$temparray)) echo $temparrayvalues[array_search('author', $temparray)]?>"><br/></td></tr>
					<tr><td><input value="year_published" type="checkbox" name="projection[]">Year Published:</td><td><input type="text" name="year_published" size = "30" value="<?php if(isset($temparray) && in_array('year_published',$temparray)) echo $temparrayvalues[array_search('year_published', $temparray)]?>"><br/></td></tr>
					<tr><td><input value="publisher" type="checkbox" name="projection[]">Publisher:</td><td><input type="text" name="publisher" size = "30" value="<?php if(isset($temparray) && in_array('publisher',$temparray)) echo $temparrayvalues[array_search('publisher', $temparray)]?>"><br/></td></tr>
					<tr><td><input value="course_code" type="checkbox" name="projection[]">Subject:</td><td><input type="text" name="course_code" size = "30" value="<?php if(isset($temparray) && in_array('course_code',$temparray)) echo $temparrayvalues[array_search('course_code', $temparray)]?>"><br/></td></tr>
					<tr>
						<td>Category:</td>
						<td>
							<select name="reftype">
								<option value="B">Book</option>
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
			</div>
		</div>
		
		<?php 
		echo anchor('home/', '<< Back to Home');
		echo '  '; 
		echo '  ';
		echo anchor('cart_controller/view_cart', 'View Cart');
		//echo anchor($_SERVER['REQUEST_URI'], ' << BACK');
		?>
		<br/>
		<p>
			<?php 
			$current = $_GET['per_page'];
			$offset = $current + 10;
			if($offset > $totalrefmat){
				$offset = ($totalrefmat%10)+$current;
			}
			if ($totalrefmat < 10) {
				$offset = $totalrefmat;
			}
			echo 'Result '.($current+1).' to '.$offset.' of '.$totalrefmat.' reference materials found.';
			?>
		</p>

		<?php
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