<?php
	if(checkAdminAccess() <= 2)
	{
?>
<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><?php loadEventName(); ?></h1>
			<h4>
			<img src="<?php echo loadDAAvatar(); ?>" width="32" height="32" class="img-circle"> <?php loadDAName(); ?></h4>
		</div>
	</div>
	<div class="col-sm-6 page-header-right text-right">
		<?php loadButtons() ?> 
		<a href="?page=browseDANote" class="btn btn-page-header"><i class="fa fa-arrow-circle-left fa-fw"></i> Tillbaka till alla DA-lappar</a>
	</div> <!-- .col-sm-6 -->
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<table class="table table-hover">
		      	<thead>
			        <tr>
			        	<th>Totalt (kr)</th>
			          	<th>Entré (kr)</th>
			          	<th>Bar (kr)</th>
					  	<th>Cash (kr)</th>
					  	<th>Inklick</th>
					  	<th>Gränga</th>
					  	<th>4cl shots</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadDAStats(); ?>

			  	</tbody>
				</table>
			</div> <!-- .white-box -->
		</div> <!-- col-sm-12 -->
	</div> <!-- .row -->
<div class="row">
<?php loadArrangingPartyries(); ?>
<?php loadWorkingPartyries(); ?>
</div> <!-- .row -->
<form action="" method="post" id="da_note_form">
<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Meddelande</h3>
			<p>
			<?php loadDAMessage(); ?>
			</p>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Fixlista</h3>
			<p>
			<?php loadDAFixlist(); ?>
			</p>
		</div>
	</div>
</div> <!-- .row -->
</form>

<div class="row">
	<?php loadWorkSlots(); ?>
</div> <!-- .row -->

<?php loadComments(); ?>

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