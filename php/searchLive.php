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

// echo "hallå";

// Check Length More Than One Character
if (strlen($searchString) >= 1 && $searchString !== ' ') {

	$results = DBQuery::sql("SELECT id, name, last_name, mail FROM user 
			WHERE name LIKE '%" . $searchString . "%' OR last_name LIKE '%" . $searchString  ."%'");

	if(isset($results)){
		for ($i=0; $i < count($results); ++$i) { 
			// echo "bajs";

			// $display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['name']);

			// insert name
			$output = str_replace('nameString', $results[$i]['name'], $html);

			// insert url
			$output = str_replace('urlString', "http://www.example.com", $output);

			echo($output);
	 	} 	
	}

	else{
		echo "hej";

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('nameString', '<b>No Results Found.</b>', $output);

		echo($output);
	}

}


?>