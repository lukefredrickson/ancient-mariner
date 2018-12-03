<?php
//initialize form vars
$name = $email = $reason = $rating = $comment = "";
$fromPortfolio = $fromFriendFamily = $fromSchoolWork = $fromOther = false;

//trims whitespace and slashes, sanitizes input
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//WHEN THE FORM IS SUBMITTED//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    //GET DATA FROM FORM AND SANITIZE INPUT
    $name = sanitizeData($_POST["name"], ENT_QUOTES, "UTF-8");
    $email = sanitizeData($_POST["email"], ENT_QUOTES, "UTF-8");
    $reason = sanitizeData($_POST["reason"], ENT_QUOTES, "UTF-8");
    $rating = sanitizeData($_POST["rating"], ENT_QUOTES, "UTF-8");
    $comment = sanitizeData($_POST["comment"], ENT_QUOTES, "UTF-8");
    $fromPortfolio = isset($_POST["portfolio"]);
    $fromFriendFamily = isset($_POST["friendFamily"]);
    $fromSchoolWork = isset($_POST["schoolWork"]);
    $fromOther = isset($_POST["other"]);
    
    //CHECK FOR INVALID INPUT ON NAME AND EMAIL//
    $errors = [];
    if ($name == "") {
        $errors[] = ("Please enter your name.");
        $nameError = true;
    }
    if ($email == "") {
        $errors[] = ("Please enter your email.");
        $emailError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Your email address appears to be incorrect.";
        $emailError = true;
    }
    
    //INPUT PASSED VALIDATION//
    if ( !$errors ) {
        //SEND DATA TO CSV//
        //add data to array
        $data = [];
        $data[] = $name;
        $data[] = $email;
        $data[] = $reason;
        $data[] = $rating;
        $data[] = $comment;
        $data[] = $fromPortfolio;
        $data[] = $fromFriendFamily;
        $data[] = $fromSchoolWork;
        $data[] = $fromOther;
        //append data to csv file
        $fileName = "feedback.csv";
        $path = "data/";
        $fullPath = $path . $fileName;
        $file = fopen($fullPath, "a");
        fputcsv($file, $data);
        fclose($file);
    }
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
    <link rel="stylesheet" href="styles/form.css">
    <title>Feedback &#124; Rime of the Ancient Mariner</title>
</head>

<body>
    <?php include("header.php");?>
    <main class="main">
        <h1 class="feedback-form__header">Feedback</h1>
        <?php
        //DEBUGGING PRINT STATEMENTS//
        /*
        echo("<p>name = $name</p>");
        echo("<p>email = $email</p>");
        echo("<p>reason = $reason</p>");
        echo("<p>rating = $rating</p>");
        echo("<p>comment = $comment</p>");
        echo("<p>portfolio = $fromPortfolio</p>");
        echo("<p>friend-family = $fromFriendFamily</p>");
        echo("<p>school-work = $fromSchoolWork</p>");
        echo("<p>other = $fromOther</p>");
        echo("<p>Errors: ");
        print_r($errors);
        echo("</p>");
        */
        
        //FORM SUBMITTED, NO ERRORS//
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) && empty($errors)) {
            echo("<h3 class=\"feedback-form__subheader\">Thank you for your feedback!</h3>");
        }

        //ERRORS PRESENT//
        elseif (!empty($errors)) {
            echo("<h3 class=\"feedback-form__subheader\">Oops! Looks like some information is missing.</h3>");
        }
        ?>
        <form action="feedback.php<?php //echo(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "UTF-8")); ?>" id="feedback-form" class="feedback-form" method="post">
            <section class="feedback-form__section">
                <label class="feedback-form__label">First Name*</label>
                <input class="feedback-form__text-input" type="text" maxlength="50" name="name">
            </section>
            
            <section class="feedback-form__section">
                <label class="feedback-form__label">Email*</label>
                <input class="feedback-form__text-input" type="text" maxlength="50" name="email">
            </section>

            <section class="feedback-form__section">
                <label class="feedback-form__label">Reason for Feedback</label>
                <select class="feedback-form__dropdown" name="reason">
                    <option value="unspecified"></option>
                    <option value="contact">Contact Luke</option>
                    <option value="bug">Found a bug</option>
                    <option value="critisism">Constructive critisism</option>
                    <option value="complaint">Thoughtless complaints</option>
                </select>
            </section>
            
            <section class="feedback-form__section">
                <label class="feedback-form__label">Rating</label>
                <section class="feedback-form__radio-buttons">
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="1">
                        1
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="2">
                        2
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="3">
                        3
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="4">
                        4
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="5">
                        5
                    </label>
                </section>
            </section>

            <section class="feedback-form__section">
                <label class="feedback-form__label">What brought you here?</label>
                <section class="feedback-form__checkboxes">
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="portfolio" value="portfolio">
                        Luke's portfolio
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="friendFamily" value="friend-family">
                        A friend or family member
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="schoolWork" value="school-work">
                        School or work
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="other" value="other">
                        Other
                    </label>
                </section>
            </section>
            
            <section class="feedback-form__section">
                <label class="feedback-form__label">Comment</label>
                <textarea class="feedback-form__textarea" name="comment"></textarea>
            </section>

            <section class="feedback-form__section">
                <input class="feedback-form__button" id="submit" name="submit" type="submit" value="Submit Feedback">
            </section>
        </form>
        <?php include("footer.php");?>
    </main>
</body>

</html>