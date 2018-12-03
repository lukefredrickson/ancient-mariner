<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/form.css">
    <title>Contact &#124; Rime of the Ancient Mariner</title>
</head>

<body>
    <?php include("header.php");?>
    <main class="main">
        <h1 class="feedback-form__header">Contact</h1>
        <form action="" id="feedback-form" class="feedback-form" method="post">
            <section class="feedback-form__section">
                <label class="feedback-form__label">First Name</label>
                <input class="feedback-form__text-input" type="text" maxlength="50" name="name">
            </section>
            
            <section class="feedback-form__section">
                <label class="feedback-form__label">Email</label>
                <input class="feedback-form__text-input" type="text" maxlength="50" name="email">
            </section>

            <section class="feedback-form__section">
                <label class="feedback-form__label">Reason for Feedback</label>
                <select class="feedback-form__dropdown" name="reason">
                    <option value="Employed">Constructive critisism</option>
                    <option value="Student">Contact site owner</option>
                    <option value="Unemployed">Found a bug</option>
                    <option value="Retired">Thoughtless complaints</option>
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
                <label class="feedback-form__label">How did you find the site?</label>
                <section class="feedback-form__checkboxes">
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="rating" value="friend">
                        A friend
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="rating" value="family">
                        A family member
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="rating" value="school">
                        My school
                    </label>
                    <label class="feedback-form__checkbox-label">
                        <input class="feedback-form__checkbox" type="checkbox" name="rating" value="other">
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