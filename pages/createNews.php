<?php
	if(checkAdminAccess() <= 1)
	{
?>
<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><span class="fa fa-newspaper-o fa-fw fa-lg"></span> Skriv nyhet</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
			<div class="btn-group">
				<a href="?page=createNews" class="btn btn-page-header active"><span class="fa fa-pencil fa-fw fa-lg"></span>Skriv nyhet</a>
				<a href="?page=news" class="btn btn-page-header"><span class="fa fa-newspaper-o fa-fw fa-lg"></span>Nyheter</a>
			</div>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
	<form action="" method="post">
		<label for="title">Titel</label>
		<input type="text" placeholder="Nyhetsbrev Maj" name="title" id="title" required>
		<label for="message">Meddelande</label>
		<textarea rows="7" cols="50" value="" name="message" id="message" maxlength="1500" class="bottom-border" required></textarea>
		<input type="submit" name="submit" value="Skicka nyhet">
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