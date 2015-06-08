<?php
	if(checkAdminAccess() <= 3)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-pencil fa-fw fa-lg"></span> Skriv Hovis-lapp</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<form action="" method="post">
		<div class="white-box">
			<label for="event">Evenemang</label>
			<select name="event" id="event" class="bottom-border">
				<option id="typeno" value="typeno">Välj sittning</option>
				<?php loadMyHeadWaiterEvents(); ?>
			</select>

			<label for="n_of_sitting">Antal Sittande</label>
			<input type="number" placeholder="112" name="n_of_sitting" id="n_of_sitting" min="0" max="500">
			<label for="n_of_waiting_organizers">Antal serveringspersonal från arrangörernas sida</label>
			<input type="number" placeholder="6" name="n_of_waiting_organizers" id="n_of_waiting_organizers" min="0" max="20">
			<label for="n_of_waiting_stair">Antal serveringspersonal från Trappan</label>
			<input type="number" placeholder="2" name="n_of_waiting_stair" id="n_of_waiting_stair" min="0" max="15">
			<label for="food">Hur var maten?</label>
			<textarea rows="3" cols="50" placeholder="Björn knows his shit!!" maxlength="400"
				name="food" id="food"></textarea>
			<label for="invoice_drinks">Dryckesfakturering</label>
			<textarea rows="3" cols="50" placeholder="13 läsk                37 Gränga                69 Briska" maxlength="400"
				name="invoice_drinks" id="invoice_drinks"></textarea>
			<label for="toast">Hur skötte sig Toast?</label>
			<textarea rows="3" cols="50" placeholder="Oförsiktiga med utrustningen men nämnde nödutgångarna!" maxlength="400"
				name="toast" id="toast"></textarea>
			<label for="organizers">Hur skötte sig arrangörerna och vilka var de?</label>
			<textarea rows="3" cols="50" placeholder="De glömde nämna ingen mat i gyckel..." maxlength="400"
				name="organizers" id="organizers"></textarea>
			<label for="stair_staff">Hur jobbade Trappans personal? (Bar/Servering)</label>
			<textarea rows="3" cols="50" placeholder="Baren svinnade som fan, men serveringen var KUNG" maxlength="400"
				name="stair_staff" id="stair_staff"></textarea>
			<label for="organizers_staff">Hur jobbade arrangörernas serveringspersonal?</label>
			<textarea rows="3" cols="50" placeholder="Det viktiga är att man försöker" maxlength="400"
				name="organizers_staff" id="organizers_staff"></textarea>
			<label for="swine">Svinn</label>
			<textarea rows="3" cols="50" placeholder="2cl Sourz Raspberry - dålig bartender" maxlength="400"
				name="swine" id="swine"></textarea>
			<label for="fixlist">Fixlist</label>
			<textarea rows="6" cols="50" placeholder="Tändarvätskan är typ slut. @Hovisansvarig" maxlength="4000"
				name="fixlist" id="fixlist"></textarea>
			<label for="message">Händelser</label>
			<textarea rows="12" cols="50" placeholder="Det var en lugn sittning, inte GaSSKAT 2014" maxlength="6000"
				name="message" id="message" class="bottom-border"></textarea>

			<input type="submit" name="submit" value="Skapa Hovis-lapp">
		</div> <!-- .white-box -->
	</form>
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