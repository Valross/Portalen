<?php
	if(checkAdminAccess() <= 2)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-pencil fa-fw fa-lg"></span> DA-lapp - Kommentarer om Festerier</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<form action="" method="post">
		<?php loadArrangingPartyries(); ?>
		<?php loadWorkingPartyries(); ?>
	<input type="submit" name="submit" value="Skapa DA-lapp">
	</form>
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