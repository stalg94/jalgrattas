<?php
require("konf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}
global $yhendus;

if(!empty($_REQUEST["vormistamine_id"])){
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET luba=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vormistamine_id"]);
    $kask->execute();
}
$kask=$yhendus->prepare(
    "SELECT id, eesnimi, perekonnanimi, teooriatulemus, 
	     slaalom, ringtee, t2nav, luba FROM jalgrattaeksam;");
$kask->bind_result($id, $eesnimi, $perekonnanimi, $teooriatulemus,
    $slaalom, $ringtee, $t2nav, $luba);
$kask->execute();

function asenda($nr){
    if($nr==-1){return ".";} //tegemata
    if($nr== 1){return "korras";}
    if($nr== 2){return "ebaõnnestunud";}
    return "Tundmatu number";
}
?>
<!doctype html>
<html>
<head>
    <title>Lõpetamine</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header class="header">
    <p class="mx-4">Tere tulemast, Õpilane!</p>
    <form action="logout.php" method="post">
        <input class="m-4 p-2 cursor-pointer hover:bg-blue-200 rounded" type="submit" value="Logi välja" name="logout">
    </form>
    <?php include ('navigatsioon_opilane.php');?>
</header>
<div class="container flex justify-center mx-auto">
    <h1 class="mx-5">Tulemused</h1>
</div>
<div class="container flex justify-center mx-auto">
    <div class="flex flex-col">
        <div class="w-full">
            <table class="mx-5 table table-auto border border-collapse">
                <tr class=" bg-blue-200">
                    <th>Eesnimi</th>
                    <th>Perekonnanimi</th>
                    <th>Teooriaeksam</th>
                    <th>Slaalom</th>
                    <th>Ringtee</th>
                    <th>Tänavasõit</th>
                    <th>Lubade väljastus</th>
                </tr>
                <?php
                while($kask->fetch()){
                    $asendatud_slaalom=asenda($slaalom);
                    $asendatud_ringtee=asenda($ringtee);
                    $asendatud_t2nav=asenda($t2nav);
                    $loalahter=".";
                    if($luba==1)
                    {$loalahter="Väljastatud";}
                    else{
                        $loalahter="Loa väljastamata";
                    }

                    echo "
		     <tr>
			   <td>$eesnimi</td>
			   <td>$perekonnanimi</td>
			   <td>$teooriatulemus</td>
			   <td>$asendatud_slaalom</td>
			   <td>$asendatud_ringtee</td>
			   <td>$asendatud_t2nav</td>
			   <td>$loalahter</td>
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