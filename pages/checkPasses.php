<?php
	if(checkAdminAccess() <= 2)
	{
?>
<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><span class="fa fa-check-square-o fa-fw fa-lg"></span> Checka pass
			</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
				<div class="btn-group">
					<a href="?page=checkPasses" class="btn btn-page-header active"><i class="fa fa-check-square-o fa-fw fa-lg"></i> Checka pass</a>
					<a href="?page=checkUncheckedPasses" class="btn btn-page-header"><i class="fa fa-square-o fa-fw fa-lg"></i> Ocheckade pass</a>
					<a href="?page=checkPassesAllEvents" class="btn btn-page-header">Gamla pass</a>
				</div>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Välj evenemang</h3>
		<div class="list-group">
			<?php loadMyDAEvents(); ?>
		</div>
	</div> <!-- .white-box -->
</div>

<?php loadWorkSlots(); ?>

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