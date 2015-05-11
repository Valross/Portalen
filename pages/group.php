<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<?php loadGroupName(); ?>
		</div>
	</div>
	<div class="col-sm-6 page-header-right text-right">
	  <div class="children-float-right">
		  <a href="?page=groups" class="btn btn-page-header header-img"><i class="fa fa-arrow-circle-left fa-fw"></i> Tillbaka till alla lag</a>
		  <?php loadLeaveGroupButton(); ?>
		  <?php loadApplyForGroupButton(); ?>
	</div> <!-- .col-sm-4 -->
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>
			Information
			<?php loadProtocolLink(); ?>
			<?php loadDotLink(); ?>
		</h3>
		<p>
			<?php loadGroupInfo(); ?>
		</p>


		<table class="basic-table">
			<tr>
				<td><strong>Lagchef(er)</strong></td>
				<td><?php loadGroupLeader(); ?></td>
			</tr>
			<?php loadFacebookGroupURL(); ?>
		</table>
		<?php loadApplications(); ?>
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
