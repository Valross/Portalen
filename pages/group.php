<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1 class="header-img"><?php loadGroupName(); ?> - <a href="?page=groups">Alla lag</a></h1> 
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Information</h3>
		<p>
			<?php loadGroupInfo(); ?>
		</p>


		<table class="basic-table">
			<tr>
				<td><strong>Lagchef(er)</strong></td>
				<td><?php loadGroupLeader(); ?></td>
			</tr>
			<tr>
				<td><strong>Facebookgrupp</strong></td>
				<td><?php loadFacebookGroupURL(); ?></td>
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
