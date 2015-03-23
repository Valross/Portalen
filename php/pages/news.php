<?php
include_once('php/DBQuery.php');

function loadAll()
{
	$news = DBQuery::sql("SELECT id, date FROM news ORDER BY date DESC");

	if(isset($_GET['pageNumber']))
		$currentPage = $_GET['pageNumber'];
	else
		$currentPage = 0;

	$itemsPerPage = 4;
	$totalItems = count($news);
	$lastPage = floor(($totalItems / $itemsPerPage));
	$startItem = $currentPage * $itemsPerPage;

	if($currentPage <= $lastPage)
	{
		for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($news); ++$i)
		{
			echo '<div class="col-sm-7">
					<div class="white-box">';
						echo '<h2>'.loadTitle($news[$i]['id']).'</h2>';
						echo '<div class="news-info"><span>';
						echo loadUserAvatar($news[$i]['id']);
						echo loadUserName($news[$i]['id']);
						echo '</span> <span class="time">- '.loadDate($news[$i]['id']).'</span>'.loadRemove($news[$i]['id']).'</div>';
						echo '<p>'.loadMessage($news[$i]['id']).'</p>';
			echo    '</div>
				 </div>';
		}
		loadPageNumbers($currentPage, $lastPage);
	}		
}
	
function loadPageNumbers($currentPage, $lastPage)
{
	echo '<div class="col-sm-7">
					<div class="white-box">';
	echo '<p>';

	if($currentPage == 0)
	{
		echo 'Första ';
		echo '<a href="?page=news&pageNumber='.($currentPage+1).'">'.($currentPage+1).'</a> ';

		if($lastPage > $currentPage+2)
			echo '... ';

		if($lastPage > $currentPage+2)
			echo '<a href="?page=news&pageNumber='.($lastPage).'">Sista</a> ';
	}
	else if($currentPage == $lastPage)
	{
		echo '<a href="?page=news&pageNumber=0">Första</a> ';

		if($currentPage-2 > 0)
			echo '... ';

		echo '<a href="?page=news&pageNumber='.($currentPage-1).'">'.($currentPage-1).'</a> ';
		
		echo 'Sista ';
	}
	else
	{
		echo '<a href="?page=news&pageNumber=0">Första</a> ';

		if($currentPage-2 > 0)
			echo '... ';

		if($currentPage-1 > 0)
			echo '<a href="?page=news&pageNumber='.($currentPage-1).'">'.($currentPage-1).'</a> ';
		
		echo $currentPage.' ';

		if($currentPage < $lastPage)
		{
			if($currentPage == $lastPage-1)
				echo '<a href="?page=news&pageNumber='.($currentPage+1).'">Sista</a> ';
			else
				echo '<a href="?page=news&pageNumber='.($currentPage+1).'">'.($currentPage+1).'</a> ';
		}

		if($lastPage > $currentPage+2)
			echo '... ';
		
		if($lastPage > $currentPage+1)
			echo '<a href="?page=news&pageNumber='.($lastPage).'">Sista</a> ';
	}

	echo '</p>';
	echo    '</div>
		 </div>';
}

function loadTitle($news_id)
{
	$news = DBQuery::sql("SELECT title FROM news
							WHERE id = '$news_id'");
	return $news[0]['title'];
}

function loadRemove($news_id)
{
	if(checkAdminAccess())
		echo '<a href=?page=removeNews&news_id='.$news_id.
				' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a>';
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