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
	$id = $_POST['id'];
	$name = $_POST['name'];
	$points = $_POST['points'];
	$description = $_POST['description'];
	$icon = $_POST['icon'];

	if($name != '')
	{
		DBQuery::sql("UPDATE achievement
				  SET name = '$name', points = '$points', 
				  description = '$description', icon = '$icon'
				  WHERE id = '$id'");
		?>
		<script>
			window.location = "?page=createAchievement";
		</script>
		<?php
	}
}

if(isset($_POST['add']))
{
	DBQuery::sql("INSERT INTO achievement 
					(name, points, description, icon)
					VALUES ('Obestämd', '5', '', '')");
	?>
	<script>
		window.location = "?page=createAchievement";
	</script>
	<?php
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1><span class="fa fa-trophy fa-fw fa-lg"></span>Hantera <a href="?page=achievements">Achievements</a></h1>
				</div>
			</div>
		</div> <!-- .row -->';

	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="achievement">Achievements</label>
			<select name="achievement" id="achievement" class="bottom-border">
				<option id="typeno" value="typeno">Välj Achievement</option>';
	loadAllAchievementsAsOption();
	echo '</select>
		<input type="submit" name="chooseAchievement" value="Välj">
		<input type="submit" name="add" value="Lägg till">';

	
	echo 			'</div>
				</form>
			</div>
		</div>';

	if(isset($_POST['chooseAchievement']))
	{
		$achievement = $_POST['achievement'];
		if($achievement != '')
			loadCreateAchievementTools($achievement);
	}
}

function loadAllAchievementsAsOption()
{
	$achievements = DBQuery::sql("SELECT id, name FROM achievement ORDER BY name");
	for($i = 0; $i < count($achievements); ++$i)
	{
		?>
			<option value="<?php echo $achievements[$i]['id']; ?>"><?php echo $achievements[$i]['name']; ?></option>
		<?php
	}
}

function loadCreateAchievementTools($achievement)
{
	$achievement_name = DBQuery::sql("SELECT id, name, description, icon, points FROM achievement 
						WHERE id = '$achievement'");
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="name">Achievementnamn</label>
			<input type="text" name="name" id="name" value="'.$achievement_name[0]['name'].'">
			<label for="points">Poäng <span class="fa fa-diamond fa-fw fa-lg"></span></label>
			<input type="text" name="points" id="points" value="'.$achievement_name[0]['points'].'">
			<label for="icon">Ikon <span class="fa fa-cloud fa-fw fa-lg"></span></label>
			<input type="text" name="icon" id="icon" placeholder="fa fa-cloud fa-fw fa-lg" value="'.$achievement_name[0]['icon'].'">
			<label for="description">Beskrivning</label>
			<textarea rows="6" cols="50" name="description" id="description" class="bottom-border">'.$achievement_name[0]['description'].'</textarea>
			<input type="hidden" name="id" id="id" value="'.$achievement_name[0]['id'].'">';

	echo '<input type="submit" name="submit" value="Spara">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>