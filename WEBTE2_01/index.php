<?php

if($_GET['folder']){
    $dir = $_GET['folder'];
    var_dump($dir);
}
else {
    $dir = 'files/';
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Zadanie 1</title>
</head>
<body>
    <?php
        $subory = scandir($dir);
        echo "<table class='sortable'>
                <tr>
                    <th>Meno</th>
                    <th>Veľkosť</th>
                    <th>Dátum uploadu</th>
                </tr>";
        foreach($subory as $subor) {
            if (($subor == ".") || (($dir == "files/") && ($subor == ".."))) continue;
            echo "<tr class='item'>";
            if(is_dir($dir.$subor) && ($subor == "..")) {
                $previous = $_GET["previous"];
                echo "<td><a href='index.php?folder=$previous'>" .  $subor . "/". "</a></td><td></td><td></td></tr>";   //<a href='detail.php?id=$row["id"]'
                continue;
            }
            else if(is_dir($dir.$subor)) {
                echo "<td><a href='index.php?folder=$dir$subor/&previous=$dir'>" .  $subor . "/". "</a></td><td></td><td></td></tr>";   //<a href='detail.php?id=$row["id"]'
                continue;
            }
            else {
                echo "<td>" .  $subor . "</td>";
            }
            
            echo "<td>" . filesize($dir.$subor). " B" . "</td>";
            echo "<td>" . date ("d F Y H:i:s.", filemtime($dir.$subor)) . "</td>";
            echo "</tr>";
            
        }
        echo "</table>";
    ?>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="text" name="path" id="path" value="files/" hidden>
        <label for="fileToUpload">Vyberte súbor na nahranie:</label> 
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <br>
        <label for="nameOfFile">Zadajte meno súboru:</label>
        <input type="text" name="nameOfFile" id="nameOfFile" required>
        <br>
        <input type="submit" value="Nahrať súbor" name="submit">
    </form>
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
</body>
</html>
