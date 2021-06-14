<?php
require_once '../autoloader.php';
// Set the name of the current page
$PAGE = 'index';

// Start session
session_start();
/*if(!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}
*/
// Get the basket
//$BASKET = new Basket($_SESSION['basket']);
$FORM   = new RegistrationForm($_POST);
$invitatiton_sent ='';
// Check if the form is submitted
if($FORM->isSubmitted()) {

    // Try to validate
    $FORM->validate();

    // If the form is valid, save it!
    if($FORM->isValid()) {
        $SUCCESS = $FORM->save();

        if($SUCCESS and $FORM->getFriendMailValue()!=''){
            include('../views/mail_html.php'); /** @param string $MAIL_HTML */
            // Load PHPMailer
            require '../PHPMailer/PHPMailerAutoload.php';
            try {
                $mail = new PHPMailer();
                $mail->Debugoutput = 'html';
                $mail->IsSMTP();
                $mail->Host = 'mail.jbence.hu';
                $mail->Port = 465;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';

                $mail->Username = 'info@jbence.hu';
                $mail->Password = 'pass';

                $mail->setFrom('info@jbence.hu', 'Józsa Bence Attila');

                $mail->addAddress($FORM->getFriendMailValue());
                $mail->Subject = 'Meghívó';
                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);
                $mail->Body = $MAIL_HTML;
                $mail->AltBody = strip_tags($MAIL_HTML);
                $mail->send();
                $FORM->mailToDB();
                $meghivo='Meghívó sikeresen kiküldve a ' . $FORM->getFriendMailValue() . ' címre.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }


        }
    }
}


// Do the rendering of the page
include '../views/header.php';
include '../views/registration.php';
include '../views/footer.php';
