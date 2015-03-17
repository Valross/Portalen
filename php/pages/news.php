<?php
include_once('php/DBQuery.php');

function loadAll()
{
	$news = DBQuery::sql("SELECT id, date FROM news ORDER BY date DESC");

	for($i = 0; $i < count($news); ++$i)
	{
		echo '<div class="col-sm-7">
				<div class="white-box">';
					echo '<h2>'.loadTitle($news[$i]['id']).'</h2>';
					echo '<div class="news-info"><span>';
					echo loadUserAvatar($news[$i]['id']);
					echo loadUserName($news[$i]['id']);
					echo '</span> <span class="time">- '.loadDate($news[$i]['id']).'</span></div>';
					echo '<p>'.loadMessage($news[$i]['id']).'</p>';
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
	return nl2br($news[0]['message']);
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
		'<img src="'.loadNewsAvatar($news[0]['user_id']).'" width="20" height="20" class="img-circle"></a>';
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