<?php
header('location: ./HTML');

include "../PHP/contact.func.php";
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
                echo "Nous n'avons pas pu envoyer votre message";
            }
        }
    endif;
?>