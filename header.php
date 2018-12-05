<?php
$phpSelf = htmlentities($_SERVER["PHP_SELF"], ENT_QUOTES, "UTF-8");
$path_parts = pathinfo($phpSelf);
?>

<header class="header">
    <h1 class="header__title">The Rime of the Ancient Mariner</h1>
    <nav class="nav">
        <ol class="nav__list">
            <li class="nav__list-item"><a href="index.html" class="nav__link<?php if ($path_parts['filename'] == "index") echo " nav__link--active";?>">home</a></li>
            <li class="nav__list-item"><a href="part-one.php" class="nav__link<?php if ($path_parts['filename'] == "part-one") echo " nav__link--active";?>">part 1</a></li>
            <li class="nav__list-item"><a href="part-two.php" class="nav__link<?php if ($path_parts['filename'] == "part-two") echo " nav__link--active";?>">part 2</a></li>
            <li class="nav__list-item"><a href="part-three.php" class="nav__link<?php if ($path_parts['filename'] == "part-three") echo " nav__link--active";?>">part 3</a></li>
            <li class="nav__list-item"><a href="part-four.php" class="nav__link<?php if ($path_parts['filename'] == "part-four") echo " nav__link--active";?>">part 4</a></li>
            <li class="nav__list-item"><a href="part-five.php" class="nav__link<?php if ($path_parts['filename'] == "part-five") echo " nav__link--active";?>">part 5</a></li>
            <li class="nav__list-item"><a href="part-six.php" class="nav__link<?php if ($path_parts['filename'] == "part-six") echo " nav__link--active";?>">part 6</a></li>
            <li class="nav__list-item"><a href="part-seven.php" class="nav__link<?php if ($path_parts['filename'] == "part-seven") echo " nav__link--active";?>">part 7</a></li>
            <li class="nav__list-item"><a href="feedback.php" class="nav__link<?php if ($path_parts['filename'] == "feedback") echo " nav__link--active";?>">feedback</a></li>
        </ol>
    </nav>
</header>