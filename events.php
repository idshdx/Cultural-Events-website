<!-- Pagina responsabil pentru afisarea evenimentelor-->
<?php

$page = "events";
require "config/db-connect.cfg.php";
include "includes/header.inc.php";

if(isset($_POST['event']))
    echo '<div class="row"><div id="response" class="col-md-12 text-center"></div></div>';
    $event_page = mysqli_real_escape_string($dbc, $_POST['event']);
    $qry = "SELECT * FROM events WHERE categories_id = ". $event_page;
    $qry_result = mysqli_query($dbc, $qry);
    while ($row = mysqli_fetch_array($qry_result)) {
    	$event = ucwords($row["event"]);  //Nu mai este folosita in forma row['event'](ca in index.php)pentru ca s a atribuit unei variabile($event) si asta e folosita. Dar e acelasi lucru.
    	$image = $row["image"];
    	$text = $row["text"];
    	$event_id = $row["id"];
        echo '
        	<div class="panel panel-default object-container">
				<div class="panel-heading">'.$event.'</div> 
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-3 text-center">
								<img width="250px" class="img-responsive" src="'.$image.'">
								<hr>
								<span>
									<form class="vote-event">
										<button class="btn btn-success btnUp">
											<span class="glyphicon glyphicon-thumbs-up"></span>
												Like
											<span>'.$row["upvote"].'</span>
										</button>
										<button class="btn btn-danger btnDwn">
											<span class="glyphicon glyphicon-thumbs-down"></span>
												Dislike
											<span>'.$row["downvote"].'</span>
										</button>
										<input type="hidden" name="event_id" value="'.$event_id.'">
									</form>
									<form class="send-event">
										<span class="message"></span>
										<input type="email" name="email" class="form-control invite-email" placeholder="Introdu Adresa Email">
										<span class="btn btn-primary invite-span">Trimite unui prieten</span>
										<button class="btn btn-primary invite-btn">Trimite</button>
										<input type="hidden" name="event" value="'.$event.'">
                                                                                <input type="hidden" name="text" value=\''.$text.'\'>
									</form>
                                    <form name="formEdit'.$event_id.'" action="edit.php" method="post">
                                        <input type="hidden" name="sendName" value="event">
                                        <input type="hidden" name="sendId" value="'.$event_id.'">
                                    </form>
                                    <form class="formDelete" name="formDelete'.$event_id.'" method="post">
                                        <input type="hidden" name="sendName" value="event">
                                        <input type="hidden" name="sendId" value="'.$event_id.'">
                                    </form>
        ';
                                    if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
                                        echo '
                                            <button onclick="formEdit'.$event_id.'.submit()" class="btn btn-primary btnUp">Editeaza</button>
                                            <button type="button" class="btn btn-danger btnDwn" data-toggle="modal" data-target="#myModal'.$event_id.'">Sterge</button>
                                        ';
                                    }   
        echo '
                                </span>
								<hr>
                                <div id="myModal'.$event_id.'" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content text-center">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Sterge Eveniment</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Sigur vrei sa stergi categoria <b>'.ucwords($event).'</b> ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-md-12 text-center">
                                                    <form class="formDelete">
                                                        <input type="hidden" name="sendName" value="event">
                                                        <input type="hidden" name="sendId" value="'.$event_id.'">
                                                        <button class="btn btn-default btnDelete" data-dismiss="modal">Renunta</button>
                                                        <button class="btn btn-danger btnDelete">Sterge</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
							<p>
								'.$text.'
							</p>
						</div>
					</div>
				</div>
			</div>
        ';
    }

?>

<?php include "includes/footer.inc.php"; ?>
