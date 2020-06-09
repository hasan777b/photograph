<?php

include($_SERVER['DOCUMENT_ROOT'].'/photograph/backEnd/mailer/src/PHPMailer.php');
include($_SERVER['DOCUMENT_ROOT'].'/photograph/backEnd/mailer/src/SMTP.php');
class Mailer
{
    private $mail;
    public function __construct($message,$subject,$to)
    {
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $this->mail->CharSet = 'UTF-8';
//        $this->mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['USERNAME'];
        $this->mail->Password   = $_ENV['PASSWORD'];
        $this->mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = $_ENV['PORT'];
        //Recipients
        $this->mail->setFrom($_ENV['FROM'],$_ENV['APP_NAME']);
        $this->mail->addAddress($to);
        // Content
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $body = "
            <html>
                <head>
                    <meta charset=\"utf-8\">
                    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'></head>
                </head>
                <body>
                    <div class='row'>
                        ".$message."
                    </div>
                </body>
            </html>
        ";
        $this->mail->msgHTML($body);

    }

    public function send(){
        try{
            if($this->mail->send()){
                return true;
            }else{
                return false;
            }
        }catch (Exception $e){
            return $e;
        }
    }
}