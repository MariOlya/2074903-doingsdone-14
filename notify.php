<?php
require_once('init.php');
require_once('model.php');
require_once('helpers.php');
require_once('myfunction.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once('vendor/autoload.php');

$mail = new PHPMailer();

$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->Host = 'phpdemo.ru';
$mail->Port = 25;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->Username = 'keks@phpdemo.ru';
$mail->Password = 'htmlacademy';

$mail->setFrom('keks@phpdemo.ru', 'keks');

$users_notify = get_users_notify($con);
$date = date('Y-m-d', strtotime("now"));
foreach ($users_notify as $user) {
    $user_id = $user['id'];
    $tasks_notify = get_tasks_notify($con, $user_id, $date);
    $mail->addAddress($user['email'], $task['name']);
    $mail->Subject = 'Уведомление от сервиса «Дела в порядке»';
    $mail->AltBody = 'Уважаемый, ' . $user['name'] . '. У вас запланирована задача ' . $tasks_notify . ' на ' . $date;
}

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}
