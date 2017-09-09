<?php
session_start();
require_once 'libs/phpmailer/PHPMailerAutoload.php';

$errors =[];

if(isset($_POST['name'],$_POST['email'],$_POST['message'])){
    $fields=[
        'name'=>$_POST['name'],
        'email'=>$_POST['email'],
        'message'=>$_POST['message']
    ];
    foreach($fields as $field=>$data){
        if(empty($data)){
            $errors[]='Bitte f&uuml;lle das '.$field . ' -feld aus.';
        }
    }
    if(empty($errors)){
        $m= new PHPMailer;
        $m->isSMTP();
        $m->SMTPAuth=true;
        $m->Host='smtp.gmail.com';
        $m->Username='tobias.matys@gmail.com';//replace with your email address
        $m->Password='Bolshoi-1995';//replace with your password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $m->isHTML();
        $m->Subject ='Contact form Submitted';
        $m->Body='From:'.$fields['name'].'('.$fields['email'].')<p>'.$fields['message'].'</p>';

        $m->FromName='Contact';
        $m->AddAddress('tobias.matys@gmail.com','Tobias Matys');
        if ($m->send()) {
            header('Location:thanks.php');
            die();
        }else{
            $errors[]="Sorry ,Could not send email.Try again later.";
        }
    }
}

$_SESSION['errors']=$errors;
$_SESSION['fields']=$fields;
header ('Location:index.php');