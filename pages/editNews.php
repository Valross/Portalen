<?php
	if(checkAdminAccess() <= 1)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-newspaper-o fa-fw fa-lg"></span> Uppdatera nyhet</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
	<form action="" method="post">
		<?php loadFormContent() ?>
	</form>
	</div> <!-- .white-box -->
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