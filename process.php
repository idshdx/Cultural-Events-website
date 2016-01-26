<!-- Proceseaza formele de creat si editat, ofera validare si error-handling-->
<?php
require "config/db-connect.cfg.php";

$form_data = array();
//In oricare din cazurile specificate(Ex: nu are titlu) JSON-ul va avea success= false
if (empty($_POST['title']) || empty($_FILES['image-input']) || empty($_POST['text']) 
	|| empty($_POST['action']) || empty($_POST['action_type']) || empty($_POST['action_id'])) {
    $form_data['success'] = false;
} else { //In caz contrat preia inputurile din forma
    $title = htmlspecialchars($_POST['title']);
    $text = $_POST['text'];
    $action = $_POST['action'];
    $action_type = $_POST['action_type'];
    $action_id = $_POST['action_id'];
    if (isset($_POST['category_id'])) {
    	$category_id = $_POST['category_id'];
    }
    //Atribuie un unique ID pentru fiecare poza uploadata, si uplodeaz o in folderul specificat.
    $random = uniqid();
    $target_dir = "images/";
        $target_file = $target_dir . $random . '_' . $_FILES["image-input"]["name"];
	$uploadOk = 1;
	//procesare in functie de titlul actiunii(create sau edit)
	if($action == 'create') {
		if (file_exists($target_file)) {
		    $form_data['success'] = false;
		    $uploadOk = 0;
		}
	}
	//Validare pentru poze
	if ($_FILES["image-input"]["size"] > 2048000) {
	    $form_data['success'] = false;
	    $uploadOk = 0;
	}
	if ($uploadOk == 0) {
	    $form_data['success'] = false;
	    $form_data['error'] = 'A aparut o eroare la uploadul imaginii.';
	} else {
		move_uploaded_file($_FILES["image-input"]["tmp_name"], $target_file);
		if($action == 'create') {
			//In functie de caz insereaza sau updateaza intrarile din baza de date
			if($action_type == 'category') {
				$sql = "INSERT INTO categories (category, image, text) VALUES ('$title', '$target_file', '$text')";
		    	mysqli_query($dbc, $sql);
			    $form_data['success'] = true;
			    $form_data['saved'] = 'Categorie salvata cu succes.';
			} elseif ($action_type == 'event') {
				$sql = "INSERT INTO events (categories_id, event, image, text) VALUES ('$category_id', '$title', '$target_file', '$text')";
		    	mysqli_query($dbc, $sql);
		    	$form_data['success'] = true;
			    $form_data['saved'] = 'Eveniment salvat cu succes.';
			} else {
				$form_data['success'] = false;
	    		$form_data['error'] = 'A aparut o eroare la inserarea in baza de date.';
			}
		} elseif ($action == 'edit') {
			if($action_type == 'category') {
				$sql = "UPDATE categories SET category = '$title', image = '$target_file', text = '$text' WHERE id = '$action_id'";
		    	mysqli_query($dbc, $sql);
			    $form_data['success'] = true;
			    $form_data['saved'] = 'Categorie editata cu succes.';
			} elseif ($action_type == 'event') {
				$sql = "UPDATE events SET event = '$title', image = '$target_file', text = '$text' WHERE id = '$action_id'";
		    	mysqli_query($dbc, $sql);
		    	$form_data['success'] = true;
			    $form_data['saved'] = 'Eveniment editat cu succes.';
			} else {
				$form_data['success'] = false;
	    		$form_data['error'] = 'A aparut o eroare la inserarea in baza de date.';
			}
		} 
	    
	}
}

echo json_encode($form_data);

?>
	