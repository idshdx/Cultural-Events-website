<?php
$page = "";
require "config/db-connect.cfg.php";
include "includes/header.inc.php";
//Afiseaza forma in functie de titlul titlul paginii(Create Category-> Alte labele, alte placeholdere, etc, Create Event-> Alte labele, alte placeholdere, etc)
//si seteaza variabile pentru a fi folosite in forma de mai jos
if (isset($_POST['sendVal'])) {
	$action = 'create';
	if ($_POST['sendVal'] == 'category') {
		$heading = 'Creaza Categorie';
		$title_label = 'Nume Categorie';
		$placeholder = 'Ex: Teatru, Cinema ...';
		$help_block = 'Dimensiune recomandata: 200 x 180 pixeli.';
		$submit = 'Salveaza Categorie';
		$action_type = 'category';
	} elseif ($_POST['sendVal'] == 'event') {
		$heading = 'Creaza Eveniment';
		$title_label = 'Nume Eveniment';
		$placeholder = 'Ex: Take Ianke si Cadir, Avatar ...';
		$help_block = 'Dimensiune recomandata: 250 x 180 pixeli.';
		$submit = 'Salveaza Eveniment';
		$action_type = 'event';
	}
}

?>
		<!-- Afiseaza forma necesara pentru adaugat categorie sau event, in functie de titlul paginii.-->
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $heading; ?></div>
			<div class="panel-body">
				<div class="row">
                    <form id="process-form" name="processForm" enctype="multipart/form-data">
						<div class="row">
							<div id="response" class="col-md-12 text-center"></div>
	                        <div class="form-group">
	                            <label for="title" id="title-input-label"><?php echo $title_label; ?> </label>
								<div class="text-danger" id="title-error"></div>
								<input type="text" class="form-control" id="title-input" name="title-input" placeholder="<?php echo $placeholder; ?>">
	                        </div>
							<div class="form-group">
	                            <label for="image" id="image-input-label">Imagine </label><br>
								<div class="text-danger" id="image-error"></div>
								<span class="btn btn-default btn-file">
								    Browse <input type="file" id="image-input" name="image-input">
								</span>
								<span id="picture-name"></span>
								<p class="help-block"><?php echo $help_block; ?></p>
	                        </div>
	                        
	                        <?php
	                        //In caz ca se creaza un eveniment, este necesar sa se fie atribuit unei categorii. 
        					//Astfel, luam din baza de date toate categoriile si afiseaza le intr un dropdown.
	                        if ($_POST['sendVal'] == 'event') {
	                        	$qry = "SELECT id, category FROM categories";
        						$qry_result = mysqli_query($dbc, $qry);
		                        echo '
			                        <div class="form-group">
			                            <label for="sel1" id="select-input-label">Categorie Eveniment</label>
										<div class="text-danger" id="select-error"></div>
										<select name="category_id" class="form-control" id="select-input">
	        								<option disabled="disabled" selected="selected">Selecteaza</option>
			                        
			                    ';
			                    while ($row = mysqli_fetch_array($qry_result))
					            	echo '<option value="'. $row['id'] .'">'.ucwords($row['category']).'</option>';      
					        	echo '</select></div>';
	                        }
	                        ?>
	                        
						</div>
						<div class="row">
							<div class="form-group col-md-11" id="wysiwyg">
								<label for="text">Text </label>
								<div class="text-danger" id="text-error"></div>
	                            <div id="summernote"></div>
	                        </div>
						</div>
						<input type="hidden" name="action" value="<?php echo $action; ?>">
						<input type="hidden" name="action_type" value="<?php echo $action_type; ?>">
						<button id="process-submit" type="submit" class="btn btn-primary"><?php echo $submit; ?></button><hr>
						<p class="help-block">* Toate campurile sunt obligatorii.</p>
                    </form>
				</div>
			</div>
		</div>

<?php include "includes/footer.inc.php"; ?>
