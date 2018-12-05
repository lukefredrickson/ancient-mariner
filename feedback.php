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

        //EMAIL TO USER//
        $to = $email;
        $from = "Luke Fredrickson <lfredric@uvm.edu>";
        $subject = "Thanks for your feedback, $name!";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . $from . "\r\n";

        $message = '<html><head><title>' . $subject . '</title></head><body>';
        $message .= "<h2>Your Feedback:</h2><hr>";
        if (!empty($reason)) $message .= "<p>Reason: $reason</p>";
        if (!empty($rating)) $message .= "<p>Rating: $rating/5</p>";
        if (!empty($comment)) $message .= "<p>Comment:</p><p>$comment</p>";
        if ($fromPortfolio || $fromFriendFamily || $fromSchoolWork || $fromOther) $message .= "<p>Found site through:</p><ul>";
        if ($fromPortfolio) $message .= "<li>Luke's portfolio</li>";
        if ($fromFriendFamily) $message .= "<li>A friend or family member</li>";
        if ($fromSchoolWork) $message .= "<li>School or work</li>";
        if ($fromOther) $message .= "<li>Another way</li>";
        if ($fromPortfolio || $fromFriendFamily || $fromSchoolWork || $fromOther) $message .= "</ul><hr>";
        $message .= "<p>Visit <a href=\"http://www.lukefredrickson.info/\">www.lukefredrickson.info</a> for more of Luke's work.</p></body>";

        mail($to, $subject, $message, $headers);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Luke Fredrickson">
    <meta name="description" content="The Rime of the Ancient Mariner is a multi-media storytelling experience featuring Samuel Taylor Coleridge's famous poem of the same name, and a dramatic narration and musical accompaniment from Ian Doescher. The website adapts to the ebbs and flows of the Coleridge's tale and Doescher's narration by morphing its styles to match the current mood.">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/form.css">
    <title>Feedback &#124; Rime of the Ancient Mariner</title>
</head>

<body>
    <main class="wrapper">
    <?php include("header.php");?>
    <section class="primary-content">
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
        else {
            if (!empty($errors)) {
                echo("<h3 class=\"feedback-form__subheader\">Oops! Looks like some information is missing.</h3>");
                foreach ($errors as $error) {
                    echo("<h4 class=\"feedback-form__error\">$error</h4>");
                }
            }
        ?>
        <form action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "UTF-8")); ?>" id="feedback-form" class="feedback-form" method="post">
            <fieldset class="feedback-form__section">
                <legend class="feedback-form__label">First Name*</legend>
                <input class="feedback-form__text-input <?php if ($nameError) echo "feedback-form__text-input--error"?>"
                value="<?php echo $name;?>" type="text" maxlength="50" name="name">
            </fieldset>
            
            <fieldset class="feedback-form__section">
                <legend class="feedback-form__label">Email*</legend>
                <input class="feedback-form__text-input <?php if ($emailError) echo "feedback-form__text-input--error"?>"
                    value="<?php echo $email;?>" type="text" maxlength="50" name="email">
            </fieldset>

            <fieldset class="feedback-form__section">
                <legend class="feedback-form__label">Reason for Feedback</legend>
                <select class="feedback-form__dropdown" name="reason">
                    <option <?php if ($reason=="Unspecified") echo("selected");?>
                        value="Unspecified">Unspecified</option>
                    <option <?php if ($reason=="Contact Luke") echo("selected");?>
                        value="Contact Luke">Contact Luke</option>
                    <option <?php if ($reason=="Found a bug") echo("selected");?>
                        value="Found a bug">Found a bug</option>
                    <option <?php if ($reason=="Constructive critisism") echo("selected");?>
                        value="Constructive critisism">Constructive critisism</option>
                </select>
            </fieldset>
            
            <fieldset class="feedback-form__section">
                <legend class="feedback-form__label">Rating</legend>
                <section class="feedback-form__radio-buttons">
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="1"
                        <?php if ($rating==1) echo(" checked");?>>
                        1
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="2"
                        <?php if ($rating==2) echo(" checked");?>>
                        2
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="3"
                        <?php if ($rating==3) echo(" checked");?>>
                        3
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="4"
                        <?php if ($rating==4) echo(" checked");?>>
                        4
                    </label>
                    <label class="feedback-form__radio-label">
                        <input class="feedback-form__radio" type="radio" name="rating" value="5"
                        <?php if ($rating==5) echo(" checked");?>>
                        5
                    </label>
                </section>
            </fieldset>

            <fieldset class="feedback-form__section">
                <legend class="feedback-form__label">What brought you here?</legend>
                <section class="feedback-form__checkboxes">
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="portfolio" value="portfolio"
                        <?php if ($fromPortfolio) echo(" checked");?>>
                        Luke's portfolio
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="friendFamily" value="friend-family"
                        <?php if ($fromFriendFamily) echo(" checked");?>>
                        A friend or family member
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="schoolWork" value="school-work"
                        <?php if ($fromSchoolWork) echo(" checked");?>>
                        School or work
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="other" value="other"
                        <?php if ($fromOther) echo(" checked");?>>
                        Other
                    </label>
                </section>
            </fieldset>
            
            <fieldset class="feedback-form__section">
                <legend class="feedback-form__label">Comment</legend>
                <textarea class="feedback-form__textarea" name="comment"><?php echo $comment;?></textarea>
            </fieldset>

            <fieldset class="feedback-form__section">
                <input class="feedback-form__button" id="submit" name="submit" type="submit" value="Submit Feedback">
            </fieldset>
        </form>
        <?php
        }
        ?>
    </section>
    <?php include("footer.php");?>
    </main>
</body>

</html>