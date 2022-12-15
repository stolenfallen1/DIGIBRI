<?php 

include '../database_connection.php';

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="generator" content="">
        <title>WELCOME</title>
        <link rel="canonical" href="">
        <link rel="stylesheet" href="../asset/css/homepage-style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <!-- NAVBAR -->
        <nav id="navbar">
            <input type="checkbox" id="check">
            <label for="check" class="checkbtn">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </label>
            <img src="../asset/LOGO_WHITE.png" width="110px;" height="auto" style="padding:10px 5px 5px 25px;">
            <ul>
                <li><a href="#home-section">Home</a></li>
                <li><a href="#news-section">News</a></li>
                <li><a href="#contact-section">Contact</a></li>
            </ul>
        </nav>
        <!-- HOME SECTION -->
        <section id="home-section">
            <h1>DIGI<span style="color:#F59292;">BRI</span></h1><br>
            <h2 class="typing"></h2>
            <button class="button" onclick="window.location.href='librarian_login.php'">Login Here</button>
        </section>
        <!-- NEWS / COLLECTION PAGE -->

        <?php
        function randomImage($dir_path = NULL)
        {
            if(!empty($dir_path))
            {
                $files = scandir($dir_path);
                $count = count($files);
                if($count > 1)
                {
                    $index = rand(1, ($count-1));
                    $image = $files[$index];
                    return '<img src="'.$dir_path."/".$image.'" alt="'.$image.'">';
                } 
                else 
                {
                    return "The directory is empty!";
                }
            }
        }
        ?>

        <section id="news-section">
            <div class="news-header">
                <h1>NEWS</h1>
                <br>
                <u>New Collections</u>
            </div><br><br>
            <div class="media-scroller snaps-inline">
                <div class="media-element">
                    <?php echo randomImage("../asset/Uploads/"); ?>
                </div>
                <div class="media-element">
                    <?php echo randomImage("../asset/Uploads/"); ?>
                </div>
                <div class="media-element">
                    <?php echo randomImage("../asset/Uploads/"); ?>
                </div>
                <div class="media-element">
                    <?php echo randomImage("../asset/Uploads/"); ?>
                </div>
                <div class="media-element">
                    <?php echo randomImage("../asset/Uploads/"); ?>
                </div>
            </div>
        </section>
        <!-- CONTACT SECTION -->
        <section id="contact-section">
            <h1>CONTACT <span style="color:#F59292;">DIGIBRI</span></h1><br>
            <h2>You can contact us here for any concern</h2><br><br>
            <div>
                <p><a href="https://www.facebook.com/LahugNHSOfficial/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></p>
                <p><a href="https://accounts.google.com/" target="_blank"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></p>
                <p><a href="https://www.facebook.com/LahugNHSOfficial/" target="_blank"><i class="fa fa-phone-square" aria-hidden="true"></i></a></p>
            </div>
        </section>
        <script>
            //typing animation
            var typed = new Typed(".typing", {
                strings: [' " A BOOK IS A DREAM YOU CAN HOLD IN YOUR HANDS. " '
                , ' " IN THE END, WE ALL BECOME STORIES. " '
                , ' " LIFE IS A STORY, WHAT DOES YOURS SAY? " '
                , ' " A BOOK IS A GIFT, WE CAN OPEN AGAIN AND AGAIN. " '],
                typeSpeed: 80,
                backSpeed: 45,
                loop: true
            }); 
        </script>
    </body>
</html>