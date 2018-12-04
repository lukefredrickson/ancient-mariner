<?php

//PARSE CSV//

$path = "data/poem-text/";
$fileName = "part6.csv";
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
    <link rel="stylesheet" href="styles/poem.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Part 6 &#124; Rime of the Ancient Mariner</title>
    <script type="text/javascript">
        let poemData = <?php echo json_encode($poemData);?>;
        console.log(poemData);
    </script>
</head>

<body>
    <main class="wrapper">
    <?php include("header.php");?>
    <section class="primary-content">
        <article class="poem">
            <h1 class="poem__header">Part Six</h1>
            <?php
                //id each stanza with it's start time (seconds)
                foreach ($poemData as $stanzaData) {
                    $lineData = explode("\n",$stanzaData[0]);
                    echo "<p id=\"$stanzaData[1]\" class=\"poem__stanza\">";
                    foreach($lineData as $line) {
                        //span for highlighting individual lines, not whole p block
                        echo "<span class=\"poem__line\">$line\n</span>";
                    }
                    echo "</p>";
                }
            ?>
        </article>
        <nav class="next-previous">
            <ol class="next-previous__list">
                <li class="next-previous__list-item"><a href="part-five.php" class="next-previous__link">previous</a></li>
                <li class="next-previous__list-item"><a href="part-seven.php" class="next-previous__link">next</a></li>
            </ol>
        </nav>
    </section>
    <?php include("footer.php");?>
    </main>
    <audio class="audio-player__control" id="player">
        <source src="data/doescher-reading/part1.mp3" type="audio/mpeg">
    </audio>
    <?php include("audio-player.php");?>
</body>

<script type="text/javascript" src="scripts/script.js"></script>

</html>