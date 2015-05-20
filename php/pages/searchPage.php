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
	  			$prevSourceTable = 0;
	  			if ($i > 0)
		  			$prevSourceTable = $results[$i-1]['source_table'];

	  			if($sourceTable == 'user'){
	  				if ($i == 0 ) {
	  					displayTitle("Användare");
	  				}

		  			$firstName = $results[$i]['name']; 
		        	$lastName = $results[$i]['last_name']; 
		        	$userId = $results[$i]['id'];

				 	displayUser($firstName, $lastName, $userId);	
	  			}

	  			if ($sourceTable == 'event'){
	  				if ($prevSourceTable !== 'event'){
	  					displayTitle("Evenemang");
	  				}

	  				$eventName = $results[$i]['name'];
		        	$eventId = $results[$i]['id'];
		        	// $date = $results[$i]['start_time']; funkar inte?
		        	$date = DBQuery::sql("SELECT start_time FROM event WHERE id='$eventId'");

		        	displayEvent($eventName, $eventId, $date[0]['start_time']);
	  			}

	  			if ($sourceTable == 'team') {
	  				if ($prevSourceTable !== 'team') {
	  					displayTitle("Lag");
	  				}

	  				$teamName = $results[$i]['name'];
		        	$teamId =  $results[$i]['id'];

		        	displayTeam($teamName, $teamId);
	  			}  			
  			}

				loadPageNumbers($currentPage, $lastPage, 'searchPage', '&query='.$searchString);
		
		}
	}

	function displayUser($firstName, $lastName, $userId){		
		?>
		
	   			<?php echo "<a href=\"?page=userProfile&id=$userId\" class=\"list-group-item with-thumbnail\">". loadAvatarFromUser($userId, 32) . $firstName . " " . $lastName . "</a>\n"; ?>
		 	
		<?php

  	}

  	function displayEvent($eventName, $eventId, $date){
	    ?>
	  			<?php echo "<a href=\"?page=event&id=$eventId\" class=\"list-group-item with-thumbnail\">" . $eventName . "<span class=\"list-group-item-text pull-right\">" . $date . "</span>" . "</a>\n"; ?> 
 		<?php
  	}

  	function displayTeam($teamName, $teamId){
        ?>
	  			<?php echo "<a href=\"?page=group&id=$teamId\" class=\"list-group-item with-thumbnail\">" . $teamName . "</a>\n"; ?>
 		<?php
	}

	function displayTitle($title){
        ?>   	
	  			<?php echo "<h3>$title</h3>"; ?>
 		<?php
	}

?>
