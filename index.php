
<?php
session_start();

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
                echo $error."<br>";
            }
        }else{
            if(send_mail($name, $email, $message)){
                add_message($name,$firstName,$email,$phone,$message);
                reply_mail($email);
                echo "Votre message a été envoyer avec succès";
            }else{
                echo "<script>alert'Nous n'avons pas pu envoyer votre message'</script>";
            }
        }
    endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="CSS/second.css">


    <title><?= $lang["title"] ?></title>
</head>
<body>
    <a class="pin" href="#header"><img src="RESOURCES/IMAGES/carret_left.png" alt=""></a>
    <header id="header">
        <div class="reseaux">
            <div>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9968 7.9983C9.79333 7.9983 7.99515 9.79651 7.99515 12C7.99515 14.2035 9.79333 16.0017 11.9968 16.0017C14.2002 16.0017 15.9984 14.2035 15.9984 12C15.9984 9.79651 14.2002 7.9983 11.9968 7.9983ZM23.9987 12C23.9987 10.3429 24.0137 8.70077 23.9206 7.04665C23.8275 5.12536 23.3893 3.4202 21.9843 2.01525C20.5764 0.607302 18.8743 0.172009 16.953 0.0789456C15.2959 -0.0141172 13.6539 0.000892936 11.9998 0.000892936C10.3427 0.000892936 8.70061 -0.0141172 7.04652 0.0789456C5.12526 0.172009 3.42014 0.610305 2.01522 2.01525C0.607291 3.42321 0.172005 5.12536 0.0789442 7.04665C-0.014117 8.70377 0.000892919 10.3459 0.000892919 12C0.000892919 13.6541 -0.014117 15.2992 0.0789442 16.9533C0.172005 18.8746 0.610294 20.5798 2.01522 21.9847C3.42314 23.3927 5.12526 23.828 7.04652 23.9211C8.70361 24.0141 10.3457 23.9991 11.9998 23.9991C13.6569 23.9991 15.2989 24.0141 16.953 23.9211C18.8743 23.828 20.5794 23.3897 21.9843 21.9847C23.3923 20.5768 23.8275 18.8746 23.9206 16.9533C24.0167 15.2992 23.9987 13.6571 23.9987 12ZM11.9968 18.1572C8.58954 18.1572 5.83973 15.4073 5.83973 12C5.83973 8.5927 8.58954 5.84284 11.9968 5.84284C15.404 5.84284 18.1538 8.5927 18.1538 12C18.1538 15.4073 15.404 18.1572 11.9968 18.1572ZM18.406 7.02864C17.6105 7.02864 16.968 6.38621 16.968 5.59067C16.968 4.79513 17.6105 4.1527 18.406 4.1527C19.2015 4.1527 19.8439 4.79513 19.8439 5.59067C19.8442 5.77957 19.8071 5.96667 19.735 6.14124C19.6628 6.31581 19.5569 6.47442 19.4233 6.608C19.2897 6.74157 19.1311 6.84748 18.9565 6.91967C18.782 6.99185 18.5949 7.02888 18.406 7.02864Z" fill="white"/>
                </svg>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 12.067C0 18.033 4.333 22.994 10 24V15.333H7V12H10V9.333C10 6.333 11.933 4.667 14.667 4.667C15.533 4.667 16.467 4.8 17.333 4.933V8H15.8C14.333 8 14 8.733 14 9.667V12H17.2L16.667 15.333H14V24C19.667 22.994 24 18.034 24 12.067C24 5.43 18.6 0 12 0C5.4 0 0 5.43 0 12.067Z" fill="white"/>
                </svg>
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.7206e-07 1.838C2.7206e-07 1.35053 0.193646 0.883032 0.538338 0.53834C0.88303 0.193648 1.35053 2.45031e-06 1.838 2.45031e-06H20.16C20.4016 -0.000392101 20.6409 0.0468654 20.8641 0.139069C21.0874 0.231273 21.2903 0.366612 21.4612 0.537339C21.6322 0.708065 21.7677 0.910826 21.8602 1.13401C21.9526 1.3572 22.0001 1.59643 22 1.838V20.16C22.0003 20.4016 21.9529 20.6409 21.8606 20.8642C21.7683 21.0875 21.6328 21.2904 21.462 21.4613C21.2912 21.6322 21.0884 21.7678 20.8651 21.8602C20.6419 21.9526 20.4026 22.0001 20.161 22H1.838C1.59655 22 1.35746 21.9524 1.1344 21.86C0.911335 21.7676 0.708671 21.6321 0.537984 21.4613C0.367297 21.2905 0.231932 21.0878 0.139623 20.8647C0.0473133 20.6416 -0.000131096 20.4025 2.7206e-07 20.161V1.838ZM8.708 8.388H11.687V9.884C12.117 9.024 13.217 8.25 14.87 8.25C18.039 8.25 18.79 9.963 18.79 13.106V18.928H15.583V13.822C15.583 12.032 15.153 11.022 14.061 11.022C12.546 11.022 11.916 12.111 11.916 13.822V18.928H8.708V8.388ZM3.208 18.791H6.416V8.25H3.208V18.79V18.791ZM6.875 4.812C6.88105 5.08668 6.83217 5.35979 6.73124 5.61532C6.63031 5.87084 6.47935 6.10364 6.28723 6.30003C6.09511 6.49643 5.8657 6.65248 5.61246 6.75901C5.35921 6.86554 5.08724 6.92042 4.8125 6.92042C4.53776 6.92042 4.26579 6.86554 4.01255 6.75901C3.7593 6.65248 3.52989 6.49643 3.33777 6.30003C3.14565 6.10364 2.99469 5.87084 2.89376 5.61532C2.79283 5.35979 2.74395 5.08668 2.75 4.812C2.76187 4.27286 2.98439 3.75979 3.36989 3.38269C3.75539 3.00558 4.27322 2.79442 4.8125 2.79442C5.35178 2.79442 5.86961 3.00558 6.25512 3.38269C6.64062 3.75979 6.86313 4.27286 6.875 4.812Z" fill="white"/>
                </svg>
            </div>
        </div>
        <nav>
            <div class="logo">
                <a href="#"><img src="RESOURCES/IMAGES/InfiniteSolutionsLogo.png" alt="Infinite Solutions Logo"></a>
            </div>

            <div class="liens" id="liens">
                <button class="expand" onclick="expand()" id="expand">Expand</button>
                <a href="#"><?= $lang["home"] ?></a>
                <a href="#services"><?= $lang["service"] ?></a>
                <a href="#formations"><?= $lang["formation"] ?></a>
                <a href="#realisations"><?= $lang["realisation"] ?></a>
                <a href="index.php?lang=en"><?= $lang["lang_en"] ?></a>
                <a href="index.php?lang=fr"><?= $lang["lang_fr"] ?></a>
            </div>
            <div class="nav-btn">
                <a href="#contactez-nous" class="contact-btn"><?= $lang["contact"] ?></a>
            </div>
        </nav>
    </header>
    <main>

        <section class="slider">
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
        </section>
        <section class="qui" id="qui" >
            <h1 data-aos="fade-up"  data-aos-duration="1000"><?= $lang["qui"] ?></h1>
            <div>
                <p data-aos="fade-up"  data-aos-duration="1500"><?= $lang["qui-1-p"] ?></p>
                
            </div>
        </section>
        <section class="services" id="services">
            <h1 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services"] ?></h1>
            <div class="service-section " >
                <div data-aos="fade-up">
                    <h3 data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-1"] ?></h3>
                    <p data-aos="fade-up" data-aos-duration="1300"><?= $lang["services-1-p"] ?></p>
                    <p data-aos="fade-up" data-aos-duration="1350"><?= $lang["service-1-p-2"] ?></p>
                    <button data-aos="fade-up" data-aos-duration="1350"><?= $lang["services-1-b"] ?></button>
                </div>
                <img src="RESOURCES/IMAGES/slider_img.png" alt="" data-aos="fade-left" data-aos-duration="1200" >
            </div>
            <div class="service-section">
                <img src="RESOURCES/IMAGES/slider_img.png" data-aos="fade-right" data-aos-duration="1400" alt="">
                <div>
                    <h3 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services-2"] ?></h3>
                    <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-2-p"] ?></p>
                    <button data-aos="fade-up" data-aos-duration="1300"><?= $lang["services-2-b"] ?></button>
                </div>
            </div>
            <div class="service-section">
                <div>
                    <h3 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services-3"] ?></h3>
                    <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-3-p"] ?></p>
                    <button data-aos="fade-up" data-aos-duration="1300"><?= $lang["services-3-b"] ?></button>
                </div>
                <img src="RESOURCES/IMAGES/slider_img.png" alt="" data-aos="fade-left" data-aos-duration="1400">
            </div>

        </section>
        <section class="formations" id="formations">
            <div>
                <div class="formations-text" >
                <h1 data-aos="fade-up" data-aos-duration="1000"><?= $lang["formations"] ?></h1>
                <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["formations-p"] ?></p>
                </div>
                <div class="carousel">
                    <div class="carousel-item"></div>
                    <div class="carousel-item"></div>
                    <div class="carousel-item"></div>
                    <div class="carousel-item"></div>
                </div>
            </div>
        </section>
        <section class="realisations" id="realisations">
            <h1 data-aos="fade-up"data-aos-duration="1000" ><?= $lang["realise"] ?></h1>
            <p data-aos="fade-up"data-aos-duration="1100"><?= $lang["realise-p"] ?></p>
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
                    <img data-aos="fade-up" data-aos-duration="1300" data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500"  data-tilt-scale="1.3" class="img" src="RESOURCES/IMAGES/icon_app_desktop.png" alt="">
                    <h3 data-aos="fade-up" data-aos-duration="1300">18</h3>
                    <p data-aos="fade-up" data-aos-duration="1300"><?= $lang["realise-3"] ?></p>
                </div>
                <div>
                    <img data-aos="fade-up" data-aos-duration="1400" data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500"  data-tilt-scale="1.3" class="img" src="RESOURCES/IMAGES/icon_redesign.png" alt="">
                    <h3 data-aos="fade-up" data-aos-duration="1400">3</h3>
                    <p data-aos="fade-up" data-aos-duration="1400"><?= $lang["realise-4"] ?></p>
                </div>
            </div>
        </section>
        <section class="travaux">
            <h1 data-aos="fade-up" data-aos-duration="1200"><?= $lang["travaux"] ?></h1>
            <p data-aos="fade-up" data-aos-duration="1300"><?= $lang["travaux-p"] ?></p>
            <div class="travaux-items">
                <div>
                    <button ><?= $lang["travaux-1-b"] ?></button>
                    <div class="parag">
                        <h3><?= $lang["travaux-1"] ?></h3>
                        <p>
                        <?= $lang["travaux-1-p"] ?>
                        </p>
                    </div>
                </div>
                <div>
                    <button><?= $lang["travaux-2-b"] ?></button>
                    <div class="parag">
                        <h3><?= $lang["travaux-2-"] ?></h3>
                        <p>
                        <?= $lang["travaux-2-p"] ?>
                        </p>
                    </div>
                </div>
                <div>
                    <button><?= $lang["travaux-3-b"] ?></button>
                    <div class="parag">
                        <h3><?= $lang["travaux-3"] ?></h3>
                        <p>
                        <?= $lang["travaux-3-p"] ?>
                        </p>
                    </div>
                </div>
            </div>
            <button data-aos="fade-up" data-aos-duration="1400" class="button"><?= $lang["consult"] ?></button>
        </section>
        <section class="technologies">
            <h1 data-aos="fade-up" data-aos-duration="1200"><?= $lang["technologies"] ?></h1>
            <p data-aos="fade-up" data-aos-duration="1300"><?= $lang["technologies-p"] ?></p>
            <div class="arbre">
                <div class="logo">
                    <img data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500"  data-tilt-scale="1.3" src="RESOURCES/IMAGES/logo.png" alt="">
                </div>
                <div class="laravel"></div>
                <div class="javascript"></div>
                <div class="nodejs"></div>
                <div class="git-hub"></div>
                <div class="html"></div>
                <div class="autre"></div>
            </div>
        </section>
        <section class="contactez-nous" id="contactez-nous">
            <div class="container">
                <div class="text">
                    <h1 data-aos="fade-up" data-aos-duration="1000"><?= $lang["contacter-nous"] ?></h1>
                    <p data-aos="fade-up" data-aos-duration="1300"><?= $lang["contacter-nous-p"] ?></p>
                </div>
                <div class="form">
                    <form action="" method="post">
                        <label for="name"><?= $lang["contacter-nous-name"] ?><span>*</span></label>
                        <div class="input">
                            <input type="text" id="name" name="name" >
                        </div>

                        <label for="firstName"><?= $lang["contacter-nous-firstname"] ?><span>*</span></label>
                        <div class="input">
                            <input type="text" name="firstName" id="firstName" >
                        </div>

                        <label for="email"><?= $lang["contacter-nous-email"] ?><span>*</span></label>
                        <div class="input">
                            <input type="email" name="email" id="email" >
                        </div>

                        <label for="phone"><?= $lang["contacter-nous-phone"] ?></label>
                        <div class="input">
                            <input type="text" name="phone" id="phone">
                        </div>

                        <label for="message"><?= $lang["contacter-nous-message"] ?><span>*</span></label>
                        <div class="input">
                            <textarea name="message" id="message" cols="30" rows="10" ></textarea>
                        </div>
                        
                        <div class="submit">
                            <button type="submit" name="submit"><?= $lang["contacter-nous-send"] ?></button>
                        </div>

                    </form>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </main>
    <footer id="footer">
        <div class="footer-container">
            <div>
                <img src="RESOURCES/IMAGES/InfiniteSolutionsLogo.png" alt="">
                <p><?= $lang["footer-p"] ?></p>
            </div>
            <div class="entreprise">
                <h2><?= $lang["footer-enterprise"] ?></h2>
                <ul>
                    <li><?= $lang["footer-about"] ?></li>
                    <li><?= $lang["footer-blog"] ?></li>
                    <li><?= $lang["footer-projet"] ?></li>
                    <li><?= $lang["footer-team"] ?></li>
                    <li><?= $lang["footer-contact"] ?></li>
                </ul>
            </div>
            <div class="liens-utiles">
                <h2><?= $lang["footer-liens"] ?></h2>
                <ul>
                    <li><?= $lang["footer-liens-1"] ?></li>
                    <li><?= $lang["footer-liens-2"] ?></li>
                </ul>
            </div>
        </div>
        <div class="reseaux-sociaux">

        </div>
        <hr>
        <div class="copyright">
            <p>&copy; Infinite Solutions | Copyright 2022</p>
        </div>
    </footer>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="./JS/main.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script type="text/javascript" src="js/vanilla-tilt.min.js"></script>
    <script>
    AOS.init();
    </script>
</body>
</html>