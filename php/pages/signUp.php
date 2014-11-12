<?php
include_once('php/DBQuery.php');
include_once('php/general.php');
include_once('php/pageManager.php');

if(isset($_POST['submit'])){

  $firstName = DBQuery::safeString($_POST['firstName']);
  $lastName = DBQuery::safeString($_POST['lastName']);
  $liuId = DBQuery::safeString($_POST['liuId']);
  $mail = DBQuery::safeString($_POST['mail']);
  $ssn = DBQuery::safeString($_POST['ssn']);

  $aTeam = $_POST['team'];
  if(empty($aDoor)){
    echo("Inga lag valda");
  }
  else{
    $N = count($aTeam);
    echo("$N lag valda: ");
    for($i=0; $i < $N; $i++){
      echo htmlspecialchars($aTeam[$i] ). " ";
    }
  }

}



?>
