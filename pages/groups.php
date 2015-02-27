<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1><span class="fa fa-users fa-fw fa-lg"></span> Lagsidor</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Dina lag</h3>
		<div class="list-group">
			<?php loadMyGroups(); ?>
		</div>
	</div> <!-- .white-box -->
</div> <!-- col-sm-6 -->
<div class="col-sm-6">
	<div class="white-box">
		<h3>Alla lag</h3>
		<div class="list-group">
			<?php loadAllGroups(); ?>
		</div>
	</div>
</div>
</div> <!-- .row -->