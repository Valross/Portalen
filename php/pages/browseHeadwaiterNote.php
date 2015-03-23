<?php
loadTitleForBrowser('Hovis-lappar');

function loadHeadwaiterAvatar($headwaiter_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$headwaiter_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadAllHeadwaiterNotes()
{
	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.user_id, headwaiter_note.n_of_sitting, 
											event.name, event.start_time FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id 
							ORDER BY event.start_time DESC");

	if(isset($_GET['pageNumber']))
		$currentPage = $_GET['pageNumber'];
	else
		$currentPage = 0;

	$itemsPerPage = 10;
	$totalItems = count($HeadwaiterNotes);
	$lastPage = ceil(($totalItems / $itemsPerPage))-1;
	$startItem = $currentPage * $itemsPerPage;

	if(count($HeadwaiterNotes) > 0 && checkAdminAccess())
	{
		for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($HeadwaiterNotes); ++$i)
		{
			echo '<tr>';
				echo '<td>'.($i+1).'</td>';
				echo '<td><a href="?page=HeadwaiterNote&id='.$HeadwaiterNotes[$i]['event_id'].'">';
				echo $HeadwaiterNotes[$i]['name'].'</a></td>';
				echo '<td>'.$HeadwaiterNotes[$i]['start_time'].'</td>';
				echo '<td>'.$HeadwaiterNotes[$i]['n_of_sitting'].'</td>';
				echo '<td><a href="?page=userProfile&id='.$HeadwaiterNotes[$i]['user_id'].'">';
				echo '<img src="'.loadHeadwaiterAvatar($HeadwaiterNotes[$i]['user_id']).'" width="25" height="25" class="img-circle"></a></td>';
			echo '</tr>';
		}
	}
	if(isset($_GET['sort']))
		$append = '&sort='.$_GET['sort'];
	else
		$append = '';
	echo '</tbody></table>';
	echo '		</div>
			</div>
		</div>
	</div>';
	echo '<div class="col-sm-12">
				<div class="white-box">';
	loadPageNumbers($currentPage, $lastPage, 'browseHeadwaiterNote', $append);
	echo    	'</div>
		 </div>';
}

?>