 <!-- Pagina proceseaza forma de invite, valideaza input-ul si ofera functionalitatea de mail -->
<?php

$errors = array();
$form_data = array();

if (empty($_POST['email'])) {
    $form_data['success'] = false;
    $errors['empty'] = 'Campul nu poate fi gol';
    $form_data['errors']  = $errors;
} else {
    $to = htmlspecialchars($_POST['email']);
    $event = $_POST['event'];
    $text = $_POST['text'];
    $subject = 'Barlad Event';
    $message = '
        <h2>'. $event .'</h2>
        <p>'. $text .'</p>' .
        "\r\n";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <webmaster@example.com>' . "\r\n";
    $result = mail($to, $subject, $message, $headers);
    //Confirmare daca email-ul a fost trimis sau nu
    if (!$result) {
        $form_data['success'] = false;
        $errors['sentError'] = 'Error: Evenimentul nu a fost trimis';
        $form_data['errors']  = $errors;
    } else {
        $form_data['success'] = true;
        $form_data['sent'] = 'Eveniment trimis';
    }
}
//Toate datele formei sunt transformate intr un obiect JSON
echo json_encode($form_data);

?>
