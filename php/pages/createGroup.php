<?php
include_once('php/DBQuery.php');

if(checkAdminAccess())
	loadAll();
else
	{
		?>
		<script>
			window.location = "?page=start";
			alert("Sluta försöka hacka sidan!")
		</script>
	<?php
}

if(isset($_POST['submit']))
{
	$groupName = $_POST['groupName'];
	$id = $_POST['id'];
	$facebookGroup = $_POST['facebookGroup'];
	$description = $_POST['description'];

	if($groupName != '')
	{
		DBQuery::sql("INSERT INTO work_group 
						(name, facebook_group, description)
						VALUES ('$groupName', '$facebookGroup', '$description')");
	}
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>Skapa Lag</h1>
				</div>
			</div>
		</div> <!-- .row -->';

	loadCreateGroupTools();
}

function loadCreateGroupTools()
{
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="groupName">Lagnamn</label>
			<input type="text" name="groupName" id="groupName" value="">
			<label for="facebookGroup">Facebookgrupp</label>
			<input type="text" name="facebookGroup" id="facebookGroup" value="">
			<label for="description">Beskrivning</label>
			<textarea rows="6" cols="50" name="description" id="description" class="bottom-border"></textarea>
			<input type="hidden" name="id" id="id" value="">';


	echo '<input type="submit" name="submit" value="Skapa">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>