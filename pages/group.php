<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadAvatar(); ?>" width="100" height="100" class="page-header-img">
			<h1 class="header-img"><?php loadGroupName(); ?></h1> 
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Om</h3>
	<p><?php echo $groupDescription; ?></p>
	<table class="basic-table">
		<tr>
			<td><strong>Antal medlemmar</strong></td>
			<td>x</td>
		</tr>
	</table>

		<h3>Kontaktinformation</h3>
		<table class="basic-table">
			<tr>
				<td><strong>Mailadress</strong></td>
				<td><?php echo $profileMail; ?></td>
			</tr>
			<tr>
				<td><strong>Hemsida</strong></td>
				<td>Denna trololololol</td>
			</tr>
		</table>
	</div> <!-- .white-box -->
</div> <!-- col-sm-6 -->
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Medlemmar</h3>
			<?php loadMembersOfGroup(); ?>
		</div>
	</div>
</div> <!-- .row -->

<div class="col-sm-4 text-right page-header-right">
	<select class="form-control">
		<option id="typeno" value="no">Hoppa till lag</option>
	    <?php loadAllGroupsOption(); ?>
	</select>
</div>