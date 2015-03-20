<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>
				<span class="fa fa-ellipsis-v fa-fw fa-lg"></span> Punkter
				- <?php loadGroupName(); ?>
				- <?php loadProtocolLink(); ?>
			</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<?php loadComments(); ?>

<form action="" method="post">
	<div class="col-sm-5">
		<div class="white-box">
			<h3>Skriv punkt</h3>
			<label for="comment">Punkt</label>
			<textarea rows="3" cols="50" placeholder="*De där jävla festeristerna" name="comment" id="comment" class="bottom-border"></textarea>

			<input type="submit" name="submit" value="Skicka">
		</div> <!-- .white-box -->
	</div>
</form>
</div> <!-- .row -->