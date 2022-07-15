
<?php
session_start();

$msg = "";
$display = "none";
if(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = "fr";
}else if(isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])){
    if ($_GET['lang'] == "en"){
        $_SESSION['lang'] = "en";
    }else if ($_GET['lang'] == "fr"){
        $_SESSION['lang'] = "fr";
    }    
}
require_once "language/".$_SESSION["lang"].".php";

include "FUNCTION/contact.func.php";
    if(isset($_POST["submit"])):
        $display    = "visible";
        $name       = htmlspecialchars(trim($_POST['name']));
        $firstName  = htmlspecialchars(trim($_POST['firstName']));
        $email      = htmlspecialchars(trim($_POST['email']));
        $message    = htmlspecialchars(trim($_POST['message'])); 
        $phone      = !empty($_POST['phone'])?htmlspecialchars(trim($_POST['phone'])): "null";

        $errors = [];

        
        if(empty($name || $firstName)){
            $errors['empty'] = "Remplir les champs";
        }
        if(empty($email)){
            $errors['mail'] = "Email obligatoire";
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $errors['vmail'] = "Entrez une adresse email valide"; 
        }
        if(empty($message)){
            $errors['message'] = "Laisser un message";
        }

        if(!empty($errors)){
            foreach($errors as $error){
                $msg = $msg.$error.'<br>';
            }
        }else{
            if(send_mail($name, $email, $message)){
                add_message($name,$firstName,$email,$phone,$message);
                reply_mail($email);
                $msg = 'Votre message a été envoyer avec succès';
            }else{
                $msg = 'Nous n\'avons pas pu envoyer votre message';
                ?>
                <style>
                    .form .alert{
                        background-color: green;
                    }
                </style>
                <?php
            }
        }
        echo "<script>document.getElementById('name').focus();</script>";
    endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="CSS/second.css">
    <link rel="stylesheet" href="CSS/parallax.css">
    
    
    <script>
        function validateForm(){
            alert("Form submission")

            return false;
        }
    </script>

    <title><?= $lang["title"] ?></title>
