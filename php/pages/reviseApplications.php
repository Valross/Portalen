<?php
echo "test";

//temp problem
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once "$root/portalen/php/DBQuery.php";
include_once("$root/portalen/php/general.php");
include_once("$root/portalen/php/pageManager.php");

if(isset($_POST['submit'])){

  $firstName = DBQuery::safeString($_POST['firstName']);
  $lastName = DBQuery::safeString($_POST['lastName']);
  $liuId = DBQuery::safeString($_POST['liuId']);
  $mail = DBQuery::safeString($_POST['mail']);
  $ssn = DBQuery::safeString($_POST['ssn']);

  $aTeam = $_POST['team'];
  if(empty($aTeam)){
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
