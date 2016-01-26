<?php
//Datele de conectarea la baza de date
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'password');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'barlad-project');

$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($dbc, 'utf8');

//Functie de securitate
function escape_data ($data, $dbc) {
	if (get_magic_quotes_gpc()) $data = stripslashes($data);
		return mysqli_real_escape_string ($dbc, trim($data));
}
