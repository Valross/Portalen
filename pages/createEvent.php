<?php
	if(checkAdminAccess() == 1)
	{
?>
<script>
//Global variables
var countSlots = 0;
Date.prototype.yyyymmdd = function() {         
                                
        var yyyy = this.getFullYear().toString();                                    
        var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
        var dd  = this.getDate().toString();             
                            
        return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
   };  
function getTemplate(id)
{
	if(window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var jsonObj = JSON.parse(xmlhttp.responseText);
			var date = new Date();
			var jsonSlots = jsonObj.slots;
			$("#type" + jsonObj.type).attr("selected", "selected");
			$("#start").val($("#start").val().substring(0,10) + " " + jsonObj.start);
			console.log($("#start"));
			date.setFullYear($("#start").val().substring(0,4),$("#start").val().substring(5,7),$("#start").val().substring(8,10));
			$("#added_groups").html("");
			var endDate = new Date();
			if(jsonObj.end < jsonObj.start)
			{
				endDate.setDate(date.getDate() + 1);
			}
			
			$("#end").val(endDate.yyyymmdd() + " " + jsonObj.end);
			
			for(var i = 0; i < jsonSlots.length; ++i)
			{
				var slotStart = $("#start").val().substring(0,10) + ' ' + jsonSlots[i].start.substring(3);
				var slotEndDate = new Date();
				var slotStartDate = new Date();
				var slotEnd = $("#end").val().substring(0,10);
				slotEndDate.setFullYear(slotEnd.substring(0,4),slotEnd.substring(5,7),slotEnd.substring(8,10));
				slotStartDate.setFullYear(slotStart.substring(0,4),slotStart.substring(5,7),slotStart.substring(8,10));
				var daysAhead = jsonSlots[i].end.substr(0,2) - jsonSlots[i].start.substr(0,2);
				slotEndDate.setMonth(slotEndDate.getMonth() - 1);
				slotEndDate.setDate(slotStartDate.getDate() + daysAhead);
				slotEnd = slotEndDate.yyyymmdd() + ' ' + jsonSlots[i].end.substring(3);
				$("#added_groups").append("<p id='slot" + countSlots + "'>"
					+ "<input type='text' value='" + jsonSlots[i].group + "' name='slotGroups[]' style='border:0px;' size='18' readonly />"
					+ "<input class='datepicker' type='text' value='" + slotStart + "' name='slotStarts[]' />"
					+ "<input class='datepicker' type='text' value='" + slotEnd + "' name='slotEnds[]' />"
					+ "<input type='number' value='" + jsonSlots[i].points + "' name='slotPoints[]' style='width:40px;' />"
					+ "<button type='button' onclick='removeSlot(" + countSlots + ")'>X</button></p>");
				++countSlots;
			}
		}
	}
	xmlhttp.open("GET","php/askTemplate.php?template_id="+id, true);
	xmlhttp.send();
}
function addGroup()
{
	var group = $("#group option:selected").text();
	var start = $("#slot_start").val();
	var end = $("#slot_end").val();
	var points = $("#slot_points").val();
	var amount = $("#group_amount").val();
	for(var i = 0; i < amount; ++i)
	{
		$("#added_groups").append("<p id='slot" + countSlots + "'>"
			+ "<input type='text' value='" + group + "' name='slotGroups[]' style='border:0px;' size='18' readonly />"
			+ "<input class='datepicker' type='text' value='" + start + "' name='slotStarts[]' />"
			+ "<input class='datepicker' type='text' value='" + end + "' name='slotEnds[]' />"
			+ "<input type='number' value='" + points + "' name='slotPoints[]' style='width:40px;' />"
			+ "<button type='button' onclick='removeSlot(" + countSlots + ")'>X</button></p>");
		++countSlots;
	}
}
function removeSlot(id)
{
	$("#slot" + id).remove();
}
</script>

<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-calendar fa-fw fa-lg"></span> Skapa evenemang
			 - <a href="?page=multiEventCreate"><span class="fa fa-calendar fa-fw fa-lg"></span>Multieventskapare</a>
			</h1>
		</div>
	</div>
</div> <!-- .row -->

<form action="" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Evenemangsinformation</h3>

			<label for="template">Mall</label>
			<select name="template" id="template" onchange="getTemplate(this.value)">
				<option value="no">Ingen mall</option>
				<?php loadTemplates(); ?>
			</select>
			
			<label for="type">Evenemangstyp</label>
			<select name="type" id="type">
				<option id="typeno" value="no">Välj typ</option>
				<?php loadTypes(); ?>
			</select>

			<div class="input-group date datetimepicker">
				<label for="start">Starttid</label>
				<input id="start" type="text" name="start" value="<?php echo $dateNoTime; ?>">
		        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
			</div>
				
			<div class="input-group date datetimepicker">
				<label for="end">Sluttid</label>
				<input id="end" type="text" name="end" value="<?php echo $dateNoTime; ?>">
				<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
			</div>
			
			<label for="name">Namn</label>
			<input type="text" name="name" id="name">
			<label for="info">Beskrivning</label>
			<textarea rows="6" name="info" id="info" class="bottom-border"></textarea>
			
			<input type="submit" name="submit" value="Skapa evenemang">
		</div> <!-- .white-box -->
	</div> <!-- .col-sm-6 -->
</div> <!-- .row -->			
</form>
<?php
	}
	else
	{
		?>
			<script>
				window.location = "?page=start";
				alert("Sluta försöka hacka sidan!")
			</script>
		<?php
	}
?>