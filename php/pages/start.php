<?php
include_once('php/DBQuery.php');



function loadTitle()
{
	$groups = DBQuery::sql("SELECT title, date FROM news ORDER BY date");
	?>
		<?php echo $groups[count($groups)-1]['title']; ?>
	<?php
}

function loadMessage()
{
	$groups = DBQuery::sql("SELECT message, date FROM news ORDER BY date");
	?>
		<?php echo $groups[count($groups)-1]['message']; ?>
	<?php
}

function loadUser()
{
	$groups = DBQuery::sql("SELECT user_id, date FROM news ORDER BY date");
	?>
		<?php echo $groups[count($groups)-1]['user_id']; ?>
	<?php
}

function loadDate()
{
	$groups = DBQuery::sql("SELECT date FROM news ORDER BY date");
	?>
		<?php echo $groups[count($groups)-1]['date']; ?>
	<?php
}

?>