<?php
	if(checkAdminAccess() <= 2)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-pencil fa-fw fa-lg"></span> Skriv DA-lapp</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<form action="" method="post">
		<div class="white-box">
			<label for="event">Evenemang</label>
			<select name="event" id="event">
				<option id="typeno" value="typeno">Välj event</option>
				<?php loadMyDAEvents(); ?>
			</select>
			<div class="checkbox-wrapper">
			<h4>Arrangerande festeri</h4>
					<?php loadArrangingPartyries(); ?>
			</div>
			<div class="checkbox-wrapper">
			<h4>Arbetande festeri</h4>
					<?php loadWorkingPartyries(); ?>
			</div>
			<label for="salesTotal">Försäljning totalt</label>
			<input type="number" placeholder="89086" name="salesTotal" id="salesTotal" min="0" max="700000">
			<label for="salesEntry">Försäljning entré</label>
			<input type="number" placeholder="9001" name="salesEntry" id="salesEntry" min="0" max="200000">
			<label for="salesBar">Försäljning bar</label>
			<input type="number" placeholder="80085" name="salesBar" id="salesBar" min="0" max="500000">
			<label for="cash">Varav cash</label>
			<input type="number" placeholder="1337" name="cash" id="cash" min="0" max="200000">
			<label for="nOfPeople">Inklick</label>
			<input type="number" placeholder="69" name="nOfPeople" id="nOfPeople" min="0" max="2000">
			<label for="salesSpenta">Antal sålda Spenta</label>
			<input type="number" placeholder="420" name="salesSpenta" id="salesSpenta" min="0" max="2000">
			<label for="salesShots">Antal sålda 4cl shots</label>
			<input type="number" placeholder="911" name="salesShots" id="salesShots" min="0" max="1500">
			<label for="fixlist">Fixlista</label>
			<textarea rows="6" cols="50" placeholder="Svarta sopsäckar är slut @Piia @Janne" maxlength="4000"
				name="fixlist" id="fixlist"></textarea>
			<label for="message">Händelser</label>
			<textarea rows="16" cols="50" placeholder="Festeristerna jobbade på bra" maxlength="6000"
				name="message" id="message" class="bottom-border"></textarea>

			<input type="submit" name="submit" value="Skapa DA-lapp">
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