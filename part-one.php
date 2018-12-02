<?php

$path = "data/poem-text/";
$fileName = "part1.csv";
$fullPath = $path . $fileName;

$file = fopen($fullPath, "r");

if ($file) {
    $headers[] = fgetcsv($file,0, "\t");
    while (!feof($file)) {
        $data[] = fgetcsv($file,0, "\t");
    }
    fclose($file);
    /*
    print_r($headers);
    print_r($data);
    */
} else {
    /*
    print '<p>File Open Failed.</p>';
    */
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Part 1 &#124; Rime of the Ancient Mariner</title>
</head>

<body>
    <header class="header">
        <h1 class="header__title">The Rime of the Ancient Mariner</h1>
        <?php include("top-nav.php");?>
    </header>
    <main class="main">
        <article class="poem">
            <h1 class="poem__header">Part One</h1>
            <?php
                foreach ($data as $stanza) {
                    echo "<p class=\"poem__stanza\">";
                    echo $stanza[0];
                    echo "</p>";
                }
            ?>
        </article>
        <nav class="next-previous">
            <ol class="next-previous__list">
                <li class="next-previous__list-item"><a href="part-two.php" class="next-previous__link">next</a></li>
            </ol>
        </nav>
    </main>
    <audio class="audio-player__control" id="player">
        <source src="data/doescher-reading/part1.mp3" type="audio/mpeg">
    </audio>
    <?php include("audio-player.php");?>
</body>

<script src="scripts/script.js"></script>

</html>