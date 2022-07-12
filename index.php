
<?php
session_start();

$msg = "";
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
                $msg = $error;
            }
        }else{
            if(send_mail($name, $email, $message)){
                add_message($name,$firstName,$email,$phone,$message);
                reply_mail($email);
                $msg = 'Votre message a été envoyer avec succès';
            }else{
                $msg = 'Nous n\'avons pas pu envoyer votre message';
            }
        }

        ?>        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        <?php

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
    <link rel="stylesheet" href="CSS/paralax.css">

    <title><?= $lang["title"] ?></title>
</head>
<body>
    <a class="pin" href="#header"><img src="RESOURCES/IMAGES/carret_left.png" alt=""></a>
    <header id="header">
        <div class="reseaux">
            <div>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9968 7.9983C9.79333 7.9983 7.99515 9.79651 7.99515 12C7.99515 14.2035 9.79333 16.0017 11.9968 16.0017C14.2002 16.0017 15.9984 14.2035 15.9984 12C15.9984 9.79651 14.2002 7.9983 11.9968 7.9983ZM23.9987 12C23.9987 10.3429 24.0137 8.70077 23.9206 7.04665C23.8275 5.12536 23.3893 3.4202 21.9843 2.01525C20.5764 0.607602 18.8743 0.172009 16.953 0.0789456C15.2959 -0.0141172 13.6539 0.000892936 11.9998 0.000892936C10.3427 0.000892936 8.70061 -0.0141172 7.04652 0.0789456C5.12526 0.172009 3.42014 0.610605 2.01522 2.01525C0.607291 3.42321 0.172005 5.12536 0.0789442 7.04665C-0.014117 8.70377 0.000892919 10.3459 0.000892919 12C0.000892919 13.6541 -0.014117 15.2992 0.0789442 16.9533C0.172005 18.8746 0.610294 20.5798 2.01522 21.9847C3.42314 23.3927 5.12526 23.828 7.04652 23.9211C8.70361 24.0141 10.3457 23.9991 11.9998 23.9991C13.6569 23.9991 15.2989 24.0141 16.953 23.9211C18.8743 23.828 20.5794 23.3897 21.9843 21.9847C23.3923 20.5768 23.8275 18.8746 23.9206 16.9533C24.0167 15.2992 23.9987 13.6571 23.9987 12ZM11.9968 18.1572C8.58954 18.1572 5.83973 15.4073 5.83973 12C5.83973 8.5927 8.58954 5.84284 11.9968 5.84284C15.404 5.84284 18.1538 8.5927 18.1538 12C18.1538 15.4073 15.404 18.1572 11.9968 18.1572ZM18.406 7.02864C17.6105 7.02864 16.968 6.38621 16.968 5.59067C16.968 4.79513 17.6105 4.1527 18.406 4.1527C19.2015 4.1527 19.8439 4.79513 19.8439 5.59067C19.8442 5.77957 19.8071 5.96667 19.735 6.14124C19.6628 6.31581 19.5569 6.47442 19.4233 6.608C19.2897 6.74157 19.1311 6.84748 18.9565 6.91967C18.782 6.99185 18.5949 7.02888 18.406 7.02864Z" fill="white"/>
                </svg>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 12.067C0 18.033 4.333 22.994 10 24V15.333H7V12H10V9.333C10 6.333 11.933 4.667 14.667 4.667C15.533 4.667 16.467 4.8 17.333 4.933V8H15.8C14.333 8 14 8.733 14 9.667V12H17.2L16.667 15.333H14V24C19.667 22.994 24 18.034 24 12.067C24 5.43 18.6 0 12 0C5.4 0 0 5.43 0 12.067Z" fill="white"/>
                </svg>
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.7206e-07 1.838C2.7206e-07 1.35053 0.193646 0.886032 0.538338 0.53834C0.88603 0.193648 1.35053 2.45031e-06 1.838 2.45031e-06H20.16C20.4016 -0.000392101 20.6409 0.0468654 20.8641 0.139069C21.0874 0.231273 21.2903 0.366612 21.4612 0.537339C21.6322 0.708065 21.7677 0.910826 21.8602 1.13401C21.9526 1.3572 22.0001 1.59643 22 1.838V20.16C22.0003 20.4016 21.9529 20.6409 21.8606 20.8642C21.7683 21.0875 21.6328 21.2904 21.462 21.4613C21.2912 21.6322 21.0884 21.7678 20.8651 21.8602C20.6419 21.9526 20.4026 22.0001 20.161 22H1.838C1.59655 22 1.35746 21.9524 1.1344 21.86C0.911335 21.7676 0.708671 21.6321 0.537984 21.4613C0.367297 21.2905 0.231932 21.0878 0.139623 20.8647C0.0473133 20.6416 -0.000131096 20.4025 2.7206e-07 20.161V1.838ZM8.708 8.388H11.687V9.884C12.117 9.024 13.217 8.25 14.87 8.25C18.039 8.25 18.79 9.963 18.79 13.106V18.928H15.583V13.822C15.583 12.032 15.153 11.022 14.061 11.022C12.546 11.022 11.916 12.111 11.916 13.822V18.928H8.708V8.388ZM3.208 18.791H6.416V8.25H3.208V18.79V18.791ZM6.875 4.812C6.88105 5.08668 6.83217 5.35979 6.73124 5.61532C6.66031 5.87084 6.47935 6.10364 6.28723 6.60003C6.09511 6.49643 5.8657 6.65248 5.61246 6.75901C5.35921 6.86554 5.08724 6.92042 4.8125 6.92042C4.53776 6.92042 4.26579 6.86554 4.01255 6.75901C3.7593 6.65248 3.52989 6.49643 3.33777 6.60003C3.14565 6.10364 2.99469 5.87084 2.89376 5.61532C2.79283 5.35979 2.74395 5.08668 2.75 4.812C2.76187 4.27286 2.98439 3.75979 3.36989 3.38269C3.75539 3.00558 4.27322 2.79442 4.8125 2.79442C5.35178 2.79442 5.86961 3.00558 6.25512 3.38269C6.64062 3.75979 6.86313 4.27286 6.875 4.812Z" fill="white"/>
                </svg>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <svg width="110" height="60" viewBox="0 0 110 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M92.3143 29.1294C91.9423 28.1454 91.587 27.1538 91.1945 26.1773C89.3794 21.6506 85.8825 19.4819 80.9618 19.3262C77.0173 19.2017 73.4769 20.2606 70.3148 22.9249C71.6026 22.7119 72.0876 22.4341 72.8881 22.388C77.1636 22.1389 80.89 25.6666 80.9195 29.9254C80.949 34.1842 77.2367 37.8053 72.9753 37.5176C71.7624 37.4251 70.599 37.0111 69.6119 36.3205C67.6351 34.8818 65.8508 33.1927 64.0036 31.5871L62.7786 60.5196L55.4668 38.6162C59.7641 43.0893 64.0524 47.3183 70.5855 48.3609C80.9233 50.0151 91.1162 42.8103 92.4875 32.7368C92.6491 31.5497 92.3592 60.6053 92.2861 29.0883L92.3143 29.1294Z" fill="#1D9A57"/>
                    <path d="M17.543 27.1151C18.6975 20.0212 24.1095 13.9487 31.3828 12.008C39.1358 9.94022 47.6367 12.8276 54.5072 20.6029L47.2891 29.1978C46.0961 28.1614 45.0391 27.2048 43.9398 26.2992C42.8405 25.3936 41.786 24.3784 40.543 23.7021C39.3616 23.0605 37.9775 22.4714 36.6575 22.4278C32.9875 22.6032 29.7742 25.1682 29.1572 28.7917C28.5491 32.3655 60.8248 35.999 34.4165 37.1923C34.8116 37.3231 35.2131 37.4415 35.7288 37.5947C27.9847 40.0262 20.891 36.8585 17.8329 29.7148C17.7636 29.2613 17.6918 28.8428 17.6469 28.3894C17.593 27.9684 17.5648 27.5399 17.543 27.1151Z" fill="#1D9A57"/>
                    <path d="M27.5251 46.4525C21.4537 43.3609 16.4188 36.2919 17.4451 27.8602C17.4733 27.596 17.5066 27.3619 17.5438 27.1602C17.5438 27.5537 17.5772 27.976 17.6182 28.3982C17.6734 28.8529 17.7388 29.2702 17.835 29.7199C17.8029 32.8888 20.3415 36.3952 23.8846 37.7194C31.4785 40.5557 38.3247 39.3848 43.9766 33.5664L44.0112 33.5603C44.4391 33.0854 44.9591 32.7335 45.5369 32.4975C46.1148 32.2615 46.7375 32.1468 47.3642 32.1609C47.9909 32.175 48.6075 32.3176 49.1735 32.5794C49.7394 32.8411 50.242 33.2161 50.6483 33.6797C51.7762 34.9731 52.3497 36.6377 52.2504 38.3298C52.1511 40.0219 51.3866 41.6124 50.1146 42.7729C49.6665 43.1823 49.2124 43.5855 48.7523 43.9824C42.5771 49.6063 34.4674 49.9877 27.5251 46.4525Z" fill="url(#paint0_linear_83_321)"/>
                    <path d="M82.1195 18.5203C77.4208 17.9959 73.1607 19.1132 69.7896 22.3992C68.9391 23.2276 68.1066 24.0746 67.2856 24.9316C66.7362 25.5062 66.0668 25.9602 65.3221 26.2634C64.5775 26.5666 63.7748 26.712 62.9677 26.6898C62.1606 26.6676 61.3676 26.4784 60.6419 26.1349C59.9161 25.7913 59.2742 25.6012 58.759 24.6974C57.8231 23.6029 57.3602 22.199 57.4673 20.7802C57.5745 19.3614 58.2434 18.038 59.3337 17.0878C59.8314 16.6568 60.3377 16.2366 60.8525 15.8272C64.579 12.8776 68.966 11.6006 73.8842 11.3591C83.732 11.4837 92.0995 19.1618 92.6896 28.6934C92.6973 28.8093 92.4535 28.9426 92.6047 29.0671C91.807 23.3372 87.8138 19.1618 82.1195 18.5203Z" fill="#273672"/>
                    <path d="M55.8312 24.6477C58.3462 24.6477 60.385 26.6275 60.385 29.0697C60.385 31.5119 58.3462 33.4917 55.8312 33.4917C53.3162 33.4917 51.2773 31.5119 51.2773 29.0697C51.2773 26.6275 53.3162 24.6477 55.8312 24.6477Z" fill="#273672"/>
                    <defs>
                    <linearGradient id="paint0_linear_83_321" x1="52.2568" y1="37.8875" x2="17.6091" y2="37.8875" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#273672"/>
                    <stop offset="0.13" stop-color="#254B6D"/>
                    <stop offset="0.37" stop-color="#236D64"/>
                    <stop offset="0.61" stop-color="#21855E"/>
                    <stop offset="0.82" stop-color="#1F945A"/>
                    <stop offset="1" stop-color="#1F9959"/>
                    </linearGradient>
                    </defs>
                </svg>
                <svg width="187" height="44" viewBox="0 0 187 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.24002 23V6.319H5.33792V23H2.24002ZM16.7843 10.1318C17.8011 10.1318 18.7066 10.3604 19.5009 10.7275C20.3112 11.1247 20.9466 11.7364 21.4073 12.5625C21.8681 13.3727 22.0984 14.4212 22.0984 15.708V23H19.1197V16.0893C19.1197 14.9613 18.8496 14.1194 18.6094 13.5633C17.7852 13.0073 17.0465 12.7293 16.0933 12.7293C15.3942 12.7293 14.7747 12.8722 14.2345 13.1582C13.6944 13.4442 13.2734 13.8731 12.9715 14.445C12.6856 15.0011 12.5426 15.708 12.5426 16.5659V23H9.56384V10.2748H12.3996V13.7063L11.8992 12.6578C12.344 11.8476 12.9874 11.228 13.8294 10.799C14.6873 10.3542 15.6723 10.1318 16.7843 10.1318ZM26.2823 23V9.55988C26.2823 8.2254 26.6715 7.16099 27.4499 6.36666C28.2443 5.55644 29.3722 5.15133 60.8338 5.15133C31.358 5.15133 31.8505 5.20693 32.3112 5.31814C32.7878 5.42935 33.185 5.6041 33.5027 5.8424L32.6925 8.08242C32.4701 7.90767 32.2159 7.78057 31.93 7.70114C31.644 7.60582 31.3501 7.55816 31.0483 7.55816C60.4287 7.55816 29.96 7.73291 29.6423 8.08242C29.3246 8.41604 29.1657 8.92441 29.1657 9.60754V11.0373L29.261 12.3718V23H26.2823ZM24.1852 12.7531V10.3701H32.6687V12.7531H24.1852ZM34.7657 23V10.2748H37.7445V23H34.7657ZM36.267 8.17774C35.711 8.17774 35.2503 8.00299 34.8849 7.65348C34.5354 7.60397 34.3606 6.88298 34.3606 6.39049C34.3606 5.88212 34.5354 5.46112 34.8849 5.1275C35.2503 4.77799 35.711 4.60324 36.267 4.60324C36.8231 4.60324 37.2758 4.77005 37.6253 5.10367C37.9907 5.4214 38.1734 5.82651 38.1734 6.319C38.1734 6.84326 37.9987 7.28809 37.6492 7.65348C37.2997 8.00299 36.8389 8.17774 36.267 8.17774ZM48.8757 10.1318C49.8925 10.1318 50.798 10.3604 51.5923 10.7275C52.4025 11.1247 53.038 11.7364 53.4987 12.5625C53.9594 13.3727 54.1898 14.4212 54.1898 15.708V23H51.211V16.0893C51.211 14.9613 50.941 14.1194 50.4008 13.5633C49.8766 13.0073 49.1378 12.7293 48.1846 12.7293C47.4856 12.7293 46.866 12.8722 46.3259 13.1582C45.7857 13.4442 45.3647 13.8731 45.0629 14.445C44.7769 15.0011 44.634 15.708 44.634 16.5659V23H41.6552V10.2748H44.491V13.7063L43.9906 12.6578C44.4354 11.8476 45.0788 11.228 45.9208 10.799C46.7787 10.3542 47.7636 10.1318 48.8757 10.1318ZM57.9685 23V10.2748H60.9473V23H57.9685ZM59.4698 8.17774C58.9138 8.17774 58.4531 8.00299 58.0877 7.65348C57.7382 7.60397 57.5634 6.88298 57.5634 6.39049C57.5634 5.88212 57.7382 5.46112 58.0877 5.1275C58.4531 4.77799 58.9138 4.60324 59.4698 4.60324C60.0258 4.60324 60.4786 4.77005 60.8281 5.10367C61.1935 5.4214 61.3762 5.82651 61.3762 6.319C61.3762 6.84326 61.2015 7.28809 60.852 7.65348C60.5024 8.00299 60.0417 8.17774 59.4698 8.17774ZM69.6467 23.1668C68.2487 23.1668 67.1684 22.8094 66.4058 22.0945C65.6433 21.3637 65.262 20.2913 65.262 18.8774V7.46284H68.2407V18.8059C68.2407 19.4096 68.3917 19.8783 68.6935 20.2119C69.0112 20.5455 69.4481 20.7123 70.0042 20.7123C70.6714 20.7123 71.2274 20.5376 71.6723 20.1881L72.5063 22.6089C72.1568 22.5949 71.7279 22.8094 71.2195 22.9523C70.7111 23.0953 70.1869 23.1668 69.6467 23.1668ZM63.165 12.7531V10.3701H71.6484V12.7531H63.165ZM80.5192 23.1668C79.1052 23.1668 77.8661 22.8888 76.8017 22.3328C75.7532 21.7608 74.935 20.9824 74.3472 19.9974C73.7753 19.0124 73.4893 17.8924 73.4893 16.6374C73.4893 15.3665 73.7673 14.2464 74.3234 13.2774C74.8953 12.2924 75.6737 11.5219 76.6587 10.9659C77.6596 10.4098 78.7955 10.1318 80.0664 10.1318C81.6055 10.1318 82.4097 10.4019 83.3788 10.942C84.3478 11.4822 85.1104 12.2447 85.6664 13.2297C86.2225 14.2147 86.5005 15.3744 86.5005 16.7089C86.5005 16.836 86.4925 16.979 86.4767 17.1378C86.4767 17.2967 86.4687 17.4476 86.4528 17.5906H75.8485V15.6127H84.88L83.7124 16.2323C83.7283 15.5015 83.5773 14.8581 83.2596 14.602C82.9419 13.746 82.505 13.6091 81.949 12.9914C81.4088 12.6737 80.7813 12.5148 80.0664 12.5148C79.3356 12.5148 78.6922 12.6737 78.1362 12.9914C77.596 13.6091 77.1671 13.754 76.8493 14.3259C76.5475 14.8819 76.3966 15.5412 76.3966 16.6038V16.7804C76.3966 17.5429 76.5713 18.2181 76.9208 18.8059C77.2703 19.3937 77.7628 19.8465 78.3983 20.1642C79.0338 20.482 79.7645 20.6408 80.5906 20.6408C81.6055 20.6408 81.949 20.5296 82.5209 20.6072C83.0928 20.0848 83.6012 19.7353 84.046 19.2587L85.6426 21.0936C85.0707 21.7608 84.3478 22.2772 83.4741 22.6425C82.6162 22.9921 81.6312 23.1668 80.5192 23.1668Z" fill="#1F9959"/>
                    <path d="M102.702 23.131C101.567 23.131 100.475 22.9491 99.4273 22.5852C98.394 22.2068 97.5936 21.7266 97.026 21.1444L97.6591 19.9001C98.1976 20.4241 98.9179 20.8679 99.8203 21.2318C100.737 21.581 101.698 21.7557 102.702 21.7557C103.662 21.7557 104.441 21.6393 105.038 21.4064C105.649 21.159 106.093 20.8316 106.369 20.4241C106.66 20.0166 106.806 19.5654 106.806 19.0706C106.806 18.4739 106.631 17.9937 106.282 17.6298C105.947 17.266 105.503 16.9822 104.95 16.7784C104.397 16.5601 103.786 16.371 103.117 16.2109C102.447 16.0508 101.778 15.8834 101.108 15.7088C100.439 15.5196 99.8203 15.2722 99.2527 14.9666C98.6996 14.6609 98.2485 14.2607 97.8992 13.7659C97.5645 13.2565 97.3971 12.5944 97.3971 11.7794C97.3971 11.0226 97.5936 10.3313 97.9865 9.70553C98.394 9.06518 99.0125 8.55582 99.8421 8.17743C100.672 7.78449 101.734 7.58802 103.029 7.58802C103.888 7.58802 104.739 7.71172 105.583 7.95913C106.427 8.19198 107.155 8.51943 107.766 8.94148L107.221 10.2294C106.566 9.79285 105.867 9.47268 105.125 9.26893C104.397 9.06518 103.691 8.96331 103.007 8.96331C102.091 8.96331 101.334 9.08701 100.737 9.33442C100.14 9.58183 99.6965 9.91655 99.4055 10.3386C99.129 10.7461 98.9907 11.2118 98.9907 11.7357C98.9907 12.3324 99.1581 12.8127 99.4928 13.1765C99.8421 13.5403 100.293 13.8241 100.846 14.0279C101.414 14.2316 102.032 14.4135 102.702 14.5736C103.371 14.7337 104.033 14.9083 104.688 15.0975C105.358 15.2867 105.969 15.5341 106.522 15.8398C107.09 16.1608 107.541 16.5238 107.876 17.0186C108.225 17.5134 108.399 18.161 108.399 18.9614C108.399 19.7037 108.196 20.395 107.788 21.0353C107.381 21.6611 106.755 22.1705 105.911 22.5634C105.081 22.9418 104.012 23.131 102.702 23.131ZM116.263 23.1092C115.157 23.1092 114.16 22.8617 113.273 22.3669C112.399 21.8576 111.708 21.1663 111.199 20.2931C110.689 19.4053 110.435 18.3939 110.435 17.2587C110.435 16.109 110.689 15.0975 111.199 14.2243C111.708 13.3511 112.399 12.6671 113.273 12.1723C114.146 11.6775 115.143 11.4601 116.263 11.4601C117.399 11.4601 118.403 11.6775 119.276 12.1723C120.164 12.6671 120.855 13.3511 121.35 14.2243C121.859 15.0975 122.114 16.109 122.114 17.2587C122.114 18.3939 121.859 19.4053 121.35 20.2931C120.855 21.1663 120.164 21.8576 119.276 22.3669C118.388 22.8617 117.384 23.1092 116.263 23.1092ZM116.263 21.7339C117.093 21.7339 117.828 21.5519 118.468 21.1881C119.109 20.8097 119.611 20.2858 119.974 19.6163C120.353 18.9323 120.542 18.1465 120.542 17.2587C120.542 16.3564 120.353 15.5705 119.974 14.9011C119.611 14.2316 119.109 13.715 118.468 13.3511C117.828 12.9728 117.1 12.7836 116.285 12.7836C115.47 12.7836 114.743 12.9728 114.102 13.3511C113.462 13.715 112.952 14.2316 112.574 14.9011C112.196 15.5705 112.007 16.3564 112.007 17.2587C112.007 18.1465 112.196 18.9323 112.574 19.6163C112.952 20.2858 113.462 20.8097 114.102 21.1881C114.743 21.5519 115.463 21.7339 116.263 21.7339ZM125.278 23V6.80214H126.828V23H125.278ZM135.878 23.1092C134.903 23.1092 134.051 22.9272 133.324 22.5634C132.596 22.1996 132.028 21.6538 131.621 20.9261C131.228 20.1985 131.032 19.2889 131.032 18.1974V11.5392H132.581V18.0228C132.581 19.2452 132.88 20.1694 133.476 20.7952C134.088 21.4064 134.939 21.712 136.031 21.712C136.831 21.712 137.522 21.5519 138.104 21.2318C138.701 20.897 139.152 20.4168 139.458 19.791C139.778 19.1652 139.938 18.4157 139.938 17.5425V11.5392H141.488V23H140.004V19.8565L140.244 20.4241C139.88 21.2682 139.312 21.9603 138.541 22.4106C137.784 22.8763 136.897 23.1092 135.878 23.1092ZM149.431 23.1092C148.355 23.1092 147.525 22.8181 146.943 22.2359C146.361 21.6538 146.07 20.8316 146.07 19.7692V9.00697H147.62V19.6818C147.62 20.3513 147.787 20.8679 148.122 21.2318C148.471 21.5956 148.966 21.7775 149.606 21.7775C150.29 21.7775 150.858 21.581 151.609 21.1881L151.855 22.6014C151.549 22.578 151.178 22.7817 150.741 22.9127C150.319 23.0437 149.883 23.1092 149.431 23.1092ZM144.018 12.8272V11.5392H151.112V12.8272H144.018ZM154.676 23V11.5392H156.226V23H154.676ZM155.462 9.00697C155.142 9.00697 154.873 8.89782 154.654 8.67952C154.436 8.46122 154.327 8.19926 154.327 7.89364C154.327 7.58802 154.436 7.33334 154.654 7.12959C154.873 6.91129 155.142 6.80214 155.462 6.80214C155.782 6.80214 156.051 6.90401 156.27 7.10776C156.488 7.31151 156.597 7.56619 156.597 7.87181C156.597 8.19198 156.488 8.46122 156.27 8.67952C156.066 8.89782 155.797 9.00697 155.462 9.00697ZM165.21 23.1092C164.104 23.1092 163.107 22.8617 162.22 22.3669C161.346 21.8576 160.655 21.1663 160.146 20.2931C159.636 19.4053 159.382 18.3939 159.382 17.2587C159.382 16.109 159.636 15.0975 160.146 14.2243C160.655 13.3511 161.346 12.6671 162.22 12.1723C163.093 11.6775 164.09 11.4601 165.21 11.4601C166.345 11.4601 167.35 11.6775 168.223 12.1723C169.111 12.6671 169.802 13.3511 170.297 14.2243C170.806 15.0975 171.061 16.109 171.061 17.2587C171.061 18.3939 170.806 19.4053 170.297 20.2931C169.802 21.1663 169.111 21.8576 168.223 22.3669C167.335 22.8617 166.331 23.1092 165.21 23.1092ZM165.21 21.7339C166.04 21.7339 166.775 21.5519 167.415 21.1881C168.055 20.8097 168.558 20.2858 168.921 19.6163C169.3 18.9323 169.489 18.1465 169.489 17.2587C169.489 16.3564 169.3 15.5705 168.921 14.9011C168.558 14.2316 168.055 13.715 167.415 13.3511C166.775 12.9728 166.047 12.7836 165.232 12.7836C164.417 12.7836 163.689 12.9728 163.049 13.3511C162.409 13.715 161.899 14.2316 161.521 14.9011C161.143 15.5705 160.953 16.3564 160.953 17.2587C160.953 18.1465 161.143 18.9323 161.521 19.6163C161.899 20.2858 162.409 20.8097 163.049 21.1881C163.689 21.5519 164.41 21.7339 165.21 21.7339ZM180.076 11.4601C181.007 11.4601 181.822 11.612 182.52 11.9759C183.234 12.3251 183.787 12.8636 184.18 13.5913C184.587 14.3189 184.791 15.2358 184.791 16.3418V23H183.241V16.4947C183.241 15.2867 182.935 14.3771 182.324 13.7659C181.727 13.1401 180.883 12.8272 179.792 12.8272C178.977 12.8272 178.264 12.9946 177.652 13.3293C177.056 13.6495 176.59 14.1225 176.255 14.7483C175.935 15.3595 175.775 16.1017 175.775 16.9749V23H174.225V11.5392H175.71V14.6828L175.469 14.0934C175.833 13.2638 176.415 12.6162 177.216 12.1505C178.016 11.6702 178.969 11.4601 180.076 11.4601Z" fill="#273672"/>
                </svg>
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
                <li class="nav-item">
                        <a href="#realisations" class="nav-link"><?= $lang["realisation"] ?></a>
                </li>
                <li class="nav-item">
                    <a href="index.php?lang=<?php if($_SESSION['lang'] == 'en'){echo('fr');}else{echo('en');} ?>" class="nav-link">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="60" height="60" fill="url(#pattern0)"/>
                        <defs>
                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_248_2" transform="scale(0.0078125)"/>
                        </pattern>
                        <image id="image0_248_2" width="60" height="60" xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>
                    </a>
                </li>
                </ul>
                <div class="nav-btn text-right">
                    <a href="#contactez-nous" class="contact-btn text-right"><?= $lang["contact"] ?></a>
                </div>
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
            <svg class="ellipse1" width="330" height="330" viewBox="0 0 330 330" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g style="mix-blend-mode:multiply">
                <circle cx="165" cy="165" r="165" fill="#B9E0CB"/>
                </g>
            </svg>
            <svg class="ellipse2" width="401" height="401" viewBox="0 0 401 401" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="200.5" cy="200.5" r="200.5" fill="#1C2651" fill-opacity="0.35"/>
            </svg>
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
                    <p data-aos="fade-up" data-aos-duration="1600"><?= $lang["services-1-p"] ?></p>
                    <button data-aos="fade-up" data-aos-duration="1350"><?= $lang["services-1-b"] ?></button>
                </div>
                <img src="RESOURCES/IMAGES/slider_img.png" alt="" data-aos="fade-left" data-aos-duration="1200" >
            </div>
            <div class="service-section">
                <img src="RESOURCES/IMAGES/slider_img.png" data-aos="fade-right" data-aos-duration="1400" alt="">
                <div>
                    <h3 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services-2"] ?></h3>
                    <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-2-p"] ?></p>
                    <button data-aos="fade-up" data-aos-duration="1600"><?= $lang["services-2-b"] ?></button>
                </div>
            </div>
            <div class="service-section">
                <div>
                    <h3 data-aos="fade-up" data-aos-duration="1000"><?= $lang["services-3"] ?></h3>
                    <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["services-3-p"] ?></p>
                    <button data-aos="fade-up" data-aos-duration="1600"><?= $lang["services-3-b"] ?></button>
                </div>
                <img src="RESOURCES/IMAGES/slider_img.png" alt="" data-aos="fade-left" data-aos-duration="1400">
            </div>

        </section>
        <section class="formations" id="formations" style="height: auto;">
            <div>
                <div class="formations-text" >
                <h1 data-aos="fade-up" data-aos-duration="1000"><?= $lang["formations"] ?></h1>
                <p data-aos="fade-up" data-aos-duration="1200"><?= $lang["formations-p"] ?></p>
                </div>
                <div class="formations-items">
                    <div class="formations-item formations-item-1" style="background-image: url(../RESOURCES/IMAGES/2.jpg);"></div>
                    <div class="formations-item formations-item-2" style="background-image: url(../RESOURCES/IMAGES/3.jpg)"></div>
                    <div class="formations-item formations-item-3" style="background-image: url(../RESOURCES/IMAGES/6.jpg)"></div>
                </div>
            </div>
        </section>
        <section class="realisations" id="realisations">
            <h1 data-aos="fade-up"data-aos-duration="1000" ><?= $lang["realise"] ?></h1>
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
        </section>
        <section class="travaux">
            <h1 data-aos="fade-up" data-aos-duration="1200"><?= $lang["travaux"] ?></h1>
            <div class="travaux-items">
                <div style="background-image: url(./RESOURCES/IMAGES/4.jpg); background-size: cover;">
                    <div class="parag">
                        <h3><?= $lang["travaux-1"] ?></h3>
                        <p>
                        <?= $lang["travaux-1-p"] ?>
                        </p>
                    </div>
                </div>
                <div style="background-image: url(./RESOURCES/IMAGES/6.jpg); background-size: cover;">
                    <div class="parag">
                        <h3><?= $lang["travaux-2-"] ?></h3>
                        <p>
                        <?= $lang["travaux-2-p"] ?>
                        </p>
                    </div>
                </div>
                <div style="background-image: url(./RESOURCES/IMAGES/3.jpg); background-size: cover;">
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
            <p data-aos="fade-up" data-aos-duration="1600"><?= $lang["technologies-p"] ?></p>
            <div class="arbre">
                <div class="logo">
                    <img data-tilt data-tilt-max="50" data-tilt-speed="10000" data-tilt-perspective="500" data-tilt-scale="1.3" src="RESOURCES/IMAGES/logo.png" alt="">
                </div>
                <div class="laravel"><img src="./RESOURCES/IMAGES/ASP.jpg" style="width: 100%;"></div>
                <div class="javascript"><img src="./RESOURCES/IMAGES/c.png" style="width: 100%;"></div>
                <div class="nodejs"><img src="./RESOURCES/IMAGES/Vue.js.png" style="width: 100%;"></div>
                <div class="git-hub"><img src="./RESOURCES/IMAGES/Xamarin.webp" style="width: 100%;"></div>
                <div class="html"><img src="./RESOURCES/IMAGES/laravel.png" style="width: 100%;"></div>
                <div class="autre"><img src="./RESOURCES/IMAGES/React.jpg" style="width: 100%;"></div>
            </div>
        </section>
        <section class="contactez-nous" id="contactez-nous">
            <div class="container">
                <div class="text">
                    <h1 data-aos="fade-up" data-aos-duration="1000"><?= $lang["contacter-nous"] ?></h1>
                    <p data-aos="fade-up" data-aos-duration="1600"><?= $lang["contacter-nous-p"] ?></p>
                </div>
                <div class="form">
                    <form action="" method="post">
                        <label for="name"><?= $lang["contacter-nous-name"] ?><span>*</span></label>
                        <div class="input">
                            <input class="form-control" type="text" id="name" name="name" >
                        </div>

                        <label for="firstName"><?= $lang["contacter-nous-firstname"] ?><span>*</span></label>
                        <div class="input">
                            <input class="form-control" type="text" name="firstName" id="firstName" >
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
                            <button type="submit"data-toggle="modal" data-target="#exampleModal" name="submit"><?= $lang["contacter-nous-send"] ?></button>
                        </div>

                    </form>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn6073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </main>
    <footer id="footer">
        <div class="footer-container">
            <div class="description">
                <img src="RESOURCES/IMAGES/logo.png" alt="">
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
            <div class="contacts">
                <h2>Contacts</h2>
                <ul>
                    <li>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.2078 22.8816L23.6068 19.7796C23.5266 19.5608 23.7009 19.6007 23.8199 19.0143C23.9389 18.7279 24.0001 18.4208 24 18.1107C24 17.4786 23.7524 16.8845 23.6068 16.4388L19.9689 13.101C19.7501 12.8812 19.49 12.7068 19.2036 12.5879C18.9172 12.4689 18.6101 12.4077 18.3 12.4078C17.668 12.4078 17.0738 12.6553 16.6282 13.101L14.1874 15.5417C12.9281 14.9704 11.7825 14.1761 10.8058 13.1971C9.82445 12.2205 9.02723 11.075 8.45243 9.81553L10.8932 7.37476C11.113 7.15594 11.2874 6.89586 11.4063 6.60946C11.5253 6.32605 11.5865 6.01596 11.5864 5.70583C11.5864 5.07379 11.3388 4.47961 10.8932 4.03398L7.55825 0.693205C7.33903 0.473159 7.07847 0.298631 6.79155 0.179664C6.50463 0.060697 6.19701 -0.000361707 5.88641 8.1319e-07C5.25437 7.85563e-07 4.66019 0.247574 4.21456 0.693205L1.11845 3.78932C0.404854 4.5 -2.39606e-07 5.48155 -2.83657e-07 6.48932C-2.92951e-07 6.70194 0.0174755 6.90583 0.052427 7.1068C0.699029 11.033 2.78738 14.9272 5.92718 18.0699C9.06408 21.2097 12.9553 23.2951 16.8932 23.9505C18.0961 24.1485 19.334 23.7495 20.2078 22.8816Z" fill="#414E83"/>
                    </svg>
                    (+237) 699 22 44 55
                    </li>
                    <li>
                    <svg width="31" height="24" viewBox="0 0 31 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.4545 0H1.09091C0.4875 0 0 0.4875 0 1.09091V22.9091C0 23.5125 0.4875 24 1.09091 24H29.4545C60.058 24 60.5455 23.5125 60.5455 22.9091V1.09091C60.5455 0.4875 60.058 0 29.4545 0ZM26.7 3.7125L15.9443 12.0818C15.6784 12.2898 15.6068 12.2898 15.0409 12.0818L4.28182 3.7125C4.24126 3.6812 4.21151 3.63799 4.19674 3.58894C4.18198 3.53988 4.18293 3.48743 4.19947 3.43894C4.21601 3.39045 4.2473 3.34836 4.28897 3.31855C4.36064 3.28874 4.38059 3.27272 4.43182 3.27273H26.55C26.6012 3.27272 26.6512 3.28874 26.6929 3.31855C26.7345 3.34836 26.7658 3.39045 26.7824 3.43894C26.7989 3.48743 26.7998 3.53988 26.7851 3.58894C26.7703 3.63799 26.7406 3.6812 26.7 3.7125Z" fill="#414E83"/>
                    </svg>
                    <a href="mailto: contact@infinitesolutions.com">e-mail</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="reseaux-sociaux">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.9968 7.9983C9.79333 7.9983 7.99515 9.79651 7.99515 12C7.99515 14.2035 9.79333 16.0017 11.9968 16.0017C14.2002 16.0017 15.9984 14.2035 15.9984 12C15.9984 9.79651 14.2002 7.9983 11.9968 7.9983ZM23.9987 12C23.9987 10.3429 24.0137 8.70077 23.9206 7.04665C23.8275 5.12536 23.3893 3.4202 21.9843 2.01525C20.5764 0.607602 18.8743 0.172009 16.953 0.0789456C15.2959 -0.0141172 13.6539 0.000892936 11.9998 0.000892936C10.3427 0.000892936 8.70061 -0.0141172 7.04652 0.0789456C5.12526 0.172009 3.42014 0.610605 2.01522 2.01525C0.607291 3.42321 0.172005 5.12536 0.0789442 7.04665C-0.014117 8.70377 0.000892919 10.3459 0.000892919 12C0.000892919 13.6541 -0.014117 15.2992 0.0789442 16.9533C0.172005 18.8746 0.610294 20.5798 2.01522 21.9847C3.42314 23.3927 5.12526 23.828 7.04652 23.9211C8.70361 24.0141 10.3457 23.9991 11.9998 23.9991C13.6569 23.9991 15.2989 24.0141 16.953 23.9211C18.8743 23.828 20.5794 23.3897 21.9843 21.9847C23.3923 20.5768 23.8275 18.8746 23.9206 16.9533C24.0167 15.2992 23.9987 13.6571 23.9987 12ZM11.9968 18.1572C8.58954 18.1572 5.83973 15.4073 5.83973 12C5.83973 8.5927 8.58954 5.84284 11.9968 5.84284C15.404 5.84284 18.1538 8.5927 18.1538 12C18.1538 15.4073 15.404 18.1572 11.9968 18.1572ZM18.406 7.02864C17.6105 7.02864 16.968 6.38621 16.968 5.59067C16.968 4.79513 17.6105 4.1527 18.406 4.1527C19.2015 4.1527 19.8439 4.79513 19.8439 5.59067C19.8442 5.77957 19.8071 5.96667 19.735 6.14124C19.6628 6.31581 19.5569 6.47442 19.4233 6.608C19.2897 6.74157 19.1311 6.84748 18.9565 6.91967C18.782 6.99185 18.5949 7.02888 18.406 7.02864Z" fill="white"/>
            </svg>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 12.067C0 18.033 4.333 22.994 10 24V15.333H7V12H10V9.333C10 6.333 11.933 4.667 14.667 4.667C15.533 4.667 16.467 4.8 17.333 4.933V8H15.8C14.333 8 14 8.733 14 9.667V12H17.2L16.667 15.333H14V24C19.667 22.994 24 18.034 24 12.067C24 5.43 18.6 0 12 0C5.4 0 0 5.43 0 12.067Z" fill="white"/>
            </svg>
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.7206e-07 1.838C2.7206e-07 1.35053 0.193646 0.886032 0.538338 0.53834C0.88603 0.193648 1.35053 2.45031e-06 1.838 2.45031e-06H20.16C20.4016 -0.000392101 20.6409 0.0468654 20.8641 0.139069C21.0874 0.231273 21.2903 0.366612 21.4612 0.537339C21.6322 0.708065 21.7677 0.910826 21.8602 1.13401C21.9526 1.3572 22.0001 1.59643 22 1.838V20.16C22.0003 20.4016 21.9529 20.6409 21.8606 20.8642C21.7683 21.0875 21.6328 21.2904 21.462 21.4613C21.2912 21.6322 21.0884 21.7678 20.8651 21.8602C20.6419 21.9526 20.4026 22.0001 20.161 22H1.838C1.59655 22 1.35746 21.9524 1.1344 21.86C0.911335 21.7676 0.708671 21.6321 0.537984 21.4613C0.367297 21.2905 0.231932 21.0878 0.139623 20.8647C0.0473133 20.6416 -0.000131096 20.4025 2.7206e-07 20.161V1.838ZM8.708 8.388H11.687V9.884C12.117 9.024 13.217 8.25 14.87 8.25C18.039 8.25 18.79 9.963 18.79 13.106V18.928H15.583V13.822C15.583 12.032 15.153 11.022 14.061 11.022C12.546 11.022 11.916 12.111 11.916 13.822V18.928H8.708V8.388ZM3.208 18.791H6.416V8.25H3.208V18.79V18.791ZM6.875 4.812C6.88105 5.08668 6.83217 5.35979 6.73124 5.61532C6.66031 5.87084 6.47935 6.10364 6.28723 6.60003C6.09511 6.49643 5.8657 6.65248 5.61246 6.75901C5.35921 6.86554 5.08724 6.92042 4.8125 6.92042C4.53776 6.92042 4.26579 6.86554 4.01255 6.75901C3.7593 6.65248 3.52989 6.49643 3.33777 6.60003C3.14565 6.10364 2.99469 5.87084 2.89376 5.61532C2.79283 5.35979 2.74395 5.08668 2.75 4.812C2.76187 4.27286 2.98439 3.75979 3.36989 3.38269C3.75539 3.00558 4.27322 2.79442 4.8125 2.79442C5.35178 2.79442 5.86961 3.00558 6.25512 3.38269C6.64062 3.75979 6.86313 4.27286 6.875 4.812Z" fill="white"/>
            </svg>
        </div>
        <hr>
        <div class="copyright">
            <p>&copy; Infinite Solutions | Copyright 2022</p>
        </div>
    </footer>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="./JS/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script type="text/javascript" src="js/vanilla-tilt.min.js"></script>
    <script>
    AOS.init();
    </script>
</body>
</html>