<?=$this->load->view("includes/header")?>
	<?php echo form_open('email/email_all') ;?>
		<h5>Type your message here. Make sure that your message is correct.</h5>
		<textarea name="message">

		</textarea>
		<input type="submit" value="Send to all users">
	</form>
<?=$this->load->view("includes/footer")?>