<?php
require("konf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}
global $yhendus;
if(!empty($_REQUEST["teooriatulemus"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?");
    $kask->bind_param("ii", $_REQUEST["teooriatulemus"], $_REQUEST["id"]);
    $kask->execute();
}
if(isSet($_REQUEST["kustutasid"])){
    $kask=$yhendus->prepare("DELETE FROM jalgrattaeksam WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustutasid"]);
    $kask->execute();
}
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi 
     FROM jalgrattaeksam WHERE teooriatulemus=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();


?>
<!doctype html>
<html>
<head>
    <title>Teooriaeksam</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header class="header">
    <p class="mx-4">Tere tulemast, Õpetaja!</p>
    <form action="logout.php" method="post">
        <input class="p-2 mx-4 cursor-pointer hover:bg-blue-200 rounded" type="submit" value="Logi välja" name="logout">
    </form>
    <?php include ('navigatsioon.php');?>
</header>
<div class="container flex justify-center mx-auto">
    <h1 class="mx-5">Teooriaeksam</h1>
</div>
<div class="container flex justify-center mx-auto">
    <div class="flex flex-col">
        <div class="w-full">
            <table class="mx-4 table table-auto border border-collapse"">
                <?php
                while($kask->fetch()){
                    echo "
		    <tr>
			  <td>$eesnimi</td>
			  <td>$perekonnanimi</td>
			  <td><form action=''>
			         <input type='hidden' name='id' value='$id' />
					 <input type='text' class='border rounded border-black' name='teooriatulemus' />
					 <input type='submit' class='cursor-pointer hover:bg-blue-200' value='Sisesta tulemus' />
					 <a href='$_SERVER[PHP_SELF]?kustutasid=$id'>Kustuta</a>
			      </form>
			  </td>
             <td></td>
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
