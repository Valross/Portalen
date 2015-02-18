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

function loadNewsAvatar($user_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadUser()
{
	$groups = DBQuery::sql("SELECT user_id, date FROM news ORDER BY date");
	if(count($groups) > 0)
		echo $groups[count($groups)-1]['user_id'];
	echo '<a href=?page=userProfile&id='.$groups[count($groups)-1]['user_id'].'>'.
	'<img src="'.loadNewsAvatar($groups[count($groups)-1]['user_id']).'" width="25" height="25" class="img-circle"></a>';
}

function loadDate()
{
	$groups = DBQuery::sql("SELECT date FROM news ORDER BY date");
	if(count($groups) > 0)
		echo $groups[count($groups)-1]['date'];
}

?>