<?php
include_once('DBQuery.php');

//Just nu verkar calendar-app.js användas som bootstrap-kalender
//om vi byter till calendar.js kan vi kalla på en funktion
//som ger tidsvärden inom varje vy, så att det optimeras vilka
//events som ska visas åt gången
// $start = $_REQUEST['from'] / 1000;
// $end   = $_REQUEST['to'] / 1000;

//då ska vi kunna använda PDO på det här sättet
// $db    = new PDO('mysql:host=localhost;dbname=portalen;charset=utf8', 'portalen', 'portalen');
// $sql   = sprintf('SELECT * FROM event WHERE `start_time` BETWEEN %s and %s',
//     $db->quote(date('Y-m-d', $start)), $db->quote(date('Y-m-d', $end)));

//och generera vår array med en foreach-loop, som bara borde innehålla events för varje vy
// $out = array();
// foreach($db->query($sql) as $row) {
//     $out[] = array(
//         'id' => $row->id,
//         // 'title' => $row->name,
//         // 'url' => Helper::url($row->id),
//         // 'start' => strtotime($row->start_time) . '000',
//         // 'end' => strtotime($row->end_time) .'000'
//     );
// }

//nu gör vi så här tills vidare
$result = DBQuery::sql("SELECT * FROM event where start_time BETWEEN '2015-01-01 00:00:01' AND '2015-12-31 23:59:59'");
$howMany = count($result);
$out = array();
for ($i=0; $i < $howMany; $i++) { 
	$out[] = array(
        'id' => $result[$i]["id"],
        'title' => $result[$i]["name"],
        'url' => "?page=event&id=".$result[$i]["id"] ,	//url till varje event, event > id ska användas?
        'start' => strtotime($result[$i]["start_time"]) . '000',
        'end' => strtotime($result[$i]["end_time"]) . '000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;

