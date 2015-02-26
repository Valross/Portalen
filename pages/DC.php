<?php
	if(checkAdminAccess())
	{
?>
<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1>DC-Verktyg</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<?php loadAllTools() ?>
		</div>
	</div>
</div>
<?php
	}
	else
	{
		?>
			<script>
				window.location = "?page=start";
				alert("Sluta försöka hacka sidan!")
			</script>
		<?php
	}
?>