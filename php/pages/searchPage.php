<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Sökresultat');

	function loadAllResults($searchString){
		
		// TO DO: limit query to specific page to save performance
		$results = DBQuery::sql("SELECT id, name, last_name, 'user' as source_table FROM user WHERE name LIKE '%" . $searchString . "%' OR last_name LIKE '%" . $searchString  ."%'
			UNION
			SELECT id, name, start_time, 'event' as source_table FROM event WHERE name LIKE '%" . $searchString . "%' 
			UNION
			SELECT id, name, Null as col3, 'team' as source_table FROM work_group WHERE name LIKE '%" . $searchString . "%' ");

		$currentPage = 0;

		if(isset($_GET['pageNumber']))
			$currentPage = $_GET['pageNumber'];

		$itemsPerPage = 15;
		$totalItems = count($results);
		$lastPage = ceil(($totalItems / $itemsPerPage))-1;
		$startItem = $currentPage * $itemsPerPage;

		if($currentPage <= $lastPage) {
			for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($results); ++$i) {
	  			$sourceTable = $results[$i]['source_table'];

	  			if($sourceTable == 'user'){
		  			$firstName = $results[$i]['name']; 
		        	$lastName = $results[$i]['last_name']; 
		        	$userId = $results[$i]['id'];

				 	displayUser($firstName, $lastName, $userId);	
	  			}

	  			else if ($sourceTable == 'event'){
	  				$eventName = $results[$i]['name'];
		        	$eventId = $results[$i]['id'];
		        	// $date = $results[$i]['start_time']; funkar inte?
		        	$date = DBQuery::sql("SELECT start_time FROM event WHERE id='$eventId'");

		        	displayEvent($eventName, $eventId, $date[0]['start_time']);
	  			}

	  			else {  //team
	  				$teamName = $results[$i]['name'];
		        	$teamId =  $results[$i]['id'];

		        	displayTeam($teamName, $teamId);
	  			}  			
  			}

  			echo '<div class="col-sm-7">
					<div class="white-box">';
				loadPageNumbers($currentPage, $lastPage, 'searchPage', '&query='.$searchString);
			echo    '</div>
				</div>'; 
		
		}
	}

	function displayUser($firstName, $lastName, $userId){		
		?>
		<div class="col-sm-7">
			<div class="white-box">
	   			<?php echo "<a href=\"?page=userProfile&id=$userId\">". loadAvatarFromUser($userId, 32) . $firstName . " " . $lastName . "</a>\n"; ?>
		 	</div>
		</div>
		<?php

  	}

  	function displayEvent($eventName, $eventId, $date){
	    ?>
		<div class="col-sm-7">
			<div class="white-box">
	  			<?php echo "<a href=\"?page=event&id=$eventId\">" . $eventName . " (" . $date . ")" . "</a>\n"; ?> 
			</div>
 		</div> 
 		<?php
  	}

  	function displayTeam($teamName, $teamId){
        ?>
        <div class="col-sm-7">
			<div class="white-box">    	
	  			<?php echo "<a href=\"?page=group&id=$teamId\">" . $teamName . "</a>\n"; ?>
			</div>
 		</div>
 		<?php
	}

?>
