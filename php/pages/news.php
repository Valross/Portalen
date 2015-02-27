<?php
include_once('php/DBQuery.php');

function loadAll()
{
	$news = DBQuery::sql("SELECT id, date FROM news ORDER BY date DESC");

	for($i = 0; $i < count($news); ++$i)
	{
		echo '<div class="col-sm-7">
				<div class="white-box">';
					echo '<h1>'.loadTitle($news[$i]['id']).'</h1>';
					echo '<div>'.loadUserAvatar($news[$i]['id']);
					echo loadUserName($news[$i]['id']);
					echo '<p>'.loadDate($news[$i]['id']).'</p></div>';
					echo '<div>'.loadMessage($news[$i]['id']).'</div>';
		echo    '</div>
			 </div>';
	}
}

function loadTitle($news_id)
{
	$news = DBQuery::sql("SELECT title FROM news
							WHERE id = '$news_id'");
	return $news[0]['title'];
}

function loadMessage($news_id)
{
	$news = DBQuery::sql("SELECT message FROM news
							WHERE id = '$news_id'");
	return $news[0]['message'];
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

function loadUserAvatar($news_id)
{
	$news = DBQuery::sql("SELECT user_id FROM news
						WHERE id = '$news_id'");

	if(count($news) > 0)
	{
		echo '<a href=?page=userProfile&id='.$news[0]['user_id'].'>'.
		'<img src="'.loadNewsAvatar($news[0]['user_id']).'" width="25" height="25" class="img-circle"></a>';
	}
}

function loadUserName($news_id)
{
	$news = DBQuery::sql("SELECT user_id FROM news
						WHERE id = '$news_id'");
	$user_id = $news[0]['user_id'];

	$user = DBQuery::sql("SELECT name, last_name FROM user 
						WHERE id = '$user_id'");
	if(count($news) > 0)
	{
		echo '<a href=?page=userProfile&id='.$news[0]['user_id'].'>'.$user[0]['name'].' '.$user[0]['last_name'].'</a>';
	}
}

function loadDate($news_id)
{
	$news = DBQuery::sql("SELECT date FROM news
							WHERE id = '$news_id'");
	return $news[0]['date'];
}

?>