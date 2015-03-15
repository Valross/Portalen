<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1><span class="fa fa-trophy fa-fw"></span><a href="?page=achievements">Achievements</a></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-7">
		<div class="white-box">
			<?php loadAchievement() ?>
		</div>
	</div>
</div>

<?php 
	if(anyoneUnlockedThisAchievement())
	{
?>
<div class="row">
	<div class="col-sm-7">
		<div class="white-box">
		<table class="table table-hover">
	      	<thead>
		        <tr>
		          	<th>#</th>
		          	<th>Namn</th>
				  	<th>Datum</th>
		        </tr>
		    </thead>
			<tbody>

			  	<?php loadPeopleWhoUnlockedThisAchievement() ?>

		  	</tbody>
		</table>
		</div>
	</div>
</div>
<?php
	}
?>