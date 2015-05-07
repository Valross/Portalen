<div class="row">
<div class="col-sm-12">
	<div class="page-header">
		<h1><span class="fa fa-table fa-fw fa-lg"></span> Hantera pass för <?php loadTemplateName(); ?>
		 - <a href="?page=manageEventTemplate"><span class="fa fa-table fa-fw fa-lg"></span>Hantera eventmallar</a>
		</h1>
	</div>
</div>
</div> <!-- .row -->

<?php
	if(checkAdminAccess() <= 1)
		loadAll();
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