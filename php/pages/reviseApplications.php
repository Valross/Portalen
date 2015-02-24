<?php

function loadApplications()
{
	$result = DBQuery::sql("SELECT * FROM application");
	$howMany = count($result);

	for($i=0; $i<$howMany; $i++) {
		$name = $result[$i]["name"];
		$lastName = $result[$i]["last_name"];
		$ssn = $result[$i]["ssn"];
		$mail = $result[$i]["mail"];
		$appId = $result[$i]["id"];

		$teamIds = DBQuery::sql("SELECT group_id FROM application_group WHERE application_id = '$appId'");
		$nTeams = count($teamIds);

		?>
				<tr>
					<td><?php echo $appId ?></td>
					<td><?php echo $name . " " . $lastName?></td>
					<td><?php echo $ssn?></td>
					<td><?php echo $mail?></td>
					<td><?php   for($j=0; $j<$nTeams; $j++){
									$currentId = $teamIds[$j]["group_id"];
									$teamNames = DBQuery::sql("SELECT name FROM work_group WHERE id ='$currentId' ");
									$thisTeam = $teamNames[0]["name"];

									if (!($j == $nTeams - 1))
										echo $thisTeam . ", ";
									else
										echo $thisTeam;
					    	  	}
					    ?></td>
					<td> <?php echo '<a href=?page=reviseApplicationsAccept&name='.$name.'&lastName='.$lastName.'&ssn='.$ssn.'&mail='.$mail.'>Boka</a>'; ?>
						  <button type="button">Neka</button> </td>
				</tr>
		<?php

	}
}

function addMemberToDatabase()
{
	$tempPassword = "trappan";
	DBQuery::sql("INSERT INTO user (user_name, mail, ssn, password, name, last_name)
						VALUES ('$mail', '$mail', '$ssn', '$tempPassword', '$name', '$last_name')");
}
?>