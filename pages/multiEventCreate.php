<?php
	if(checkAdminAccess())
	{
?>

<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-calendar fa-fw fa-lg"></span> Multieventskapare
			 - <a href="?page=createEvent"><span class="fa fa-calendar fa-fw fa-lg"></span>Skapa evenemang</a>
			</h1>
		</div>
	</div>
</div> <!-- .row -->

<form action="" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Evenemangsinformation</h3>

			<label for="template">Mall</label>
			<select name="template" id="template" onchange="getTemplate(this.value)">
				<option value="no">Ingen mall</option>
				<?php loadTemplates(); ?>
			</select>
			
			<label for="type">Evenemangstyp</label>
			<select name="type" id="type">
				<option id="typeno" value="no">Välj typ</option>
				<?php loadTypes(); ?>
			</select>

			<label for="day">Dag i veckan</label>
			<select name="day" id="day">
				<option id="monday" value="monday">Måndag</option>
				<option id="tuesday" value="tuesday">Tisdag</option>
				<option id="wednesday" value="wednesday">Onsdag</option>
				<option id="thursday" value="thursday">Torsdag</option>
				<option id="friday" value="friday">Fredag</option>
				<option id="saturday" value="saturday">Lördag</option>
				<option id="sunday" value="sunday">Söndag</option>
			</select>

			<div class="input-group date datetimepicker">
				<label for="start">Från datum</label>
				<input id="start" type="text" name="start" value="<?php echo $dateNoTime; ?>">
		        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
			</div>
				
			<div class="input-group date datetimepicker">
				<label for="end">Till datum</label>
				<input id="end" type="text" name="end" value="<?php echo $dateNoTime; ?>">
				<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
			</div>
			
			<label for="name">Namn</label>
			<input type="text" name="name" id="name">
			<label for="info">Beskrivning</label>
			<textarea rows="6" name="info" id="info" class="bottom-border"></textarea>
			
			<input type="submit" name="submit" value="Skapa evenemang">
		</div> <!-- .white-box -->
	</div> <!-- .col-sm-6 -->	
</div> <!-- .row -->		
</form>
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