<?php
session_start();
if(!isset($_SESSION['user_id']))
{
	header('Location: login.php');
}

include_once('php/general.php');
include_once('php/pageManager.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Trappans personalportal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="css/calendar.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/search.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	  
		  <div id="sidebar">
			  <a href="/" class="logo"><img src="img/logo.png"></a>
			 
			  <div class="your-period">
 					 <p>
 					  <small>Din period: <strong><?php echo $periodStart.' - '.$periodEnd; ?></strong></small>
 					  </p>
					  <div class="progress">
					    <div class="progress-bar worked" data-toggle="tooltip" data-placement="top" title="Arbetat: <?php echo $workedPoints; ?> poäng" style="width: <?php echo $workedPointsPercent; ?>%">
					    </div>	
					    <div class="progress-bar booked" data-toggle="tooltip" data-placement="top"  title="Bokat: <?php echo $bookedPoints; ?> poäng" style="width:<?php echo $bookedPointsPercent; ?>%">
					    </div>
 						<div class="progress-bar remaining" data-toggle="tooltip" data-placement="top" title="Ej bokat: <?php echo $emptyPoints; ?> poäng" style="width: <?php echo $emptyPointsPercent; ?>%">
 					   	</div>
					  </div> <!-- .progress -->
			  </div> <!-- .your-period -->

			  <!-- begin menu -->
			   <!-- Fixed navbar -->
		      <div class="main-menu-wrapper" role="navigation">
		          <div class="navbar-header">
		            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		              <span class="sr-only">Toggle navigation</span>
		              <span class="icon-bar"></span>
		              <span class="icon-bar"></span>
		              <span class="icon-bar"></span>
		            </button>
		          </div>

		          <div class="navbar-collapse collapse">
		            <ul class="main-nav">
			              <li class="active"><a href="?page=start"><span class="fa fa-home fa-fw fa-lg"></span>Hem</a></li>   
			              <li><a href="?page=book" onclick="location.reload()"><span class="fa fa-book fa-fw fa-lg"></span>Boka pass</a></li>
						  <li><a href="?page=groups"><span class="fa fa-users fa-fw fa-lg"></span>Lagsidor</a></li>
			              <li><a href="?page=news"><span class="fa fa-newspaper-o fa-fw fa-lg"></span>Nyheter</a></li>
			              <li><a href="?page=stats"><span class="fa fa-pie-chart fa-fw fa-lg"></span>Statistik</a></li>
			              <li><a href="?page=achievements"><span class="fa fa-trophy fa-fw fa-lg"></span>Achievements</a></li>
	  		               
		            <?php 
			            if(checkAdminAccess())
			            {
		            ?>
	  		               <li class="panel dropdown">
	  					<a data-toggle="collapse" data-parent="#menu-bar2" href="#collapseTwo"><span class="fa fa-gears fa-fw fa-lg"></span>Adminverktyg<span class="chevron_toggleable fa fa-chevron-down"></span></a>
	  						  <ul id="collapseTwo" class="panel-collapse collapse">
	  							<li><a href="?page=checkPasses"><span class="fa fa-check-square-o fa-fw fa-lg"></span>Checka av pass</a></li>
	  							<li><a href="?page=createDANote"><span class="fa fa-pencil fa-fw fa-lg"></span>Skriv DA-lapp</a></li>
	  							<li><a href="?page=createHeadWaiterNote"><span class="fa fa-pencil fa-fw fa-lg"></span>Skriv Hovis-lapp</a></li>
	  							<li><a href="?page=browseDANote"><span class="fa fa-user-secret fa-fw fa-lg"></span>Läs DA-lappar</a></li>
	  							<li><a href="?page=browseHeadWaiterNote"><span class="fa fa-user-secret fa-fw fa-lg"></span>Läs Hovis-lappar</a></li>
	  							<li><a></a></li>

	  							<li><a href="?page=createEvent"><span class="fa fa-calendar fa-fw fa-lg"></span>Skapa evenemang</a></li>
	  							<li><a href="?page=createNews"><span class="fa fa-newspaper-o fa-fw fa-lg"></span>Skriv nyhet</a></li>
	  							<li><a href="?page=reviseApplications"><span class="fa fa-user-plus fa-fw fa-lg"></span>Ansökningar</a></li>
	  							<li><a href="?page=staffList"><span class="fa fa-list fa-fw fa-lg"></span>Personallista</a></li>
	  							<li><a href="?page=createAccount"><span class="fa fa-user-plus fa-fw fa-lg"></span>Skapa nytt konto</a></li>
	  							<li><a href="?page=manageEventTemplate"><span class="fa fa-table fa-fw fa-lg"></span>Eventmallar</a></li>
	  							<li><a href="?page=period"><span class="fa fa-calendar-o fa-fw fa-lg"></span>Perioder</a></li>
	  							<li><a href="?page=DC"><span class="fa fa-gavel fa-fw fa-lg"></span>DC-Verktyg</a></li>
	  						  </li>  
	  						  </ul>
					<?php 
	  					}
					?>
		            </ul>
		          </div><!--/.nav-collapse -->
		      </div> <!-- end menu -->  
		  </div> <!-- end sidebar -->
		  
		  	<div id="topbar">
				<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6" id="search"> <!-- "php/pages/searchPage.php?go" -->
						<form  method="post" action="?page=searchPage"  id="searchform"> 
							<button type="submit" name="submitSearch"><span class="fa fa-search"></span></button>
							
							<!-- search field -->
							<input type="search" name="search_term" id="search-live" placeholder="Sök på portalen..." autocomplete="off">
						</form>
					</div>
					<div class="col-sm-6 text-right">
					<div class="dropdown">
						<button class="user-dropdown-btn dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-expanded="true">
							<img src="<?php echo loadAvatar(); ?>" class="img-circle" width="32" height="32">
							<?php echo $_SESSION['name'].' '.$_SESSION['last_name']; ?> <span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu is-floated-parent dropdown-menu-right" role="menu" aria-labelledby="userDropdown">
						    <li role="presentation"><a role="menuitem" href="?page=userProfile&id=<?php echo $_SESSION['user_id']; ?>"><span class="fa fa-user fa-fw"></span> Min profil</a></li>
							<li role="presentation"><a role="menuitem" href="?page=workedEvents"><span class="fa fa-history fa-fw"></span> Arbetade pass</a></li>
						    <li role="presentation"><a role="menuitem" href="?page=editProfile"><span class="fa fa-cog fa-fw"></span> Inställningar</a></li>
							<li role="presentation" class="divider"></li>
						    <li role="presentation"><a role="menuitem" href="logout.php"><span class="fa fa-power-off fa-fw"></span> Logga ut</a></li>
						  </ul>
					</div> <!-- .dropdown -->
					
					<div class="notifications">
						<a href="?page=browseUserNotifications&user_id=<?php echo $_SESSION['user_id']; ?>" 
							data-toggle="tooltip" data-placement="bottom" title="<?php loadAmountOfUnseenNotifications(); ?> oläst händelse"> 
							<i class="fa fa-globe"></i>
						    <span class="badge on-top-of-element"><?php loadAmountOfUnseenNotifications(); ?></span>
						</a>
					</div>
					
					</div>
				</div> <!-- .row -->
				</div>
			</div> <!-- #topbar -->




			  <div id="search-result">
				  <div class="search-result-container">
			  	<div class="container-fluid">
					
					<!-- 
						##############
						HÅRDKODAD SÖKRESULTATSLISTA 
						##############
						
						
					<div class="col-sm-4">
						<h3>Evenemang</h3>
						<div class="list-group">											
							<a href="?page=group&id=13" class="list-group-item with-thumbnail">
								<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>
								Ett evenemang
							</a>
							<a href="?page=group&id=4" class="list-group-item with-thumbnail">
								<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>
								som är helt
							</a>
							<a href="?page=group&id=7" class="list-group-item with-thumbnail">
								<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>
								Crayzay
							</a>
						</div>
					</div>
					<div class="col-sm-4">
						<h3>Användare</h3>
						<div class="list-group">											
							<a href="?page=group&id=13" class="list-group-item with-thumbnail">
								<img src="img/avatars/portalen_bild.jpg" class="img-circle list-group-thumbnail" width="32" height="32">
								Namn Namnsson
							</a>
							<a href="?page=group&id=4" class="list-group-item with-thumbnail">
								<img src="img/avatars/portalen_bild.jpg" class="img-circle list-group-thumbnail" width="32" height="32">
								Bjärka Gunnarsdotter
							</a>
							<a href="?page=group&id=7" class="list-group-item with-thumbnail">
								<img src="img/avatars/portalen_bild.jpg" class="img-circle list-group-thumbnail" width="32" height="32">
								Wooop Antonsson
							</a>
						</div>
					</div>
					<div class="col-sm-4">
						<h3>Lag</h3>
						<div class="list-group">											
							<a href="?page=group&id=13" class="list-group-item with-thumbnail">
								<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>
								Alla
							</a>
							<a href="?page=group&id=4" class="list-group-item with-thumbnail">
								<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>
								Bartastic
							</a>
							<a href="?page=group&id=7" class="list-group-item with-thumbnail">
								<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>
								Dagsansvarig
							</a>
						</div>
					</div>
					
					###########
					SLUT PÅ HÅRDKODAT -->
					
					<!-- show results after search input -->
					<h4 id="results-text">Showing results for: <b id="search-string">Array</b></h4>
					<ul id="results"></ul>
					
				</div> <!-- .container-fluid -->
				</div> <!-- .search-result-container -->
			  </div> <!-- #search-result -->




		  <div id="content">
			  	     		 
			  <div class="container-fluid">
					<?php content(); ?>  
			  </div>
			<div class="push"></div>
		  </div> <!-- end #content -->
		
		  <div id="footer">
			  <div class="container-fluid">
			  <div class="row">
				  <div class="col-sm-12">
					  <p>Trappans Personalportal. <br />Kontakta Trappans <a href="#">webbansvarig</a> vid problem eller frågor.
				  </div>
			</div> <!-- .row -->
			</div>
		  </div> <!-- #footer -->
		  
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	
	<!-- datetimepicker -->
	<script src="js/moment.js"></script>
	<script src="js/locale/sv.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	
    <script type="text/javascript">
        $(function () {
            $('.datetimepicker').datetimepicker({
				language: 'sv',
				icons: {
		        	time: "fa fa-clock-o",
		            date: "fa fa-calendar",
		            up: "fa fa-arrow-up",
		           	down: "fa fa-arrow-down"
				}
			});
        });
    </script>
	
	<!-- Bootstrap calendar -->
	<script src="js/language/sv-SE.js"></script>
	<script src="js/underscore-min.js"></script>
	<script src="js/jstz.min.js"></script>
	<script src="js/calendar.js"></script>
	<script src="js/calendar-app.js"></script>

	<!-- Collapsing Bars -->
		<script type="text/javascript">
				(function($) {
				var $window = $(window),
				$html = $('#menu-bar');
			$('[data-toggle=collpse]').click(function(){
    		$(this).find(".chevron_toggleable").toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
			});
				$window.resize(function resize() {
				if ($window.width() < 768) {
			   return $html.removeClass('nav-stacked');
			}
				$html.addClass('nav-stacked');
				}).trigger('resize');
				})(jQuery);
		</script>

<!-- Tooltip -->
		  <script>
				$(function () {
				  $('[data-toggle="tooltip"]').tooltip()
				})
 		</script>
  </body>
</html>
