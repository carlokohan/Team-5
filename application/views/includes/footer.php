	</body>
	<!-- Link scripts here -->
	<script type = "text/javascript" src="<?php echo base_url().'js/jquery.min.js' ?>">
	</script><script src=<?php echo base_url("themes/jquery-2.0.3.min.js"); ?>></script>
	<script type="text/javascript">
		
		$(document).ready(function() {
			$("#empty").on('click', function(){
				alert("Cart emptied.");
			});
		});

		window.onload = function(){
			searchform = document.getElementById("searchform");
			if (searchform != null) {
				searchform.searchbutton.onclick = validateSearch;
			};
		}

		function validateSearch(){
			str = document.getElementById("keyword").value;
			if (str == "") {
				alert("Type in the search input first.");
				return;
			};
		}
		
		var i = 0;
			$('.search-hidden').hide();
			$('.search-toggle').click(function() {
			    $('.search-hidden').slideToggle();
			    if(i == 0){
					$('.search-toggle').html('Hide Advanced Search');
					i = 1;
				}else{
					 $('.search-toggle').html('Advanced Search');
					 i = 0;
				}
			});

	</script>
	
</html>