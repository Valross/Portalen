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
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="css/style.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui-1.10.4.custom.css">
	<link rel="stylesheet" href="css/jquery-ui-timepicker-addon.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<script src="https://code.jquery.com/jquery.js"></script>
  </head>
  <body>
	  <div id="page-container">
		  <div id="sidebar" style="overflow:auto;" >
			  <!-- begin logo -->
			  <a href="/" class="logo"><img src="img/logo.png"></a>
			  <!-- end Logo -->
			 
			  <div class="your-period">
 					 <p>
 					  <small>Din period: <strong><?php echo $periodStart.' - '.$periodEnd; ?></strong></small>
 					  </p>
					  
					  <div class="progress">
						  
					    <div class="progress-bar worked" rel='tooltip' title="Arbetat: <?php echo $workedPoints; ?> poäng" style="width: <?php echo $workedPointsPercent; ?>%">
					    </div>
						
					    <div class="progress-bar booked" rel='tooltip'  title="Bokat: <?php echo $bookedPoints; ?> poäng" style="width:<?php echo $bookedPointsPercent; ?>%">
					    </div>
						
						
 						<div class="progress-bar remaining" rel='tooltip' title="Ej bokat: <?php echo $emptyPoints; ?> poäng" style="width: <?php echo $emptyPointsPercent; ?>%">
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
		              <li class="panel dropdown">
					<a data-toggle="collapse" data-parent="#menu-bar" href="#collapseOne"><span class="fa fa-user fa-fw fa-lg"></span>Mitt Konto<span class="chevron_toggleable fa fa-chevron-down"></span></a>
						  <ul id="collapseOne" class="panel-collapse collapse">
						  <li><a href="?page=profile"><span class="fa fa-user fa-fw"></span>Min profil</a></li>
						  <li><a href="#"><span class="fa fa-envelope-o fa-fw"></span>Meddelande</a></li>
						  <li><a href="?page=editProfile"><span class="fa fa-cog fa-fw"></span>Redigera profil</a></li>
						  <li><a href="#"><span class="fa fa-trash-o fa-fw"></span>Avsluta medlemskap</a></li>
						  </ul>
		              </li>
		               <li class="panel dropdown">
					<a data-toggle="collapse" data-parent="#menu-bar2" href="#collapseTwo"><span class="fa fa-gears fa-fw fa-lg"></span>Adminverktyg<span class="chevron_toggleable fa fa-chevron-down"></span></a>
						  <ul id="collapseTwo" class="panel-collapse collapse">
							<li><a href="?page=createEvent"></span>Skapa evenemang</a></li>
							<li><a href="?page= #"></span>Hantera eventmallar</a></li>
							<li><a href="?page=createAccount"></span>Skapa nytt konto</a></li>
							<li><a href="?page=createNews"></span>Skapa en nyhet</a></li>
							<li><a href="?page=reviseApplications"></span>Granska ansökningar</a></li>
							<li><a href="?page= #"></span>Statistik</a></li>
							<li><a href="?page= #"></span>Personallistor</a></li>
							<li><a href="?page= #"></span>Specialkost</a></li>
							<li><a href="?page= #"></span><---DA Verktyg ---></a></li>
							<li><a href="?page= #"></span>Checka av pass</a></li>
							<li><a href="?page=DAnote"></span>DA-lappar</a></li>


						  </li>  
						  </ul>
		            
		              <li><a href="?page=book" onclick="location.reload()"><span class="fa fa-book fa-fw fa-lg"></span>Boka pass</a></li>
		              <li><a href="?page=news"><span class="fa fa-newspaper-o fa-fw fa-lg"></span>Nyheter</a></li>
					  <li><a href="?page=groups"><span class="fa fa-users fa-fw fa-lg"></span>Lagsidor</a></li>

		            </ul>
		          </div><!--/.nav-collapse -->
		        
		      </div>
			  
			  
			  
			  <!-- end menu -->
				  
		  </div> 
		  <!-- end sidebar -->

		  <div id="content">
			  <div class="row">
				  <div class="col-sm-4 search">
					  <button type="submit" class="btn"><span class="fa fa-search"></span></button>
				  		<input type="search" class="form-control" placeholder="Sök på portalen...">
				  </div> <!-- col-sm-4 -->
					  
				  	<div class="col-sm-8">
					  <div class="user-info">
						  <img src="<?php echo loadAvatar(); ?>" class="avatar-32x32" width="32px" height="32px">
						  <a href="?page=profile" class="username"><span style="font-weight: normal">Inloggad som</span> <?php echo $_SESSION['name'].' '.$_SESSION['last_name']; ?></a>
					  	<a href="login.php" class="sign-out"><span class="fa fa-power-off"></span></a>
					  </div>
				  </div>
		 	 </div> 
			 <div class="top-div"></div>
   		 	 

   		 	 <div class="row">
				<?php content(); ?>
   		 	 </div>
			 
		  <div class="row">
			  <div id="footer">
			  <div class="col-sm-13">
				  <p>Trappans Personalportal 2014. <a href="?page=about">Om portalen</a>. <br />Kontakta Trappans <a href="#">webbansvarig</a> vid problem eller frågor.
			  </div>
		 	  </div> <!-- #footer -->
		  </div>
			 
   	 	</div> <!-- end #content -->
	</div> <!-- #page-container -->
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/ui-datepicker.js"></script>
	<script src="js/ui_timepicker-addon.js"></script>

		<!-- Datepicker -->
		<script>
			$(function() {
			$( ".datepicker" ).datetimepicker();
			});
		</script>
	
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
  $(function() {
    $( document ).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );

        }
      }
    });
  });
  </script>
  </body>
</html>
