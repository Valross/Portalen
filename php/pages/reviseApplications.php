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
			        <tr>
			          <th scope="row">1</th>
			          <td>Någon Persson</td>
			          <td>9405092199</td>
			          <td>hallå@eller.se</td>
					  <td>Webb, Marknadsföring, Event</td>
					  <td>Verktyg</td>
			        </tr>
			        <tr>
			          <th scope="row">2</th>
			          <td>Inge Glid</td>
			          <td>4501019999</td>
			          <td>ingespam@tack.nu</td>
					  <td>Bar</td>
					  <td>Verktyg</td>
			        </tr>
			      </tbody>
			    </table>
		</div>
	</div>
</div>

(Sorry Jonathan för att jag dissade din tabell! Lämnade kvar den så länge)




<table style="width:100%" id="application-table">
	<tr>
		<th>Namn</th>
		<th>Personnummer</th>
		<th>Mail</th>
		<th>Lag</th>
		<th>Verktyg</th>
	</tr>

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
<!-- 		<div id="application-container">
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
		</div> -->
			<tr>
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

</table>
