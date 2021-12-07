<?php
require("konf.php");
global $yhendus;
//include('config.php');
session_start();
if (isset($_SESSION['tuvastamine'])) {
    header('Location: index.php');
    exit();
}

$query = "SELECT * FROM `kasutajad`";
$result1 = mysqli_query($yhendus, $query);

//kontrollime kas väljad on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $sool = 'tavalinetext';
    $kryp = crypt($pass, $sool);
    //kontrollime kas andmebaasis on selline kasutaja ja parool
    $paring = "SELECT kasutaja,onAdmin,koduleht FROM kasutajad WHERE kasutaja=? AND parool=?";
    $kask=$yhendus->prepare($paring);
    $kask->bind_param("ss", $login, $kryp);
    $kask->bind_result($kasutaja, $onAdmin, $koduleht);
    $kask->execute();
    //$valjund = mysqli_query($connection, $paring);
    //kui on, siis loome sessiooni ja suuname
    //if (mysqli_num_rows($valjund)==1) {
    if($kask->fetch()){
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $kasutaja;
        $_SESSION['onAdmin'] =  $onAdmin;
        if(isset($koduleht)){
            header("Location: $koduleht");
        } else {
            header('Location: registreerimine.php');
            exit();
        }
    } else {
        echo "kasutaja $login või parool $kryp on vale";
    }
}



?>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<div class="flex justify-center my-4 text-6xl">
    <h1>Tere tulemast!</h1>
</div>

<div class="flex justify-center px-4">
    <div class=" col-md-4">
    <form action="" method="post">
        <label for="login">Sinu Rool</label>
        <select class="border rounded" name="login">
            <?php while($row1 = mysqli_fetch_array($result1)):;?>
                <option value="<?php echo $row1[1];?>"><?php echo $row1[1];?></option>
            <?php endwhile;?>
        </select>
        <label for="pass">Password</label>
        <input class="border border-blue-800 rounded" type="password" name="pass"><br>
        <input type="submit" value="Logi sisse" class="hover:bg-blue-400 cursor-pointer w-100">
    </form>
    </div>

</div>
