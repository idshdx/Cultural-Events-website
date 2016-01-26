<!-- Pagina care afiseaza voturile sau le proceseaza -->
<?php
require "config/db-connect.cfg.php";

$errors = array();
$form_data = array();

if (empty($_POST['event_id']) || empty($_POST['btn_value'])) {
    $errors['error'] = 'Error: Empty';
    $errors['error'] = 'Error: Empty';
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
} else {
    $event_id = $_POST['event_id'];
    $btn_value = $_POST['btn_value'];
    //Ia toate voturile din baza de date si afiseaza le
    $qry = "SELECT upvote, downvote FROM events WHERE id = '$event_id'";
    $result = mysqli_query($dbc, $qry);
    $row = mysqli_fetch_assoc($result);
    $upVote = $row["upvote"];
    $dwnVote = $row["downvote"];
    //In functie de buton, updateaza voturile
    if ($btn_value == 'up') {
        $upVote++;
        $sql = "UPDATE events SET upvote = '$upVote' WHERE id = '$event_id'";
        mysqli_query($dbc, $sql);
    }
    elseif ($btn_value == 'down') {
        $dwnVote++;
        $sql = "UPDATE events SET downvote = '$dwnVote' WHERE id = '$event_id'";
        mysqli_query($dbc, $sql);
    }
    //Preia inputurile si atribuile variabilei $form_data(array)
    $form_data['success'] = true;
    $form_data['voted'] = 'Vote successfull';
    $form_data['upVote'] = $upVote;
    $form_data['dwnVote'] = $dwnVote;
    $form_data['eventNum'] = $event_id;
}

echo json_encode($form_data);

?>
