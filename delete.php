<?php
require "config/db-connect.cfg.php";

$form_data = array();
//Validarea formei de delete, in cazurile specificate. Ajax call-ul va fi va avea success=false; In caz cotrar, trimite obiectul JSON pentru ajax call
if (empty($_POST['action']) || empty($_POST['action_type']) || empty($_POST['action_id'])) {
    $form_data['success'] = false;
} else {
	$action = $_POST['action'];
    $action_type = $_POST['action_type'];
    $action_id = $_POST['action_id'];
    //Diferite cazuri de procesare si rezultatele lor
	if ($action == 'delete') {
		if($action_type == 'category') {
			$sql = "DELETE FROM categories WHERE id = '$action_id'";
	    	mysqli_query($dbc, $sql);
		    $form_data['success'] = true;
		    $form_data['deleted'] = 'Categorie stearsa cu succes';
		} elseif ($action_type == 'event') {
			$sql = "DELETE FROM events WHERE id = '$action_id'";
	    	mysqli_query($dbc, $sql);
	    	$form_data['success'] = true;
		    $form_data['deleted'] = 'Eveniment sters cu succes';
		} else {
			$form_data['success'] = false;
			$form_data['error'] = 'A aparut o eroare la stergerea din baza de date.';
		}
	}
}
//Transforma variabila(si valoarea) $form_data intr o reprezentare JSON(Obiect JSON)
echo json_encode($form_data);

?>
