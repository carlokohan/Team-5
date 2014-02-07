
	<?=$loginMessage?>
	<form action="<?=base_url().'index.php/login'?>" method='post'>
		Username: <input type='text' name='username' required/>
		Password: <input type='password' name='password' required/>
		<input type='submit' name='submit' value='submit'/>
	</form>

<?=$this->load->view("includes/footer")?>