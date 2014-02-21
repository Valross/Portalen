<?php
session_start();
if(!isset($_SESSION['user_id']))
{
	header('Location: login.php');
}

include_once('php/general.php');
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	  <div id="page-container">
		  <div id="sidebar">
			  <!-- begin logo -->
			  <a href="/" class="logo"><img src="img/logo.png"></a>
			  <!-- end Logo -->
			 
			  <div class="your-period">
 					 <p>
 					  <small>Din period: <strong><?php echo $periodStart.' - '.$periodEnd; ?></strong></small>
 					  </p>
					  
					  <div class="progress">
					    <div class="progress-bar worked" style="width: <?php echo $workedPointsPercent ?>%">
						<!--<p> 3p </p>
					      <span class="sr-only">3 arbetade poäng</span>-->
					    </div>
					    <div class="progress-bar booked" style="width: <?php echo $bookedPointsPercent ?>%">
						<!--<p> 3p </p>
					      <span class="sr-only">3 bokade poäng</span> -->
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
		              <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span>Hem</a></li>
		              <li class="dropdown">
		                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>Mitt konto <b class="caret"></b></a>
		                <ul class="dropdown-menu">
		                  <li><a href="#">Arbetade pass</a></li>
		                  <li><a href="#">Meddelanden</a></li>
		                  <li class="divider"></li>
		                  <li class="dropdown-header">Inst�llningar</li>
		                  <li><a href="#">Redigera profil</a></li>
		                  <li><a href="#">Avsluta medlemskap</a></li>
		                </ul>
		              </li>
		              <li><a href="#about"><span class="glyphicon glyphicon-list-alt"></span>Boka pass</a></li>
		              <li><a href="#contact"><span class="glyphicon glyphicon-bullhorn"></span>Nyheter</a></li>
					  <li><a href="#contact"><span class="glyphicon glyphicon-comment"></span>Diskussionsforum</a></li>
					  <li><a href="#contact"><span class="glyphicon glyphicon-globe"></span>Lagsidor</a></li>
		            </ul>
		          </div><!--/.nav-collapse -->
		        
		      </div>
			  
			  
			  
			  <!-- end menu -->
				  
		  </div> 
		  <!-- end sidebar -->

		  <div id="content">
			  <div class="row">
				  <div class="col-sm-12">
					  <span class="glyphicon glyphicon-search"></span>
					  <div class="user-info">
						  <img src="profile.jpg" width="32px" height="32px">
						  <a href="http://google.se" class="username"><span style="font-weight: normal">Inloggad som</span> <?php echo $_SESSION['name'].' '.$_SESSION['last_name']; ?></a>
					  	<a href="login.php" class="sign-out"><span class="glyphicon glyphicon-off"></span></a>
					  </div>
				  </div>
		 	 </div> 
			 <div class="top-div"></div>
   		 	 <!--<div class="row">
				 
				 KOMMANDE PASS = ON�DIGT?
					 
					 <div class="col-sm-12">
				 	<h4 style="font-weight: 200;">Kommande pass</h4>
					<?php
						loadUpcomingEvents($date);
					?>
			 	 </div>
   		 	 </div> -->
   		 	 <div class="row">
				 <div class="col-sm-5">
					 <div class="row">
						 <div class="col-sm-12"><h3>Dina bokade pass</h3>
							<?php loadBookedEvents(); ?>
							
							<div class="list-group">
							  <a href="#" class="list-group-item"><span class="badge">4 lediga platser</span><strong class="list-group-item-date-floated-left">27/2</strong> Webblagsm�te</a>
							</div>
							
						 </div>
						 <div class="col-sm-12"><h3>Lediga pass</h3>
						 
							 <div class="list-group">
							   <a href="#" class="list-group-item"><span class="badge">8 lediga platser</span><strong class="list-group-item-date-floated-left">27/2</strong> Kravallpub</a>
							   <a href="#" class="list-group-item"><span class="badge">48 lediga platser</span><strong class="list-group-item-date-floated-left">9/3</strong> Personalfest!</a>
							   <a href="#" class="list-group-item"><span class="badge">4 lediga platser</span><strong class="list-group-item-date-floated-left">6/3</strong> Webblagsm�te</a>
							   <a href="#" class="list-group-item"><span class="badge">13 lediga platser</span><strong class="list-group-item-date-floated-left">13/3</strong> St Patricks Day</a>
							 </div>
							 
						 </div>
				 	</div>
				 </div>
				 <div class="col-sm-7">
					 <h1>En helgrym H1-rubrik. Light 36px</h1>

					 <p>Hej! Terminen har dragit ig�ng och det finns n�gra pass kvar i januari att fylla. Framf�rallt p� Vinterkravallen och Nollefesten, d�r beh�ver vi dessutom allapass som vem som helst kan jobba som! Annars finns det nu pass f�r februari, och som vanligt g�ller det att jobba 8 po�ng eller motsvarande f�r att f� personalf�rm�ner. 
						 
<h2>En H2-rubrik som �r smal. Light 30px</h2>
Ny termin betyder ocks� ny personal, onsdagen den 5/2 kl 18 kommer vi ha infokv�ll p� Trappan! S� om ni k�nner n�gon som �r sugen p� att b�rja men vill ha mer information om lagen och Trappan - tipsa dem om infokv�llen!

<h3>Sen har vi H3 ocks�. Light 24px</h3>
<h4>Och en H4. Bold 18px</h4>
Dagen innan infokv�llen, allts� tisdagen 4/2, vill vi ist�llet hylla er som redan jobbar p� Trappan genom att ha personalpub! Denna g�ng �r det marknadsf�ringslaget och barlaget som ska anordna, mer information kommer inom kort.Hej! Terminen har dragit ig�ng och det finns n�gra pass kvar i januari att fylla. Framf�rallt p� Vinterkravallen och Nollefesten, d�r beh�ver vi dessutom allapass som vem som helst kan jobba som! Annars finns det nu pass f�r februari, och som vanligt g�ller det att jobba 8 po�ng eller motsvarande f�r att f� personalf�rm�ner. N�sta personalfest �r i mars, s� f�r att f� g� p� den m�ste man ha jobbat sina po�ng i b�de dec/jan och februari! Alternativt vara nybyggare och aldrig ha g�tt p� en personalfest innan.
<h5>En H5-rubrik kommer h�r. Bold 14px</h5>
<h6>En H6-rubrik kommer h�r. Bold 12px</h6>
Ny termin betyder ocks� ny personal, onsdagen den 5/2 kl 18 kommer vi ha infokv�ll p� Trappan! S� om ni k�nner n�gon som �r sugen p� att b�rja men vill ha mer information om lagen och Trappan - tipsa dem om infokv�llen!

Dagen innan infokv�llen, allts� tisdagen 4/2, vill vi ist�llet hylla er som redan jobbar p� Trappan genom att ha personalpub! Denna g�ng �r det marknadsf�ringslaget och barlaget som ska anordna, mer information kommer inom kort</p></div>
   		 	 </div>
			 
   	 	</div> <!-- end #content -->
	</div> <!-- #page-container -->
	
	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
