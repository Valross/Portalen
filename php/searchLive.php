<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/general.php');


// Define Output HTML Formating
$defaultHtml  = '';
$defaultHtml .= '<a href="urlString" class="list-group-item with-thumbnail">';
$defaultHtml .= 'nameString';
$defaultHtml .= '</a>';
$defaultHtml .= '';

$eventHtml  = '';
$eventHtml .= '<a href="urlString" class="list-group-item">';
$eventHtml .= 'nameString';
$eventHtml .= '<span class="list-group-item-text pull-right">dateString</span>';
$eventHtml .= '</a>';
$eventHtml .= '';

$groupHtml  = '';
$groupHtml .= '<a href="urlString" class="list-group-item with-thumbnail">';
$groupHtml .= '<span class="fa fa-users fa-fw fa-lg list-group-thumbnail group-badge" style="background: #f79839;"></span>';
$groupHtml .= 'nameString';
$groupHtml .= '</a>';
$groupHtml .= '';


// Get Search
$searchString = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);	//fixa åäö
$searchString = DBQuery::safeString($searchString);

// Check Length More Than One Character
if (strlen($searchString) > 1 && $searchString !== ' ') {
	$noResults = 1;
	$maxResultsPerCategory = 5;

	// Search users
	$users = DBQuery::sql("SELECT id, name, last_name, mail FROM user 
			WHERE name LIKE '%" . $searchString . "%' OR last_name LIKE '%" . $searchString  ."%'");

	if(count($users) > 0) {
		$noResults = 0;
		echo '<div class="col-sm-4">
			<h3>Användare</h3>
				<div class="list-group">';
		
		for ($i=0; $i < count($users) and $i <= $maxResultsPerCategory; ++$i) { 
			if(!($i == $maxResultsPerCategory)){
				$userId = $users[$i]['id'];
				$avatar = loadAvatarFromUser($userId, 32);

				$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $users[$i]['name'] . " " . $users[$i]['last_name']);
				
				$output = str_replace('nameString', $avatar . " " . $display_name, $defaultHtml);
				$output = str_replace('urlString', "?page=userProfile&id=$userId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $defaultHtml);
				$output = str_replace('urlString', "", $output);
			}

			echo($output);
	 	} 	
		echo "</div></div>";
	}

	// Search events ahead of current time
	$timestamp = date('Y-m-d h:i:s', time());
	$events = DBQuery::sql("SELECT id, name, start_time FROM event WHERE name LIKE '%" . $searchString . "%' AND start_time > '$timestamp' ORDER BY start_time ASC"); 
	$pastEvents = DBQuery::sql("SELECT id, name, start_time FROM event WHERE name LIKE '%" . $searchString . "%' AND start_time < '$timestamp' ORDER BY start_time DESC"); 

	if(count($events) > 0) {
		$noResults = 0;
		echo '<div class="col-sm-4">
			<h3>Evenemang</h3>
				<div class="list-group">';
		
		for ($i=0; $i < count($events) and $i <= $maxResultsPerCategory; ++$i) { 
			$eventId = $events[$i]['id'];
			$eventDate = $events[$i]['start_time'];

			$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $events[$i]['name']);


			if(!($i == $maxResultsPerCategory)){
				$output = str_replace('nameString', $display_name, $eventHtml);
				$output = str_replace('dateString', $eventDate, $output);
				$output = str_replace('urlString', "?page=event&id=$eventId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $defaultHtml);
				$output = str_replace('urlString', "", $output);
			}
			echo($output);
	 	}
		echo '</div></div>';
	}

	// If slots remain, search events past current time
 	if(count($pastEvents) > 0 && (count($events) < $maxResultsPerCategory || count($events == 0))) {
		$noResults = 0;
		echo '<div class="col-sm-4">
			<h3>Evenemang</h3>
				<div class="list-group">';
		
 		for ($j=0; $j < count($pastEvents) and $j <= $maxResultsPerCategory - count($events); ++$j) { 
 			$eventId = $pastEvents[$j]['id'];
			$eventDate = $pastEvents[$j]['start_time'];

			$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $pastEvents[$j]['name']);

			if(!($j == $maxResultsPerCategory)){
				$output = str_replace('nameString', $display_name, $eventHtml);
				$output = str_replace('dateString', $eventDate, $output);
				$output = str_replace('urlString', "?page=event&id=$eventId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $defaultHtml);
				$output = str_replace('urlString', "", $output);
			}

			echo($output);
			
 		}
		echo '</div></div>';
 	} 	

	// Search teams
	$teams = DBQuery::sql("SELECT id, name FROM work_group WHERE name LIKE '%" . $searchString . "%'"); 

	if(count($teams) > 0) {
		$noResults = 0;
		echo '<div class="col-sm-4">
			<h3>Lag</h3>
			<div class="list-group">';
		
		for ($i=0; $i < count($teams) and $i <= $maxResultsPerCategory; ++$i) { 
			$teamId =  $teams[$i]['id'];

			$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $teams[$i]['name']);

			if(!($i == $maxResultsPerCategory)){
				$output = str_replace('nameString', $display_name, $groupHtml);
				$output = str_replace('urlString', "?page=group&id=$teamId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $defaultHtml);
				$output = str_replace('urlString', "", $output);
			}
			echo($output);
	 	} 	
		echo '</div></div>';
	}

	// No-results-found output
	if($noResults) {
		$output = str_replace('urlString', 'javascript:void(0);', $defaultHtml);
		$output = str_replace('nameString', 'Inga resultat', $output);

		echo($output);
	}

}


?>