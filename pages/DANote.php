<?php
	if(checkAdminAccess() <= 2)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><?php loadEventName(); ?></h1>
			<h4>
			<img src="<?php echo loadDAAvatar(); ?>" width="32" height="32" class="img-circle"> <?php loadDAName(); ?></h4>
		</div>
	</div>
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

<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-comments fa-fw fa-lg"></span> Kommentarer</h1>
		</div>
	</div>
</div> <!-- .row -->


<div class="row">
<?php loadComments(); ?>


<form action="" method="post">
	<div class="col-sm-5">
		<div class="white-box">
			<h3>Skriv kommentar</h3>
			<label for="comment">Kommentar</label>
			<textarea rows="6" cols="50" placeholder="Fan panten är ju inte alls snygg!" name="comment" id="comment" class="bottom-border"></textarea>

			<input type="submit" name="submit" value="Skicka kommentar">
		</div> <!-- .white-box -->
	</div>
</form>

</div> <!-- .row -->


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