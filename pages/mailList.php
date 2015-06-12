<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><span class="fa fa-envelope-o fa-fw fa-lg"></span>Maillista</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
			<div class="btn-group">
				<a href="?page=staffList" class="btn btn-page-header"><span class="fa fa-list fa-fw fa-lg"></span>Personallista</a>
				<a href="?page=mailList" class="btn btn-page-header active"><span class="fa fa-envelope-o fa-fw fa-lg"></span>Maillista</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-7">
		<div class="white-box">
			<p>
				<?php loadList(); ?>
			</p>
		</div>
	</div>
</div>
