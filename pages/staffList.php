<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><span class="fa fa-list fa-fw fa-lg"></span> Personallista
			</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
			<div class="btn-group">
				<a href="?page=staffList" class="btn btn-page-header active"><span class="fa fa-list fa-fw fa-lg"></span>Personallista</a>
				<a href="?page=mailList" class="btn btn-page-header"><span class="fa fa-envelope-o fa-fw fa-lg"></span>Maillista</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>#</th>
			          	<th>Namn</th>
			          	<th>Medlem sedan</th>
			          	<th>Senast inloggad</th>
			          	<th>Jobbade senast</th>
			        </tr>
			    </thead>
				<tbody>
				  	<?php loadStats(); ?>
			  	</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
