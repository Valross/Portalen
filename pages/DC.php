<?php
	if(checkAdminAccess() <= 1)
	{
?>
<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1><span class="fa fa-gavel fa-fw fa-lg"></span> DC-Verktyg</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<div class="list-group">
			<?php loadAllTools() ?>
			</div>
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