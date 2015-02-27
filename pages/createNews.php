<?php
	if(checkAdminAccess())
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Skapa nyhet</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
	<form action="" method="post">
		<label for="title">Titel</label>
		<input type="text" placeholder="Nyhetsbrev Maj" name="title" id="title">
		<label for="message">Meddelande</label>
		<textarea rows="7" cols="50" value="" name="message" id="message" maxlength="1500" class="bottom-border"></textarea>
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