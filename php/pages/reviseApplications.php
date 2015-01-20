<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Granska ansökningar</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<table class="table table-hover">
			      <thead>
			        <tr>
			          <th>#</th>
			          <th>Namn</th>
			          <th>Personnummer</th>
			          <th>Mail</th>
					  <th>Lag</th>
					  <th>Verktyg</th>
			        </tr>
			      </thead>
				  <tbody>

<?php
$result = DBQuery::sql("SELECT * FROM application");
$howMany = count($result);

for($i=0; $i<$howMany; $i++) {
	$name = DBQuery::safeString($result[$i]["name"]);
	$lastName = DBQuery::safeString($result[$i]["last_name"]);
	$ssn = DBQuery::safeString($result[$i]["ssn"]);
	$mail = DBQuery::safeString($result[$i]["mail"]);
	$appId = DBQuery::safeString($result[$i]["id"]);

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
				<td> <button type="button">Godkänn</button>  <button type="button">Neka</button> </td>
			</tr>
	<?php

}

?>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
