<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit']))
{
	$comment = strip_tags($_POST['comment'], allowed_tags());
	$group_id = $_GET['group_id'];
	
	if($comment != '')
	{
		DBQuery::sql("INSERT INTO dot (user_id, group_id, comment, date_written)
						VALUES ('$_SESSION[user_id]', '$group_id', '$comment', '$date')");

		$dot = DBQuery::sql("SELECT id FROM dot 
						WHERE group_id = '$group_id'
						ORDER BY date_written DESC");

		$dot_id = $dot[0]['id'];

		$users = DBQuery::sql("SELECT id FROM user
							WHERE id IN
								(SELECT user_id FROM group_member
								WHERE group_id = '$group_id')");

		for($i = 0; $i < count($users); ++$i)
		{
			if($users[$i]['id'] != $_SESSION['user_id'])
				notify($users[$i]['id'], 6, $dot_id);
		}
	}
}

function loadGroupName()
{
	$group_id = $_GET['group_id'];

	$group_name = DBQuery::sql("SELECT name, id, icon, hex FROM work_group 
						WHERE id = '$group_id'");

	if($group_name[0]['icon'] != '')
		echo '<span class="'.$group_name[0]['icon'].' list-group-thumbnail group-badge webb"></span>';
	else
		echo '<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>'; 

	echo '<a href="?page=group&id='.$group_name[0]['id'].'">'.$group_name[0]['name'].'</a>';
	loadTitleForBrowser('Punkter - '.$group_name[0]['name']);
}

function loadProtocolLink()
{
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['group_id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");
	if(count($memberOfGroup) > 0)
	{
		echo '<a href="?page=browseProtocol&group_id='.$group_id.'"><span class="fa fa-list-alt fa-fw fa-lg"></span>Protokoll</a>';
	}
}

function loadCommentAvatar($comment_id)
{
	$group_id = $_GET['group_id'];
	$user = DBQuery::sql("SELECT user_id FROM dot 
						WHERE id = '$comment_id'"); 

	if(count($user) > 0)
		$user_id = $user[0]['user_id'];

	if(isset($user_id))
	{
		$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
		if(count($results) == 0)
		{
			return 'img/avatars/no_face_small.png';
		}
		return 'img/avatars/'.$results[0]['avatar'];
	}
}

function loadComments()
{
	$group_id = $_GET['group_id'];
	$dots = DBQuery::sql("SELECT id, comment, user_id, date_written FROM dot
							WHERE group_id = '$group_id'
							ORDER BY date_written DESC");

	if(isset($_GET['pageNumber']))
		$currentPage = $_GET['pageNumber'];
	else
		$currentPage = 0;

	$itemsPerPage = 10;
	$totalItems = count($dots);
	$lastPage = ceil(($totalItems / $itemsPerPage))-1;
	$startItem = $currentPage * $itemsPerPage;

	if(count($dots) > 0 && $currentPage <= $lastPage)
	{
		echo '<div class="col-sm-7">
						<div class="white-box">';
		echo '<h3>Punkter ('.count($dots).')</h3>';
	

		for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($dots); ++$i)
		{
			$user_id = $dots[$i]['user_id'];
			$comment_id = $dots[$i]['id'];
			$my_user_id = $_SESSION['user_id'];

			$myComment = DBQuery::sql("SELECT id FROM dot 
							WHERE id = '$comment_id'
							AND user_id = '$my_user_id'");

			$commenter = DBQuery::sql("SELECT name, last_name FROM user 
							WHERE id = '$user_id' AND id IN
							(SELECT user_id FROM dot WHERE id = '$comment_id')");

			echo '<div class="comment">';
			echo '<img src="'.loadCommentAvatar($dots[$i]['id']).'" width="64" height="64" class="img-circle">';
			echo '<p><a href="?page=userProfile&id='.$dots[$i]['id'].'">'.$commenter[0]['name'].' '.$commenter[0]['last_name'].'</a> ';
			echo '<span class="time">- '.$dots[$i]['date_written'].'</span><br />';
			echo nl2br($dots[$i]['comment']);
			echo '</p>';
			if(checkAdminAccess() == 1 || count($myComment) > 0)
					echo '<a href=?page=removeDot&dot_id='.$comment_id.'&group_id='.$group_id.
							' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a>';
			echo '</div>';
		}
		echo '			</div> <!-- .white-box -->
					</div> <!-- .col-sm-7 -->';
		$append = '&group_id='.$group_id;
		echo '<div class="col-sm-7">
					<div class="white-box">';
		loadPageNumbers($currentPage, $lastPage, 'browseDots', $append);
		echo    	'</div>
			 </div>';
	}
}
?>