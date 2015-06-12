<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><span class="fa fa-newspaper-o fa-fw"></span> Nyheter</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
			<div class="btn-group">
				<a href="?page=createNews" class="btn btn-page-header"><span class="fa fa-pencil fa-fw fa-lg"></span>Skriv nyhet</a>
				<a href="?page=news" class="btn btn-page-header active"><span class="fa fa-newspaper-o fa-fw fa-lg"></span>Nyheter</a>
			</div>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	
	<?php loadAll(); ?>
	
</div>