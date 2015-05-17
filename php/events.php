<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/DBQuery.php');

//nu gör vi så här tills vidare
$result = DBQuery::sql("SELECT * FROM event WHERE start_time BETWEEN '2015-01-01 00:00:01' AND '2015-12-31 23:59:59'");
$howMany = count($result);

$out = array();
for ($i=0; $i < $howMany; ++$i) { 

	//färger
	$eventType = $result[$i]["event_type_id"];
	$class = "";


		switch($eventType){
			case 1:		//pub
				$class = "event-pub";
				break;
			case 2:		//nattklubb
				$class = "event-nattklubb";
				break;
			case 3:		//sittning
				$class = "event-sittning";
				break;
			case 4:		//personalaktivitet
				$class = "event-personalaktivitet";
				break;
			case 5:		//möte
				$class = "event-mote";
				break;
			default:
				$class = "event-inverse"; //grå
		}
	
	//varje event
	$out[] = array(
        'id' => $result[$i]["id"],
        'title' => $result[$i]["name"],
        'url' => "?page=event&id=".$result[$i]["id"] ,
        'class' => $class,
        'start' => strtotime($result[$i]["start_time"]) . '000',
        'end' => strtotime($result[$i]["end_time"]) . '000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;

