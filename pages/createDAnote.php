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
			<select name="event" id="event">
				<option id="typeno" value="typeno">Välj event</option>
				<?php loadMyDAEvents(); ?>
			</select>
			<h2>Arrangerande festeri</h2>
					<?php loadPartyries(); ?>
		</div>

		<div class="white-box">
			<h2>Arbetande festeri</h2>
					<?php loadPartyries(); ?>
		</div> <!-- .white-box -->

		<div class="white-box">
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
		</div> <!-- .white-box -->
	</form>
</div>
</div>