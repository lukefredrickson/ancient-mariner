<?php

$path = "data/poem-text/";
$fileName = "part4.csv";
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
    <title>Part 4 &#124; Rime of the Ancient Mariner</title>
</head>

<body>
    <main class="main">
        <?php include("top-nav.php");?>
        <article class="poem">
            <h1 class="poem__header">Part Four</h1>
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
                <li class="next-previous__list-item"><a href="part-three.php" class="next-previous__link">previous</a></li>
                <li class="next-previous__list-item"><a href="part-five.php" class="next-previous__link">next</a></li>
            </ol>
        </nav>
    </main>
    <audio class="player" id="player" controls>
        <source src="data/doescher-reading/part4.mp3" type="audio/mpeg">
    </audio>
</body>

</html>