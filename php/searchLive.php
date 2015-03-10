<?php
include_once('DBQuery.php');


// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a target="_blank" href="urlString">';
$html .= '<h3>nameString</h3>';
// $html .= '<h4>functionString</h4>';
$html .= '</a>';
$html .= '</li>';

// Get Search
$searchString = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$searchString = DBQuery::safeString($searchString);

// Check Length More Than One Character
if (strlen($searchString) >= 1 && $searchString !== ' ') {

	$noResults = 1;

	// Search users
	$users = DBQuery::sql("SELECT id, name, last_name, mail FROM user 
			WHERE name LIKE '%" . $searchString . "%' OR last_name LIKE '%" . $searchString  ."%'");

	if(count($users) != 0){
		$noResults = 0;
		echo "Användare";
		
		for ($i=0; $i < count($users); ++$i) { 

			// $display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['name']);

			// insert name
			$output = str_replace('nameString', $users[$i]['name'], $html);

			// insert url
			$output = str_replace('urlString', "http://www.example.com", $output);

			echo($output);
	 	} 	
	}

	// Search events
	$events = DBQuery::sql("SELECT id, name, start_time FROM event WHERE name LIKE '%" . $searchString . "%'"); 

	if(count($events) != 0){
		$noResults = 0;
		echo "Evenemang";
		
		for ($i=0; $i < count($events); ++$i) { 

			// $display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['name']);

			// insert name
			$output = str_replace('nameString', $events[$i]['name'], $html);

			// insert url
			$output = str_replace('urlString', "http://www.example.com", $output);

			echo($output);
	 	} 	
	}
	
	// Search teams
	$teams = DBQuery::sql("SELECT id, name FROM work_group WHERE name LIKE '%" . $searchString . "%'"); 

	if(count($teams) != 0){
		$noResults = 0;
		echo "Lag";
		
		for ($i=0; $i < count($teams); ++$i) { 

			// $display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['name']);

			// insert name
			$output = str_replace('nameString', $teams[$i]['name'], $html);

			// insert url
			$output = str_replace('urlString', "http://www.example.com", $output);

			echo($output);
	 	} 	
	}


	if($noResults) {
		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('nameString', '<b>Inga resultat</b>', $output);

		echo($output);
	}

}


?>