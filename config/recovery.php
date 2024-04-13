<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require_once('config.php');
$email = $_POST['email'];
$query = "SELECT * FROM usuarios where correo = '$email' AND status = 1";
$result = $conexion->query($query);
$row = $result->fetch_assoc();

if($result->num_rows > 0){
  $mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp-mail.outlook.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'leoalmada16@outlook.com';
    $mail->Password   = 'JULIETa2002';
    $mail->Port       = 587;
    $email_template = 'mail_template.html';
    $mail->setFrom('leoalmada16@outlook.com', 'ADMINISTRACIÓN');
    $mail->addAddress('juliamuvi08@outlook.com', 'JULIA');
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Recuperación de contraseña';
    $mail->Body = '
        <html>
        <head>
            <style>
                /* Estilos CSS para el correo */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #c2a275;
                    color: #333;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #007bff;
                }
                p {
                    line-height: 1.6;
                }
                
            </style>
        </head>
        <body>
            <div class="container">
                <h1>¿Haz olvidado tu contraseña?</h1>
                <p>Estimado Usuario,</p>
                <p>Gracias por unirte a nuestro servicio. Esperamos que disfrutes de todas las características y beneficios que ofrecemos.</p>
                <p>Si deseas recuperar tu contraseña entra al siguiente link: <a href="localhost/reset_psswd/change_password.php?id='.$row['id'].'"></p>
                <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
                <p>¡Esperamos verte pronto!</p>
                <p>Atentamente,<br>El Equipo</p>
            </div>
        </body>
        </html>

    ';


    $mail->send();
    header("Location: ../index.php?message=ok");
} catch (Exception $e) {
  header("Location: ../index.php?message=error");
}

}else{
  header("Location: ../index.php?message=not_found");
}

?>
