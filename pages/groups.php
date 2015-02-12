<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1>Lagsidor</h1>
		</div>
	</div>
	<div class="col-sm-4 text-right page-header-right">
		<select class="form-control">
			<option id="typeno" value="no">Hoppa till lag</option>
		    <?php loadAllGroupsOption(); ?>
		</select>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Dina lag</h3>
		<?php loadMyGroups(); ?>
	</div> <!-- .white-box -->
</div> <!-- col-sm-6 -->
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Alla lag</h3>
			<?php loadAllGroups(); ?>
		</div>
	</div>
</div> <!-- .row -->