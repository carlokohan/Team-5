<?=$this->load->view("includes/header")?>

	<?php echo form_open('report_controller/view_report') ;?>
		<select name="print_by">
			<option value="daily">Daily Report</option>
			<option value="weekly">Weekly Report</option>
			<option value="monthly">Monthly Report</option>
		</select>
		<input type="submit">
	</form>

<?=$this->load->view("includes/footer")?>