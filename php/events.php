<?php
$db    = new PDO('mysql:host=localhost;dbname=portalen;charset=utf8', 'portalen', 'portalen');
$start = $_REQUEST['from'] / 1000;
$end   = $_REQUEST['to'] / 1000;
$sql   = sprintf('SELECT * FROM event WHERE `start_time` BETWEEN %s and %s',
    $db->quote(date('Y-m-d', $start)), $db->quote(date('Y-m-d', $end)));

$out = array();
foreach($db->query($sql) as $row) {
    $out[] = array(
        'id' => $row->id,
        'title' => $row->name,
        'url' => Helper::url($row->id),
        'start' => strtotime($row->start_time) . '000',
        'end' => strtotime($row->end_time) .'000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;

