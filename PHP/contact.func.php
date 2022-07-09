<?php
    function send_mail($name, $mail, $message){
/*==========================Format Texte=======================*/
        $destinataire = "hello@isolutions-intl.com";
        $expediteur = $mail;
        $objet = "Besoin Expertise";
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= "Besoin Expertise"."\r\n";
        $headers .= 'From: '.$name."<".$expediteur.">"."\r\n";
        $headers .= 'Delivered-to: '.$destinataire."\r\n";
        
        $success = mail($destinataire, $objet, $message, $headers);
        return $success;
/*========================Format HTML==========================*/
        // $destinataire = "hello@isolutions-intl.com";
        // $expediteur = $mail;
        // $objet = "Besoin Expertise";
        // $headers = 'MIME-Version: 1.0'."\r\n";
        // $headers .= "Besoin Expertise"."\r\n";
        // $headers .='Content-type:text/html;charset=iso-8859-1'."\r\n";
        // $headers .= 'From: ".$name."<".$expediteur.">"."\r\n";
        // $headers .= 'Delivered-to: '.$destinataire."\r\n";
        // $message = '
        //         <html>
        //         <head>
        //             <title></title>    
        //         </head>
        //         <body>
        //             <h4>Expertise de l\'entreprise</h4>
        //             <div style="width:100%; text-align: center; font-weight: bold">  Un simple mail de confirmation</div>
        //         </body>
        //         </html>';
        
        // $success = mail($destinataire, $objet, $message, $headers);
        // return $success;
    }

    function reply_mail($mail){
        $destinataire = $mail;
        $expediteur = "hello@isolutions-intl.com";
        $objet = "Reponse à votre mail";
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'From: isolutions-intl<'.$expediteur.'>'."\n";
        $headers .= 'Delivered-to: '.$destinataire."\n";
        $message = "Nous avons pris connaissances de vos mail, nous revenos vers vous d'ici peu";
        
        if(mail($destinataire, $objet, $message, $headers)){
            echo "succès";
        }else{
            echo "echec";
        }
    }
    function add_message($name,$firstName,$email,$phone,$message){
        $db  = connect_db(); 
        $tab = [
            "name"      => $name,
            "firstName" => $firstName,
            "email"     => $email,
            "phone"     => $phone,
            "message"   => $message
        ];

        $sql = "INSERT INTO contact (name,firstName,email,phone,message) VALUES (:name,:firstName,:email,:phone,:message)";
        $req = $db->prepare($sql);
        $req->execute($tab);
    }