</head>
<body style="overflow-right: hidden">
    <!--
    <div style="width: 100%; height: 100vh; max-width: 1510px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 0; position: fixed">
        <a class="pin" href="#header"><img src="RESOURCES/IMAGES/carret_left.png" alt=""></a>
    </div>
    -->

    <style>
        .slider h1{
            font-weight: 650;
            text-transform: capitalize;
            font-size: 35px;
        }
            
        .titre-2{
            text-transform: capitalize;
            font-weight: 600;
        }

        h1{
            margin-bottom: 60px;
            font-size: 45px;
            font-weight: 900;
            background-image: linear-gradient(-45deg, #1F9959, #273672);
            text-transform: uppercase;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <header id="header">
        <div class="header-contain">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">
                    <div style="position: relative">
                        <img src="./RESOURCES/SVG/InfiniteSolutions.svg" width="auto" height="75px">
                        <!-- L'image qui suit disparait on scroll -->
                        <img src="./RESOURCES/SVG/logoNav.svg" width="auto" height="75px" style="position: absolute; left: 0">
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto text-center">
                    <li class="nav-item">
                            <a href="#" class="nav-link"><?= $lang["home"] ?></a>
                    </li>
                    <li class="nav-item">
                            <a href="#services" class="nav-link"><?= $lang["service"] ?></a>
                    </li>
                    <li class="nav-item">
                            <a href="#formations" class="nav-link"><?= $lang["formation"] ?></a>
                    </li>
                    <!-- <li class="nav-item">
                            <a href="#realisations" class="nav-link"><?= $lang["realisation"] ?></a>
                    </li> -->
                    </ul>
                </div>
                <div class="nav-btn" style="position: relative">
                    <a href="#contactez-nous" style="border-radius: 0; position: absolute; right: 2px; top: 50%; transform: translate(0,-50%);" class="contact-btn text-right"><?= $lang["contact"] ?></a>
                </div> 
            </nav>
        </div>
    </header>
    <main>
        <section class="slider">
            <div class="contain">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                    <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="content">
                            <h1><?= $lang["content-1"] ?></h1>
                            <p><?= $lang["content-1-p"] ?></p>
                        </div>
                        <img src="RESOURCES/IMAGES/slider_img.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <div class="content">
                            <h1><?= $lang["content-2"] ?></h1>
                            <p><?= $lang["content-2-p"] ?></p>
                        </div>
                        <img src="RESOURCES/IMAGES/slider_img.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <div class="content">
                            <h1><?= $lang["content-3"] ?></h1>
                            <p><?= $lang["content-3-p"] ?></p>
                        </div>
                        <img src="RESOURCES/IMAGES/slider_img.png" class="d-block w-100" alt="...">
                    </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>
        <section class="qui" id="qui" >
            <div class="contain">
                <svg class="ellipse1" width="330" height="330" viewBox="0 0 330 330" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g style="mix-blend-mode:multiply">
                    <circle cx="165" cy="165" r="165" fill="#b9e0cb6e"/>
                    </g>
                </svg>
                <svg class="ellipse2" width="401" height="401" viewBox="0 0 401 401" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="200.5" cy="200.5" r="200.5" fill="#1C2651" fill-opacity="0.35"/>
                </svg>
                <div>
                    <h1 data-aos="fade-up"  data-aos-duration="1000"><?= $lang["qui"] ?></h1>
                    <p data-aos="fade-up"  data-aos-duration="1500"><?= $lang["qui-1-p"] ?></p>
                </div>
            </div>
        </section>
        <section class="services" id="services"> 
            <div class="contain">
                <h1 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services"] ?></h1>
                <div class="service-section" >
                    <div class="contenu" data-aos="fade-up">
                        <h3 data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-1"] ?></h3>
                        <p data-aos="fade-up" data-aos-duration="1600"><?= $lang["services-1-p"] ?></p>
                    </div>
                    <div class="image" style="background-image: url(./RESOURCES/IMAGES/webDev.jpg);" data-aos="fade-left" data-aos-duration="1200">
                    </div>
                </div>
                <div class="service-section">
                    <div class="image" style="background-image: url(./RESOURCES/IMAGES/graphicDesign.jpg);" data-aos="fade-right" data-aos-duration="1400" >
                    </div>
                    <div class="contenu">
                        <h3 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services-2"] ?></h3>
                        <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-2-p"] ?></p>
                    </div>
                </div>
                <div class="service-section">
                    <div class="contenu">
                        <h3 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services-3"] ?></h3>
                        <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-3-p"] ?></p>
                    </div>
                    <div class="image" style="background-image: url(./RESOURCES/IMAGES/DesktopDev.jpg);" data-aos="fade-left" data-aos-duration="1400">
                    </div>
            </div>
            </div>

        </section>
        <section class="formations" id="formations" style="height: auto;">
            <div class="contain">
                <div>
                    <div class="formations-text" >
                    <h1 data-aos="fade-up" data-aos-duration="1000"><?= $lang["formations"] ?></h1>
                    <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["formations-p"] ?></p>
                    </div>
                    <div class="formations-items">
                        <div data-aos="fade-up" data-aos-duration="1200" class="formations-item formations-item-1" style="background-image: url(./RESOURCES/IMAGES/2.jpg);">
                            <h4 class="h4"><?= $lang["formation-1"]?></h4>
                            <p class="p"><?= $lang["formation-p-1"]?></p>
                        </div>
                        <div data-aos="fade-up" data-aos-duration="1200" class="formations-item formations-item-2" style="background-image: url(./RESOURCES/IMAGES/3.jpg)">
                            <h4 class="h4"><?= $lang["formation-2"]?></h4>
                            <p class="p"><?= $lang["formation-p-2"]?></p>
                            </div>
                        <div data-aos="fade-up" data-aos-duration="1200" class="formations-item formations-item-3" style="background-image: url(./RESOURCES/IMAGES/6.jpg)">
                            <h4 class="h4"><?= $lang["formation-3"]?></h4>
                            <p class="p"><?= $lang["formation-p-3"]?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- <section class="realisations" id="realisations">
            <div class="contain">
                <h1 data-aos="fade-up"data-aos-duration="1000" class="titre-2" ><?= $lang["realise"] ?></h1>
                <h4>Plus de 30 Applications realisees</h4>
                <div class="realisations-items">
                    <div  >
                        <img data-aos="fade-up" data-aos-duration="1000" class="img" src="RESOURCES/IMAGES/icon_app_web.png" alt="" data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500"  data-tilt-scale="1.3" data-aos-duration="1000">
                        <h3 data-aos="fade-up" data-aos-duration="1000">11</h3>
                        <p data-aos="fade-up" data-aos-duration="1000"><?= $lang["realise-1"] ?></p>
                    </div>
                    <div >
                        <img data-aos="fade-up" data-aos-duration="1400" data-tilt data-tilt-max="50" data-aos-duration="1200" data-tilt-speed="10000" data-tilt-perspective="500"  data-tilt-scale="1.3" class="img" src="RESOURCES/IMAGES/icon_capp_mobile.png" alt="">
                        <h3 data-aos="fade-up" data-aos-duration="1200">14</h3>
                        <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["realise-2"] ?></p>
                    </div>
                    <div  >
                        <img data-aos="fade-up" data-aos-duration="1600" data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500"  data-tilt-scale="1.3" class="img" src="RESOURCES/IMAGES/icon_app_desktop.png" alt="">
                        <h3 data-aos="fade-up" data-aos-duration="1600">18</h3>
                        <p data-aos="fade-up" data-aos-duration="1600"><?= $lang["realise-3"] ?></p>
                    </div>
                    <div>
                        <img data-aos="fade-up" data-aos-duration="1400" data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500"  data-tilt-scale="1.3" class="img" src="RESOURCES/IMAGES/icon_redesign.png" alt="">
                        <h3 data-aos="fade-up" data-aos-duration="1400">3</h3>
                        <p data-aos="fade-up" data-aos-duration="1400"><?= $lang["realise-4"] ?></p>
                    </div>
                </div>
            </div>
        </section> -->
        <section class="travaux" id="travaux">
            <div class="contain">
                <h1 data-aos="fade-up" data-aos-duration="1200" class="titre-2" ><?= $lang["travaux"] ?></h1>
                <div class="travaux-items">
                    <div data-aos="fade-up" data-aos-duration="1200" style="background-image: url(./RESOURCES/IMAGES/4.jpg); background-size: cover;">
                        <a href="https://www.blooapp.live"><h4>Bloo Survey</h4></a>
                        <div class="parag">
                            <p>
                            <?= $lang["travaux-1-p"] ?>
                            </p>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-duration="1200" style="background-image: url(./RESOURCES/IMAGES/6.jpg); background-size: cover;">
                        <a href="http://www.ip-coatings.com"><h4>IP-Coatings</h4></a>
                        <div class="parag">
                            <p>
                            <?= $lang["travaux-2-p"] ?>
                            </p>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-duration="1200" style="background-image: url(./RESOURCES/IMAGES/3.jpg); background-size: cover;">
                        <a href="http://www.ensetdouala.net"><h4>ENSET Douala</h4></a>
                        <div class="parag">
                            <p>
                            <?= $lang["travaux-3-p"] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="technologies">
            <div class="contain">
                <h1 data-aos="fade-up" data-aos-duration="1200" class="titre-2" ><?= $lang["technologies"] ?></h1>
                <p data-aos="fade-up" data-aos-duration="1600"><?= $lang["technologies-p"] ?></p>
                <div class="arbre">
                    <div class="logo" style="z-index: 2">
                        <img data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500" data-tilt-scale="1.3" src="RESOURCES/IMAGES/logoNew.png" alt="">
                    </div>
                    <div class="laravel"></div>
                    <div class="javascript"></div>
                    <div class="nodejs"></div>
                    <div class="git-hub"></div>
                    <div class="html"></div>
                    <div class="autre"><img src="./RESOURCES/IMAGES/React.jpg" style="width: 100%;"></div>
                </div>
            </div>
        </section>
        <section class="contactez-nous" id="contactez-nous">
            <div class="container">
                <div class="text">
                    <h1 data-aos="fade-up" data-aos-duration="1000" class="titre-2" ><?= $lang["contacter-nous"] ?></h1>
                    <p data-aos="fade-up" data-aos-duration="1600"><?= $lang["contacter-nous-p"] ?></p>
                </div>
                <div class="form">
                    <div class="alert" style="display: <?php echo($display) ?>">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php echo($msg); ?>
                    </div>
                    <form action="" method="post" name="maillingForm">
                        <label for="name"><?= $lang["contacter-nous-name"] ?><span>*</span></label>
                        <div class="input">
                            <input class="form-control" type="text" id="name" name="name">
                        </div>

                        <label for="firstName"><?= $lang["contacter-nous-firstname"] ?><span>*</span></label>
                        <div class="input">
                            <input class="form-control" type="text" name="firstName"id="firstName" >
                        </div>

                        <label for="email"><?= $lang["contacter-nous-email"] ?><span>*</span></label>
                        <div class="input">
                            <input class="form-control" type="email" name="email" id="email" >
                        </div>

                        <label for="phone"><?= $lang["contacter-nous-phone"] ?></label>
                        <div class="input">
                            <input class="form-control" type="text" name="phone" id="phone">
                        </div>

                        <label for="message"><?= $lang["contacter-nous-message"] ?><span>*</span></label>
                        <div class="input">
                            <textarea class="form-control" name="message" id="message" cols="60" rows="10" ></textarea>
                        </div>
                        
                        <div class="submit">
                            <button type="submit" data-toggle="modal" data-target="#exampleModal" name="submit"><?= $lang["contacter-nous-send"] ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer id="footer">
        <div class="contain">
            <div class="footer-container">
                <div class="description">
                    <img src="RESOURCES/IMAGES/logoNew.png" alt="">
                    <p><?= $lang["footer-p"] ?></p>
                </div>
                <div class="entreprise">
                    <h2><?= $lang["footer-enterprise"] ?></h2>
                    <ul>
                        <li>
                            <a href="#" class="nav-link"><?= $lang["home"] ?></a>
                        </li>
                        <li>
                            <a href="#services" class="nav-link"><?= $lang["service"] ?></a>
                        </li>
                        <li>
                            <a href="#formations" class="nav-link"><?= $lang["formation"] ?></a>
                        </li>
                        <!-- <li>
                            <a href="#realisations" class="nav-link"><?= $lang["realisation"] ?></a>
                        </li> -->
                    </ul>
                </div>
                <div class="contacts">
                    <h2>CONTACTS</h2>
                    <ul>
                        <li>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.2078 22.8816L23.6068 19.7796C23.5266 19.5608 23.7009 19.6007 23.8199 19.0143C23.9389 18.7279 24.0001 18.4208 24 18.1107C24 17.4786 23.7524 16.8845 23.6068 16.4388L19.9689 13.101C19.7501 12.8812 19.49 12.7068 19.2036 12.5879C18.9172 12.4689 18.6101 12.4077 18.3 12.4078C17.668 12.4078 17.0738 12.6553 16.6282 13.101L14.1874 15.5417C12.9281 14.9704 11.7825 14.1761 10.8058 13.1971C9.82445 12.2205 9.02723 11.075 8.45243 9.81553L10.8932 7.37476C11.113 7.15594 11.2874 6.89586 11.4063 6.60946C11.5253 6.32605 11.5865 6.01596 11.5864 5.70583C11.5864 5.07379 11.3388 4.47961 10.8932 4.03398L7.55825 0.693205C7.33903 0.473159 7.07847 0.298631 6.79155 0.179664C6.50463 0.060697 6.19701 -0.000361707 5.88641 8.1319e-07C5.25437 7.85563e-07 4.66019 0.247574 4.21456 0.693205L1.11845 3.78932C0.404854 4.5 -2.39606e-07 5.48155 -2.83657e-07 6.48932C-2.92951e-07 6.70194 0.0174755 6.90583 0.052427 7.1068C0.699029 11.033 2.78738 14.9272 5.92718 18.0699C9.06408 21.2097 12.9553 23.2951 16.8932 23.9505C18.0961 24.1485 19.334 23.7495 20.2078 22.8816Z" fill="#414E83"/>
                        </svg>
                        (+237) 677 67 19 15
                        </li>
                        <li>
                        <svg width="31" height="24" viewBox="0 0 31 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29.4545 0H1.09091C0.4875 0 0 0.4875 0 1.09091V22.9091C0 23.5125 0.4875 24 1.09091 24H29.4545C60.058 24 60.5455 23.5125 60.5455 22.9091V1.09091C60.5455 0.4875 60.058 0 29.4545 0ZM26.7 3.7125L15.9443 12.0818C15.6784 12.2898 15.6068 12.2898 15.0409 12.0818L4.28182 3.7125C4.24126 3.6812 4.21151 3.63799 4.19674 3.58894C4.18198 3.53988 4.18293 3.48743 4.19947 3.43894C4.21601 3.39045 4.2473 3.34836 4.28897 3.31855C4.36064 3.28874 4.38059 3.27272 4.43182 3.27273H26.55C26.6012 3.27272 26.6512 3.28874 26.6929 3.31855C26.7345 3.34836 26.7658 3.39045 26.7824 3.43894C26.7989 3.48743 26.7998 3.53988 26.7851 3.58894C26.7703 3.63799 26.7406 3.6812 26.7 3.7125Z" fill="#414E83"/>
                        </svg>
                        <a href="mailto: hello@isolutions-intl.com"> hello@isolutions-intl.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div>
                <a href="index.php?lang=<?php if($_SESSION['lang'] == 'en'){echo('fr');}else{echo('en');} ?>" class="nav-link">
                    <svg class="lang" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="60" height="60" fill="url(#pattern0)"/>
                        <defs>
                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_248_2" transform="scale(0.0078125)"/>
                        </pattern>
                        <image id="image0_248_2" width="60" height="60" xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>
                </a>
                <p style="text-transform: uppercase"><?= $lang["goodbye"]?></p>
            </div>
            <hr>
            <div class="copyright">
                <p>&copy; Infinite Solutions | Copyright 2022</p>
            </div>
        </div>
    </footer>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script><script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/vanilla-tilt.min.js"></script>
    <script>
    AOS.init();
    </script>
</body>
</html>