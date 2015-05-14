<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1> 
				<?php loadEventName() ?> 
			</h1>
		</div>
	</div>
	<div class="col-sm-4 page-header-right text-right">
		<?php
		$da_note = DBQuery::sql("SELECT event_id FROM da_note
								WHERE event_id = '$event_id'");

		$headwaiter_note = DBQuery::sql("SELECT event_id FROM headwaiter_note
								WHERE event_id = '$event_id'");

		if(checkAdminAccess() <= 1 && $event_name[0]['event_type_id'] != 5)
		{
			echo ' - <a href="?page=checkPasses&id='.$event_id.'" class="btn btn-page-header"><span class="fa fa-check-square-o fa-fw fa-lg"></span>Checka Pass</a>';
		}

		if(count($da_note) > 0 && checkAdminAccess() <= 1)
		{
			echo ' - <a href="?page=DANote&id='.$da_note[0]['event_id'].'" class="btn btn-page-header">DA-lapp</a>';
		}

		if(count($headwaiter_note) > 0 && checkAdminAccess() <= 1)
		{
			echo ' - <a href="?page=HeadwaiterNote&id='.$headwaiter_note[0]['event_id'].'" class="btn btn-page-header">Hovis-lapp</a>';
		}
		?>
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

<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-comments fa-fw fa-lg"></span> Kommentarer</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">

<?php loadComments() ?>

<form action="" method="post">
	<div class="col-sm-5">
		<div class="white-box">
			<h3>Skriv kommentar</h3>
			<label for="comment">Kommentar</label>
			<textarea rows="6" cols="50" placeholder="*Portalen är fan rätt schysst asså!!" name="comment" id="comment" class="bottom-border"></textarea>

			<input type="submit" name="submitComment" value="Skicka kommentar">
		</div> <!-- .white-box -->
	</div>
</form>

</div> <!-- .row -->