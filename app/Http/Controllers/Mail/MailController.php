<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;

class MailController extends Controller
{
     public function __construct($data, $message){
    	$mail = new PHPMailer(true);
    	try{
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8'; 
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587; 
            $mail->Username = 'taspiyataspiya13@gmail.com';
            $mail->Password = 'tttttttt091267';
            $mail->setFrom('taspiyataspiya13@gmail.com', 'My website'); 
            $mail->Subject = $data["sub"];
            $mail->MsgHTML($message);
            $mail->addAddress($data["email"] , $data["name"]); 
            $mail->send();
        }catch(phpmailerException $e){
            dd($e);
        }catch(Exception $e){
            dd($e);
        }
    }
}
