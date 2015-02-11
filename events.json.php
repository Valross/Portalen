<?php

/*
$out = array();

$out[] = array(
    'id' => "123",
    'title' => "testpuben",
    'url' => "http://example.com",
    'class' => "event-warning",
    'start' => time(), //"1422465963000",
    'end' => strtotime("2015-01-28 20:00:00") //"1422471600000"
);


//encoda till json
echo json_encode(array('success' => 1, 'result' => $out));
// exit;

*/
?>

{
	"success": 1,
	"result": [
		{
			<?php

			$result = DBQuery::sql("SELECT id FROM work_slot WHERE id = '51'");
		    $id = $result[0]["id"];

		    $result = DBQuery::sql("SELECT name FROM event where id = '35'");
		    $title = $result[0]["name"];

		    $url = "http://www.example.com/";
		    $class = "event-warning";

		    $start = time();
		    $end = strtotime("2015-01-28 20:00:00");

		    echo " \"id\": \"" .    $id 	. "\","
		    .	 " \"title\": \"" . $title  . "\","
		    . 	 " \"url\": \"" . 	$url 	. "\","
		    . 	 " \"class\": \"" . $class  . "\","
		    . 	 " \"start\": \"" . $start  . "\","
		    . 	 " \"end\": \"" . 	$end 	. "\","
		     
			?>
		}
	]
}

<!-- {
	"success": 1,
	"result": [
		{
			"id": "293",
			"title": "This is warning class event with very long title to check how it fits to evet in day view",
			"url": "http://www.example.com/",
			"class": "event-warning",
			"start": "1362938400000",
			"end":   "1363197686300"
		},
		{
			"id": "256",
			"title": "Event that ends on timeline",
			"url": "http://www.example.com/",
			"class": "event-warning",
			"start": "1363155300000",
			"end":   "1363227600000"
		},
		{
			"id": "276",
			"title": "Short day event",
			"url": "http://www.example.com/",
			"class": "event-success",
			"start": "1363245600000",
			"end":   "1363252200000"
		},
		{
			"id": "294",
			"title": "This is information class ",
			"url": "http://www.example.com/",
			"class": "event-info",
			"start": "1363111200000",
			"end":   "1363284086400"
		},
		{
			"id": "297",
			"title": "This is success event",
			"url": "http://www.example.com/",
			"class": "event-success",
			"start": "1363234500000",
			"end":   "1363284062400"
		},
		{
			"id": "54",
			"title": "This is simple event",
			"url": "http://www.example.com/",
			"class": "",
			"start": "1422465963000",
			"end":   "1422471600000"
		},
		{
			"id": "532",
			"title": "This is inverse event",
			"url": "http://www.example.com/",
			"class": "event-inverse",
			"start": "1364407200000",
			"end":   "1364493686400"
		},
		{
			"id": "548",
			"title": "This is special event",
			"url": "http://www.example.com/",
			"class": "event-special",
			"start": "1363197600000",
			"end":   "1363629686400"
		},
		{
			"id": "295",
			"title": "Event 3",
			"url": "http://www.example.com/",
			"class": "event-important",
			"start": "1364320800000",
			"end":   "1364407286400"
		}
	]
}
 -->