<?php
$result = DBQuery::sql("SELECT * FROM application");
$nResults = count($result);
// echo "reults = " . $nResults;

for($i=0; $i<$nResults; $i++) { 
	$name = $result[$i]["name"];
	$lastName = $result[$i]["last_name"];
	$ssn = $result[$i]["ssn"];
	$mail = $result[$i]["mail"];

	//html lista, knappar etc
	?>

	<!--html-->
	<!-- <link rel="stylesheet" href="css/style.css"> -->
	<div id="application-container">
	<ul>
	<li> <!-- <a href="#"> --> <?php echo $name 	?> <!-- </a> --> </li>
	<li> <!-- <a href="#"> --> <?php echo $lastName ?> <!-- </a> --> </li>
	<li> <!-- <a href="#"> --> <?php echo $ssn 	    ?> <!-- </a> --> </li>
	<li> <!-- <a href="#"> --> <?php echo $mail 	?> <!-- </a> --> </li>
	</ul>

	</div>

	<?php

}

?>
