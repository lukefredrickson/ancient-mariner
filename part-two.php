<?php

//PARSE CSV//

$path = "data/poem-text/";
$fileName = "part2.csv";
$fullPath = $path . $fileName;

$file = fopen($fullPath, "r");

if ($file) {
    $headers[] = fgetcsv($file,0, "\t");
    while (!feof($file)) {
        $poemData[] = fgetcsv($file,0, "\t");
    }
    fclose($file);
    /*
    print_r($headers);
    print_r($poemData);
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
    <title>Part 2 &#124; Rime of the Ancient Mariner</title>
    <script type="text/javascript">
        let poemData = <?php echo json_encode($poemData);?>;
        console.log(poemData);
    </script>
</head>

<body>
    <?php include("header.php");?>
    <main class="main">
        <article class="poem">
            <h1 class="poem__header">Part Two</h1>
            <?php
                //id each stanza with it's start time (seconds)
                foreach ($poemData as $stanzaData) {
                    echo "<p id=\"$stanzaData[1]\" class=\"poem__stanza\">";
                    echo $stanzaData[0];
                    echo "</p>";
                }
            ?>
        </article>
        <nav class="next-previous">
            <ol class="next-previous__list">
                <li class="next-previous__list-item"><a href="part-one.php" class="next-previous__link">previous</a></li>
                <li class="next-previous__list-item"><a href="part-three.php" class="next-previous__link">next</a></li>
            </ol>
        </nav>
        <?php include("footer.php");?>
    </main>
    <audio class="audio-player__control" id="player">
        <source src="data/doescher-reading/part2.mp3" type="audio/mpeg">
    </audio>
    <?php include("audio-player.php");?>
</body>

<script type="text/javascript" src="scripts/script.js"></script>

</html>