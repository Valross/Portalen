<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1> 
				<?php loadEventName() ?> 
			</h1>
		</div>
	</div>
	<div class="col-sm-4 page-header-right text-right">
		<?php loadButtons() ?> 
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-5">
	<div class="white-box">
		<h3>Evenemangsinformation</h3>
		<table class="basic-table">
			<?php loadEventDescription() ?>
		</table>
		
		</div> <!-- .white-box -->
	</div> <!-- .col-sm-6 -->
<div class="col-sm-7">
	<div class="white-box">
		<h3>Pass</h3>

		<div class="list-group">
			<?php loadWorkSlots() ?>
		</div>

		</div> <!-- .white-box -->
		
		<?php
			if(checkAdminAccess() <= 1)
			{
		?>
		<div class="white-box">
			<h3>Lägg till pass</h3>
		<form action="" method="post">
			<label for="group">Typ av pass</label>
			<select id="group" name="group">
				<?php loadGroups(); ?>
			</select>
			<label for="amount">Antal pass</label>
			<input type="number" id="amount" name="amount" value="1" class="bottom-border">
			<input type="submit" name="addSlot" value="Lägg till pass">
		</form>
		</div>
		<?php
			}
		?>
		
	</div> <!-- .col-sm-6 -->
</div> <!-- .row -->

<?php loadComments() ?>