<?php
include_once('DBQuery.php');


// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a target="_blank" href="urlString">';
$html .= '<h3>nameString</h3>';
$html .= '</a>';
$html .= '</li>';

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
		echo "<p>Användare</p>";
		
		for ($i=0; $i < count($users) and $i <= $maxResultsPerCategory; ++$i) { 
			$userId = $users[$i]['id'];

			$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $users[$i]['name'] . " " . $users[$i]['last_name']);

			if(!($i == $maxResultsPerCategory)){
				$output = str_replace('nameString', $display_name, $html);
				$output = str_replace('urlString', "?page=userProfile&id=$userId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $html);
				$output = str_replace('urlString', "", $output);
			}

			echo($output);
	 	} 	
	}

	// Search events ahead of current time
	$timestamp = date('Y-m-d h:i:s', time());
	$events = DBQuery::sql("SELECT id, name, start_time FROM event WHERE name LIKE '%" . $searchString . "%' AND start_time > '$timestamp' ORDER BY start_time ASC"); 
	$pastEvents = DBQuery::sql("SELECT id, name, start_time FROM event WHERE name LIKE '%" . $searchString . "%' AND start_time < '$timestamp' ORDER BY start_time DESC"); 

	if(count($events) > 0) {
		$noResults = 0;
		echo "<p>Evenemang</p>";
		
		for ($i=0; $i < count($events) and $i <= $maxResultsPerCategory; ++$i) { 
			$eventId = $events[$i]['id'];

			$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $events[$i]['name']);

			if(!($i == $maxResultsPerCategory)){
				$output = str_replace('nameString', $display_name, $html);
				$output = str_replace('urlString', "?page=event&id=$eventId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $html);
				$output = str_replace('urlString', "", $output);
			}
			echo($output);
	 	}
	}

	// If slots remain, search events past current time
 	if(count($pastEvents) > 0 && (count($events) < $maxResultsPerCategory || count($events == 0))) {
		$noResults = 0;
 		for ($j=0; $j < count($pastEvents) and $j <= $maxResultsPerCategory - count($events); ++$j) { 
 			$eventId = $pastEvents[$j]['id'];

			$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $pastEvents[$j]['name']);

			if(!($j == $maxResultsPerCategory)){
				$output = str_replace('nameString', $display_name, $html);
				$output = str_replace('urlString', "?page=event&id=$eventId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $html);
				$output = str_replace('urlString', "", $output);
			}
			echo($output);
 		}
 	} 	

	// Search teams
	$teams = DBQuery::sql("SELECT id, name FROM work_group WHERE name LIKE '%" . $searchString . "%'"); 

	if(count($teams) > 0) {
		$noResults = 0;
		echo "<p>Lag</p>";
		
		for ($i=0; $i < count($teams) and $i <= $maxResultsPerCategory; ++$i) { 
			$teamId =  $teams[$i]['id'];

			$display_name = preg_replace("/".$searchString."/i", "<b class='highlight'>".$searchString."</b>"
				, $teams[$i]['name']);

			if(!($i == $maxResultsPerCategory)){
				$output = str_replace('nameString', $display_name, $html);
				$output = str_replace('urlString', "?page=group&id=$teamId", $output);
			}

			// If results limit reached, print dots or something
			else{
				$output = str_replace('nameString', "...", $html);
				$output = str_replace('urlString', "", $output);
			}
			echo($output);
	 	} 	
	}

	// No-results-found output
	if($noResults) {
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('nameString', 'Inga resultat', $output);

		echo($output);
	}

}


?>