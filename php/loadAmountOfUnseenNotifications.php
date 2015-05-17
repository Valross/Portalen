<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/DBQuery.php');

$user_id = $_SESSION['user_id'];
$notifications = DBQuery::sql("SELECT id FROM notification
									WHERE user_id = '$user_id' AND seen IS NULL");

if(count($notifications) > 0)
{
	echo '<span class="badge on-top-of-element red-background">';
	echo count($notifications);
	echo '</span>';
}

?>