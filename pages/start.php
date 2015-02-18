<div class="col-sm-5">
	<div class="row">
		
		<div class="col-sm-12"><h3>Dina bokade pass</h3>	
		
			<div class="list-group" data-toggle="collapse" data-parent="#menu-bar" href="#collapseThree" >
				 <?php loadBookedEvents(); ?>
			<ul id="collapseThree" class="panel-collapse collapse">
				<p> Här ska det finnas ett script som hämtar event-infon. För tillfället finns det ingen event-info så det blev inget av det.
					Andreas får gärna lägga in Lorem Ipsum och fixa marginalerna och dylikt. För som man kanske ser om jag skriver lite mer text så hamnar den ganska konstigt på högra sidan och så är det tight upptill... Puss! </p>
			</ul>
			</div>
			<h3>Idag på Trappan</h3>
			<div class="list-group">	
				<?php loadTodaysEvents(); ?>
			</div>
			<h3>Lediga pass</h3>
			<div class="list-group" data-toggle="collapse" data-parent="#menu-bar" href="#collapseFive">
				<?php loadAvailableEvents(); ?>
				<ul id="collapseFive" class="panel-collapse collapse">
				<p> Här ska det finnas ett script som hämtar event-infon. För tillfället finns det ingen event-info så det blev inget av det.
					Andreas får gärna lägga in Lorem Ipsum och fixa marginalerna och dylikt. För som man kanske ser om jag skriver lite mer text så hamnar den ganska konstigt på högra sidan och så är det tight upptill... Puss! </p>
			</ul>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-7">
	<h1>Nyhet</h1>
	<?php loadTitle(); ?>
	<?php loadMessage(); //fixa frontend?>
	<?php loadUser(); ?>
	<?php loadDate(); ?>
</div>

