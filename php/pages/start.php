<?php
include_once('php/DBQuery.php');

$user_id = $_SESSION['user_id'];

unlockAchievementForUser($user_id, 1);

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

function loadUserAvatar()
{
	$groups = DBQuery::sql("SELECT user_id, date FROM news ORDER BY date");

	if(count($groups) > 0)
	{
		echo '<a href=?page=userProfile&id='.$groups[count($groups)-1]['user_id'].'>'.
		'<img src="'.loadNewsAvatar($groups[count($groups)-1]['user_id']).'" width="20" height="20" class="img-circle"></a>';
	}
}

function loadUserName()
{
	$groups = DBQuery::sql("SELECT user_id, date FROM news ORDER BY date");
	$user_id = $groups[0]['user_id'];

	$user = DBQuery::sql("SELECT name, last_name FROM user 
						WHERE id = '$user_id'");
	if(count($groups) > 0)
	{
		echo '<a href=?page=userProfile&id='.$groups[count($groups)-1]['user_id'].'>'.$user[0]['name'].' '.$user[0]['last_name'].'</a>';
	}
}

function loadDate()
{
	$groups = DBQuery::sql("SELECT date FROM news ORDER BY date");
	if(count($groups) > 0)
		echo $groups[count($groups)-1]['date'];
}

?>