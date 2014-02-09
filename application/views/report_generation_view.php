
<?=$this->load->view("includes/header")?>

<!DOCTYPE HTML>
<head>
<title>Generate Report</title>
</head>
<body>
	<?php echo form_open('report_controller/view_report') ;?>
		<select name="print_by">
			<option value="daily">Daily Report</option>
			<option value="weekly">Weekly Report</option>
			<option value="monthly">Monthly Report</option>
		</select>
		<input type="submit">
	</form>
</body>

<?=$this->load->view("includes/footer")?>