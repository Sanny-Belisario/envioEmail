<?php

include "config.php";
include TEMPLATE_PATH."\header.php";
include TEMPLATE_PATH."\\nav.php";

?>
<main>

<h2>Contato</h2>
<div id="formulario">
    <h3>Envio de emails</h3>
    <form action="contato.php" method="POST"  enctype="multipart/form-data">
        <div class="mb-3">
            <input type="text"class="form-control" id="exampleFormControlInput1" name="nome" placeholder="nome">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="exampleFormControlInput1" name="assunto" placeholder="Assunto"/>
        </div>
        <div class="mb-3">
            <textarea class="form-control" id="exampleFormControlTextarea1" name="mensagem" placeholder="Mensagem" rows="3"></textarea>
        </div>
        <input type="submit"  class="btn btn-primary" name="enviar" value="Enviar"/>
    </form>
</div>

</main>
<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$nome = $_POST["nome"];
$assunto = $_POST["assunto"];
$mensagem = $_POST["mensagem"];

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', $nome);
    $mail->addAddress('sanny-belisario@educar.rs.gov.br', 'Sanny');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $assunto;
    $mail->Body    = $mensagem;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

include TEMPLATE_PATH."\\footer.php";

?>