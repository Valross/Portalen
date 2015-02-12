<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Skapa ny DA-lapp</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
	<form action="" method="post">
		<label for="event">Evenemangstyp</label>
			<select name="event" id="event">
				<option id="typeno" value="typeno">Välj event</option>
				<?php loadMyDAEvents(); ?>
			</select>

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
		<input type="text" placeholder="Festeristerna jobbade på bra" name="message" id="message" class="border-bottom">
		<input type="submit" name="submit" value="Skapa DA-lapp">
	</form>
	</div> <!-- .white-box -->
</div>
</div>