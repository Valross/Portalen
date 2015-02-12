<div class="row">	
	<div class="col-sm-6">
		<div class="page-header">
			<h1>Boka pass</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
				<div class="btn-group">
					<button class="btn btn-page-header" data-calendar-view="year">År</button>
					<button class="btn btn-page-header active" data-calendar-view="month">Månad</button>
					<button class="btn btn-page-header" data-calendar-view="week">Vecka</button>
					<button class="btn btn-page-header" data-calendar-view="day">Dag</button>
				</div>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">

<div class="col-sm-4">
	<div class="white-box">
	<p>Oklart just nu vad som ska ligga här. Kanske "Dina pass", "kommande pass du kan boka dig på i dina lag" eller liknande. vi får se.</p>
	</div>
</div>
<div class="col-sm-8">
	<div class="white-box calendar-box">
		<div class="calendar-top">
			<h3></h3>
			<div class="pull-right form-inline">
			<div class="btn-group">
				<button class="btn btn-default" data-calendar-nav="prev"><i class="fa fa-angle-left fa-lg fa-margin-right"></i> Föregående</button>
				<button class="btn btn-default" data-calendar-nav="today">Idag</button>
				<button class="btn btn-default" data-calendar-nav="next">Nästa <i class="fa fa-angle-right fa-lg fa-margin-left"></i></button>
			</div>
			</div>
		</div>
			
			<div id="calendar"></div>
			
			<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
			<script type="text/javascript" src="js/underscore-min.js"></script>
			<script type="text/javascript" src="js/calendar.js"></script>
    		<script type="text/javascript">
        		var calendar = $("#calendar").calendar(
	            {
	                tmpl_path: "/tmpls/",
	                events_source: '/php/events.php'
	            });         
   			</script>
		
	</div> <!-- .white-box -->
</div> <!-- .col-sm-8 -->
</div>