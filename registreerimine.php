<?php
require("konf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}
global $yhendus;
if(isSet($_REQUEST["sisestusnupp"])){

        $kask=$yhendus->prepare(
            "INSERT INTO jalgrattaeksam(eesnimi, perekonnanimi) VALUES (?, ?)");
        $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"]);
        $kask->execute();
        $yhendus->close();
        //header("Location: $_SERVER[PHP_SELF]?lisatudeesnimi=$_REQUEST[eesnimi]");
        header("Location: lubadeleht_opilane.php");
        exit();

}

?>
    <!doctype html>
    <html>
<head>
    <title>Kasutaja registreerimine</title>
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
    <h1 class="mx-5">Registreerimine</h1>
</div>
<?php
if(isSet($_REQUEST["lisatudeesnimi"])){
    echo "Lisati $_REQUEST[lisatudeesnimi]";
}
?>
<div class="container flex justify-center mx-auto">
    <div class="flex flex-col">
        <div class="w-full">
            <form action="?" onSubmit="return validateForm()">
                <dl>
                    <dt>Eesnimi:</dt>
                    <dd><input type="text" name="eesnimi" class="border rounded"  id="eesnimi" /></dd>
                    <dt>Perekonnanimi:</dt>
                    <dd><input type="text" name="perekonnanimi" class="border rounded"  id="perekonnanimi" /></dd>
                    <dt><input type="submit" id="check" name="sisestusnupp" value="sisesta" class="border rounded cursor-pointer p-2 hover:bg-blue-200" onclick="check()" /></dt>
                </dl>
            </form>

        </div>
    </div>
</div>
</body>
<script>
    function validateForm(){
        var perekonnanimi=document.getElementById("perekonnanimi").value;
        var eesnimi=document.getElementById("eesnimi").value;
        if (perekonnanimi=="" && eesnimi==""){
            alert("Eesnimi ja perekonnanimi on vajalikud!");
            return false;
        }
        else if (perekonnanimi==""){
            alert("Perekonnanimi is obligatory");
            return  false;
        } else if (eesnimi=="") {
            alert("Eesnimi is obligatory");
            return false;
        }

    }
</script>
</html>

