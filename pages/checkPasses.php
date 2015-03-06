<?php
	if(checkAdminAccess())
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-check-square-o fa-fw fa-lg"></span> Checka av pass</h1>
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