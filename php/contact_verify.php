<?php

function onContactFormSubmit()
{
    $result = [
        'error' => [],
        'result' => []
    ];
    /*
    if (isset($_POST['name']))^M
        $this['entered_name'] = post('name');^M
    if (isset($_POST['email']))^M
        $this['entered_email'] = post('email');^M
    if (isset($_POST['message']))^M
        $this['entered_message'] = post('message');^M
    */

    if (!isset($_POST['recaptcha'])) {
        $result['error'][] = "Your email was not sent. We cannot receive confirmation of the reCaptcha puzzle. Please try again later.";
        return $result;
    }

    /* verify the reCaptcha */
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $secret = '6LedD0gUAAAAALujilJRKLBVUdEG48Qrt2pggdJK';
    $recaptcha = $_POST['recaptcha'];

    $remoteip = $_SERVER['REMOTE_ADDR'];
    $response = json_decode(file_get_contents("{$url}?secret={$secret}&response={$recaptcha}&remoteip={$remoteip}"), true);

    if (!$response['success']) {
        $error = "Your reCaptcha submission didn't work. Google replied back with error code(s):<ul>";
        foreach ($response['error-codes'] as $e) {
            $error .= "<li>{$e}</li>";
        }
        $error .= "</ul>";
        $result['error'][] = $error;
        return $result;
    }

    // Your email address
    $email_to = 'christopher@dreamfishsolutions.com';

    // Your custom email subject
    $email_subject = 'A new message from my website';

    // Send email (do not edit)
    if (isset($_POST['email'])) {

        $name = $_POST['name'];
        $email_from = $_POST['email'];
        $message = $_POST['message'];

        $email_message = 'Name: '.$name.'
        ';
        $email_message .= 'Email: '.$email_from.'
        ';
        $email_message .= 'Subject: '.$email_subject.'
        ';
        $email_message .= 'Message: '.$message;

        $headers = 'From: '.$email_from."\r\n".
        'Reply-To: '.$email_from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $mailresult = mail($email_to, $email_subject, $email_message, $headers);

        if ($mailresult) {
            $result['result'][] = 'Thank you! Your message has been sent, '.$name.'.';
        }

    }
    return $result;
}
$result = onContactFormSubmit();
echo json_encode($result);
