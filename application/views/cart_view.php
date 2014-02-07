<?php $this->load->view("includes/header")?>

<p>
<?php
 echo '<a href="'.base_url('index.php/cart_controller/empty_cart')."\" id='empty'>Empty Cart </a>";
?>
</p>
<?php if($this->cart->total() > 0 ): ?>
<table  border="1">
<?php echo form_open('cart_controller/remove_selected'); ?>
<tr>
  <th><input type="submit" value="Remove Checked items" onclick="javascript:return confirm('Are you sure?');"></th>
  <th>Title</th>
  <th>Year</th>
  <th>Author</th>
  <th>Course code</th>
</tr>

<?php $i = 1; ?>

<?php foreach ($this->cart->contents() as $items): ?>

	<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>

	<tr>
		<!-- checkbox -->
		
		<td>
			<?php 
				$total = $this->cart->total();
				$checkboxname = "cart".$i;
				echo "<input type='checkbox' name='{$checkboxname}' value='{$items['rowid']}' />" ; 

			?>
		</td>
			<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
			<p><?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
					<td>
						<?php echo $option_value; ?><br />
					</td>
				<?php endforeach; ?>
				<td>
					<a href="#">Reserve</a>
				</td>
			</p>
			<?php endif; ?>

			</label>

	  <!--
	  <td style="text-align:right"><?php echo $this->cart->format_number($items['price']); ?></td>
	  <td style="text-align:right">$<?php echo $this->cart->format_number($items['subtotal']); ?></td>
	-->
	</tr>

<?php $i++; ?>

<?php endforeach; ?>
<!--
<tr>
  <td colspan="2"> </td>
  <td class="right"><strong>Total</strong></td>
  <td class="right">$<?php echo $this->cart->format_number($this->cart->total()); ?></td>
</tr>
-->
</form>
</table>
<?php else: ?>
	<?php echo 'Cart is Empty'; ?>
<?php endif; ?>