<?php
$page = "";
require "config/db-connect.cfg.php";
include "includes/header.inc.php";
//Afiseaza forma in functie de titlul titlul paginii(Create Category-> Alte labele, alte placeholdere, etc, Create Event-> Alte labele, alte placeholdere, etc)

if (isset($_POST['sendName']) && isset($_POST['sendId'])) {
	$action = 'edit';
	if ($_POST['sendName'] == 'category') {
		$action_id = $_POST['sendId'];
		$qry = "SELECT * FROM categories WHERE id = '$action_id'";
	    $result = mysqli_query($dbc, $qry);
	    $row = mysqli_fetch_assoc($result);
		$heading = 'Editeaza Categorie';
		$title_label = 'Nume Categorie';
		$edit_name = $row['category'];
		$help_block = 'Dimensiune recomandata: 200 x 180 pixeli.';
		$edit_text = $row['text'];
		$submit = 'Salveaza Categorie';
		$action_type = 'category';
	} elseif ($_POST['sendName'] == 'event') {
		$action_id = $_POST['sendId'];
		$qry = "SELECT * FROM events WHERE id = '$action_id'";
	    $result = mysqli_query($dbc, $qry);
	    $row = mysqli_fetch_assoc($result);
		$heading = 'Editeaza Eveniment';
		$title_label = 'Nume Eveniment';
		$edit_name = $row['event'];
		$help_block = 'Dimensiune recomandata: 250 x 180 pixeli.';
		$edit_text = $row['text'];
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
								<input type="text" class="form-control" id="title-input" name="title-input" value="<?php echo ucwords($edit_name); ?>">
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
						</div>
						<div class="row">
							<div class="form-group col-md-11" id="wysiwyg">
								<label for="text">Text </label>
								<div class="text-danger" id="text-error"></div>
	                            <div id="summernote">
	                            	<?php echo $edit_text; ?>
	                            </div>
	                        </div>
						</div>
						<input type="hidden" name="action" value="<?php echo $action; ?>">
						<input type="hidden" name="action_type" value="<?php echo $action_type; ?>">
						<input type="hidden" name="action_id" value="<?php echo $action_id; ?>">
						<button type="submit" id="process-submit" class="btn btn-primary"><?php echo $submit; ?></button><hr>
						<p class="help-block">* Toate campurile sunt obligatorii.</p>
                    </form>
				</div>
			</div>
		</div>

<?php include "includes/footer.inc.php"; ?>
	