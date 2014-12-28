<?php
$result = DBQuery::sql("SELECT * FROM application");
$howMany = count($result);
// echo "reults = " . $howMany;

for($i=0; $i<$howMany; $i++) { 
	$name = $result[$i]["name"];
	$lastName = $result[$i]["last_name"];
	$ssn = $result[$i]["ssn"];
	$mail = $result[$i]["mail"];
	$appId = $result[$i]["id"];

	$teamIds = DBQuery::sql("SELECT group_id FROM application_group WHERE application_id = '$appId'");
	$nTeams = count($teamIds);

	?>
		<div id="application-container">
		<ul>
		<li> <?php echo $name 	  ?> </li>
		<li> <?php echo $lastName ?> </li>
		<li> <?php echo $ssn 	  ?> </li>
		<li> <?php echo $mail 	  ?> </li>
		<li> <?php for($j=0; $j<$nTeams; $j++){ 
					  $currentId = $teamIds[$j]["group_id"];
				   	  $teamNames = DBQuery::sql("SELECT name FROM work_group WHERE id ='$currentId' ");
				   	  $thisTeam = $teamNames[0]["name"];
				   	  echo $thisTeam . " ";
				   }?> </li>
		</ul>
		</div>
	<?php

}

?>
