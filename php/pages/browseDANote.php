<?php
loadTitleForBrowser('DA-lappar');

function loadDAAvatar($DA_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$DA_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadAllDANotes()
{
	$sort = '';
	if(isset($_GET['sort']))
		$sort = $_GET['sort'];

	$DANotes_sql = 'SELECT da_note.event_id, da_note.user_id, da_note.sales_total, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.message, event.name, event.start_time FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id ';

	if($sort == 'total')
		$DANotes_sql .= 'ORDER BY da_note.sales_total DESC';
	else if($sort == 'nOfPeople')
		$DANotes_sql .= 'ORDER BY da_note.n_of_people DESC';
	else if($sort == 'sales_bar')
		$DANotes_sql .= 'ORDER BY da_note.sales_bar DESC';
	else if($sort == 'sales_entry')
		$DANotes_sql .= 'ORDER BY da_note.sales_entry DESC';
	else if($sort == 'cash')
		$DANotes_sql .= 'ORDER BY da_note.cash DESC';
	else if($sort == 'sales_spenta')
		$DANotes_sql .= 'ORDER BY da_note.sales_spenta DESC';
	else
		$DANotes_sql .= 'ORDER BY event.start_time DESC';

	$DANotes = DBQuery::sql($DANotes_sql);

	if(isset($_GET['pageNumber']))
		$currentPage = $_GET['pageNumber'];
	else
		$currentPage = 0;

	$itemsPerPage = 10;
	$totalItems = count($DANotes);
	$lastPage = ceil(($totalItems / $itemsPerPage))-1;
	$startItem = $currentPage * $itemsPerPage;

	if(count($DANotes) > 0 && checkAdminAccess() <= 2 && $currentPage <= $lastPage)
	{
		for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($DANotes); ++$i)
		{
			echo '<tr>';
				echo '<td>'.($i+1).'</td>';
				echo '<td><a href="?page=DANote&id='.$DANotes[$i]['event_id'].'">';
				echo $DANotes[$i]['name'].'</a></td>';
				echo '<td>'.$DANotes[$i]['start_time'].'</td>';
				echo '<td>'.$DANotes[$i]['sales_total'].'</td>';
				echo '<td>'.$DANotes[$i]['sales_entry'].'</td>';
				echo '<td>'.$DANotes[$i]['sales_bar'].'</td>';
				echo '<td>'.$DANotes[$i]['cash'].'</td>';
				echo '<td>'.$DANotes[$i]['n_of_people'].'</td>';
				echo '<td>'.$DANotes[$i]['sales_spenta'].'</td>';
				echo '<td><a href="?page=userProfile&id='.$DANotes[$i]['user_id'].'">';
				echo '<img src="'.loadDAAvatar($DANotes[$i]['user_id']).'" width="25" height="25" class="img-circle"></a></td>';
			echo '</tr>';
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
		loadPageNumbers($currentPage, $lastPage, 'browseDANote', $append);
		echo    	'</div>
			 </div>';
	}
}

?>