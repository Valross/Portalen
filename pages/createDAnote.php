<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Skapa ny DA-lapp</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<form action="" method="post">
		<div class="white-box">
			<label for="event">Evenemang</label>
			<select name="event" id="event" class="bottom-border">
				<option id="typeno" value="typeno">Välj event</option>
				<?php loadMyDAEvents(); ?>
			</select>
			<h4>Arrangerande festeri</h4>
					<?php loadArrangingPartyries(); ?>

			<h4>Arbetande festeri</h4>
					<?php loadWorkingPartyries(); ?>

			<label for="salesEntry">Försäljning entré</label>
			<input type="text" placeholder="9001" name="salesEntry" id="salesEntry">
			<label for="salesBar">Försäljning bar</label>
			<input type="text" placeholder="80085" name="salesBar" id="salesBar">
			<label for="cash">Varav cash</label>
			<input type="text" placeholder="1337" name="cash" id="cash">
			<label for="nOfPeople">Inklick</label>
			<input type="text" placeholder="69" name="nOfPeople" id="nOfPeople">
			<label for="salesSpenta">Antal sålda Spenta</label>
			<input type="text" placeholder="420" name="salesSpenta" id="salesSpenta">
			<label for="message">Händelser</label>
			<textarea rows="6" cols="50" placeholder="Festeristerna jobbade på bra" name="message" id="message" class="bottom-border"></textarea>

			<input type="submit" name="submit" value="Skapa DA-lapp">
		</div> <!-- .white-box -->
	</form>
</div>
</div>