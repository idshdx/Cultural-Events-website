<!-- Pagina principala a site-lui(cand accesezi root-ul proiectului, automat ruleaza index.php). Aici sunt afisate toate categoriile-->
<?php
//Seteaza numele paginii
$page = "categories";
//Se includ dependetele proiectului:
//Pagina necesita conexiunea la baza de date. Require() e la fel ca include(), numai ca in caz de eroare, se opreste continuarea scriptului
require "config/db-connect.cfg.php";
//Incluzi headerul paginii: In caz de eroare, restul paginii se afiseaza in continuare(scriptul continua)
include "includes/header.inc.php";

?>
		<!-- HTML-ul(Structura) titlului de pagina. S a folosit clase specifice librariei CSS  bootstrap(Twitter Bootstrap 3) -->
		<div class="panel panel-default">
			<div class="panel-heading">Welcome to Barlad City</div>
			<div class="panel-body">
				<div class="row">
					<!-- S a folosit grid-ul din bootstrap pentru impartirea paginii, si pentru a face site ul responsive(Ex: col-md-12) -->
					<div id="response" class="col-md-12 text-center"></div>

					<?php
						//Umplem pagina cu date provenite din baza de date
		                $qry = "SELECT * FROM categories"; //Selectam tot din tabelul 'categories'
		                $qry_result = mysqli_query($dbc, $qry); //Rulam query-ul. Prima variabila e conexiunea la baza de date, a doua query-ul specificat mai sus stocat in variabila $qry.
		                $i = 0; $hr = '';
		                while ($row = mysqli_fetch_array($qry_result)) { // Treci prin fiecare element intors de query: mysqli_fetch_array: Rezultatele query-ului intoarse sunt de tipul array.
		                	$i++;										//$row(variabila va retine datele din fiecare coloana din tabelul categories=>Ex. row["id"]=>id-ul categoriei, row["text"]=> textul categoriei )
		                	if($i % 2 == 0)								//Accesand itemele din array, populam pagina
		                		$hr = '<div class="col-md-12"></div>'; //Work-Around pentru incadrare in pagina
		                	else
		                		$hr = ''; //In caz ca numarul de categorii este impar adauga clasa bootstrap col-md-6 (diviziunea ocupa jumatate  din div-ul parinte(latime).In cazul de fata, jumatate de pagina).Col-md-12 ocupa tot width-ul. Ai informatii pe net
		                    echo '  
			                    <div class="col-md-6 object-container">
			                    	<form name="event_'.str_replace(" ","_",strtolower($row["category"])).'" action="events.php" method="post">
				                    	<input type="hidden" name="event" value="'.$row["id"].'">
										<div class="media">
											<a href="#" onclick="event_'.str_replace(" ","_",strtolower($row["category"])).'.submit()"><h3 class="media-heading">'.ucwords($row["category"]).'</h3></a>
											<div class="media-left">
												<a href="#" onclick="event_'.str_replace(" ","_",strtolower($row["category"])).'.submit()">
													<img width="200px" src="'.$row["image"].'">
													<a href="#" onclick="event_'.str_replace(" ","_",strtolower($row["category"])).'.submit()" class="btn btn-primary vezi-evenimente">Vezi evenimente</a>
												</a>
								';			//Daca userul este logat afiseaza butoanele de Edit si Delete	
											if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
												echo '
													<a href="#" onclick="document.getElementsByName(\'formEdit'.$row["id"].'\')[0].submit()" class="btn btn-primary btnEdit">Editeaza</a>
													<button type="button" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModal'.$row["id"].'">Sterge</button>
						                    	';
						                    }	

								echo '
											</div>
											<div class="media-body">
												<p>
													'.$row["text"].'
												</p>
											</div>
										</div>
									</form>
									<form name="formEdit'.$row["id"].'" action="edit.php" method="post">
										<input type="hidden" name="sendName" value="category">
										<input type="hidden" name="sendId" value="'.$row["id"].'">
									</form>
									<hr>
			                    	<div id="myModal'.$row["id"].'" class="modal fade" role="dialog">
			                    		<div class="modal-dialog modal-md">
			                    			<div class="modal-content text-center">
			                    				<div class="modal-header">
			                    					<h4 class="modal-title">Sterge Categorie</h4>
			                    				</div>
			                    				<div class="modal-body">
			                    					<p>Sigur vrei sa stergi categoria <b>'.ucwords($row["category"]).'</b> ?</p>
			                    				</div>
			                    				<div class="modal-footer">
				                    				<div class="col-md-12 text-center">
				                    					<form class="formDelete">
															<input type="hidden" name="sendName" value="category">
															<input type="hidden" name="sendId" value="'.$row["id"].'">
															<button class="btn btn-default btnDelete" data-dismiss="modal">Renunta</button>
				                    						<button class="btn btn-danger btnDelete">Sterge</button>
														</form>
				                    				</div>
			                    				</div>
			                    			</div>
			                    		</div>
			                    	</div>
			                    </div>
		                    ';
		                    echo $hr;
		                }
		            ?>

				</div>
			</div>
		</div>
<!--Se include footerul paginii-->
<?php include "includes/footer.inc.php"; ?>
