<?php
include_once('php/DBQuery.php');



function loadTitle()
{
	$groups = DBQuery::sql("SELECT title, date FROM news ORDER BY date");
	if(count($groups) > 0)
		echo $groups[count($groups)-1]['title'];
}

function loadMessage()
{
	$groups = DBQuery::sql("SELECT message, date FROM news ORDER BY date");
	if(count($groups) > 0)
		echo $groups[count($groups)-1]['message'];
}

function loadUser()
{
	$groups = DBQuery::sql("SELECT user_id, date FROM news ORDER BY date");
	if(count($groups) > 0)
		echo $groups[count($groups)-1]['user_id'];
}

function loadDate()
{
	$groups = DBQuery::sql("SELECT date FROM news ORDER BY date");
	if(count($groups) > 0)
		echo $groups[count($groups)-1]['date'];
}

?>