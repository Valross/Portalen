<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadAvatar(); ?>" width="100" height="100" class="page-header-img">
			<h1 class="header-img"><?php loadGroupName(); ?></h1> 
		</div>
	</div>
	<div class="col-sm-4 text-right page-header-right">
		<select class="form-control">
			<option id="typeno" value="no">Hoppa till lag</option>
		    <?php loadAllGroupsOption(); ?>
		</select>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Information</h3>
	<p><?php echo $groupDescription; ?></p>


		<table class="basic-table">
			<tr>
				<td><strong>Lagchef(er)</strong></td>
				<td>eller ska lagchefer skrivas ut på ngt tydligare vis?</td>
			</tr>
			<tr>
				<td><strong>Facebookgrupp</strong></td>
				<td>många lag har ju faktiskt grupper där man sköter kommunikationen</td>
			</tr>
		</table>
	</div> <!-- .white-box -->
</div> <!-- col-sm-6 -->
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Medlemmar (<?php echo $nMembers; ?>)</h3>
			<div class="list-group">
			<?php loadMembersOfGroup(); ?>
			</div>
		</div>
	</div>
</div> <!-- .row -->
