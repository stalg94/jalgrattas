<?php
require("konf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}
global $yhendus;
if(!empty($_REQUEST["korras_id"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET t2nav=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["korras_id"]);
    $kask->execute();
}
if(!empty($_REQUEST["vigane_id"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET t2nav=2 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vigane_id"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE slaalom=1 AND ringtee=1 AND t2nav=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html>
<head>
    <title>Tänavasõit</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header class="header">
    <p class="mx-4">Tere tulemast, Õpetaja!</p>
    <form action="logout.php" method="post">
        <input class="mx-4 p-2 cursor-pointer hover:bg-blue-200 rounded" type="submit" value="Logi välja" name="logout">
    </form>
    <?php include ('navigatsioon.php');?>
</header>
<div class="container flex justify-center mx-auto">
    <h1 class="mx-5">Tänavasõit</h1>
</div>

<div class="container flex justify-center mx-auto">
    <div class="flex flex-col">
        <div class="w-full">
            <table class="table table-auto border border-collapse">
                <?php
                while($kask->fetch()){
                    echo "
		    <tr>
			  <td>$eesnimi</td>
			  <td>$perekonnanimi</td>
			  <td>
			    <a href='?korras_id=$id' class='hover:text-blue-200'>Korras</a>
			    <a href='?vigane_id=$id' class='text-red-600 hover:text-red-200'>Ebaõnnestunud</a>
			  </td>
			</tr>
		  ";
                }
                ?>
            </table>
        </div>
    </div>
</div>


</body>
</html>
