<?php
	if(checkAdminAccess())
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Checka pass</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<p>Välj evenemang</p>
			<?php loadMyDAEvents(); ?>
	</div> <!-- .white-box -->
</div>
</div>

<?php loadWorkSlots(); ?>
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