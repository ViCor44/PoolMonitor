<?php 
/*
	Projeto Final LEI
	Ficheiro: functions.php
	Autor: Victor Correia
	Descrição: Ficheiro com as diversas funções para verificação de utilizadores
*/
include('connection.php');
session_start();

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

$username = "";
$errors   = array(); 

// chama a função register
if (isset($_POST['register_btn'])) {
	register();
}

function register(){	
	global $db, $errors, $username;	
	$username    =  e($_POST['username']);	
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// validaçáo de formulário
	$query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($db,$query);
    if(mysqli_num_rows($result)>=1){
		array_push($errors, "Username já existente!");
	}
	if (empty($username)) { 
		array_push($errors, "Username - campo obrigatório"); 
	}	
	if (empty($password_1)) { 
		array_push($errors, "Password - campo obrigatório"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "As passwords não são iguais!");
	}

	// registo de utilizador
	if (count($errors) == 0) {
		$password = md5($password_1); // encripta a password antes de guardar na base de dados		
		$query = "INSERT INTO users (username, userType, password, checkAdmin) 
					VALUES('$username', 'user', '$password', 0)";
		mysqli_query($db, $query);		
		$logged_in_user_id = mysqli_insert_id($db);
		$_SESSION['user'] = getUserById($logged_in_user_id);
		$_SESSION['success']  = "Espere que um administrador o autorize!";
		header('location: unchecked.php');			
	}
}

if (isset($_POST['IP_register_btn'])) {
	IPRegister();
}
function IPRegister(){	
	global $db, $errors, $IP, $ID;	
	$poolName = e($_POST['poolName']);
	$IP	 =  e($_POST['ip']);
	echo $poolName;
	$sql = "SELECT id FROM piscinas WHERE name = '$poolName'";
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	$ID = $row['id'];
	
	// validaçáo de formulário
	$query = "SELECT * FROM ip_table WHERE IP = '$IP'";
    $result = mysqli_query($db,$query);
    if(mysqli_num_rows($result)>=1){
		array_push($errors, "IP já existente!");
	}
	if (empty($IP)) { 
		array_push($errors, "IP - campo obrigatório"); 
	}
	if (!filter_var($IP, FILTER_VALIDATE_IP)) {
		array_push($errors, "Introduza um IP válido!");
	}	
	// registo de IP
	if (count($errors) == 0) {
		$query = "INSERT INTO ip_table (IP, id_pisc) 
					VALUES('$IP', '$ID')";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Registada com sucesso!";		
	}
}


if (isset($_POST['IP_remove_btn'])) {
	IPRemove();
}
function IPRemove(){
	
	global $db, $errors, $IP;	
	$IP    =  e($_POST['ip']);
	if (count($errors) == 0) {
		$query = "DELETE FROM ip_table 
					WHERE IP = '$IP'";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Removido com sucesso!";		
	}
}

if (isset($_POST['user_remove_btn'])) {
	UserRemove();
}

function UserRemove(){
	
	global $db, $errors, $user;	
	$user    =  e($_POST['user']);
	if (count($errors) == 0) {
		$query = "DELETE FROM users 
					WHERE username = '$user'";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Removido com sucesso!";		
	}
}

if (isset($_POST['user_permission_btn'])) {
	UserPermission();
}

function UserPermission(){
	
	global $db, $errors, $user;	
	$user    =  e($_POST['user']);
	if (count($errors) == 0) {
		$query = "UPDATE users 
					SET checkAdmin = 1
					WHERE username = '$user'";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Permissão Concedida!";		
	}
}

if (isset($_POST['pool_remove_btn'])) {
	PoolRemove();
}
function PoolRemove(){
	
	global $db, $errors, $pool;	
	$pool    =  e($_POST['pool']);
	if (count($errors) == 0) {
		$query = "DELETE FROM piscinas 
					WHERE name = '$pool'";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Removido com sucesso!";		
	}
}


if (isset($_POST['pool_register_btn'])) {
	poolRegister();
}

function poolRegister(){
	
	global $db, $errors, $poolName;
	
	$poolName    =  e($_POST['poolName']);	

	// validaçáo de formulário
	$query = "SELECT * FROM piscinas WHERE name = '$poolName'";
    $result = mysqli_query($db,$query);
    if(mysqli_num_rows($result)>=1){
		array_push($errors, "Piscina já existente!");
	}
	if (empty($poolName)) { 
		array_push($errors, "Designação - campo obrigatório"); 
	}	
	// registo de piscina
	if (count($errors) == 0) {
		$query = "INSERT INTO piscinas (name) 
					VALUES('$poolName')";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Registada com sucesso!";		
	}
}

if (isset($_POST['admin_register_btn'])) {
	adminRegister();
}
function adminRegister(){
	
	global $db, $errors, $username;
	
	$username    =  e($_POST['username']);	
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// validaçáo de formulário
	if (empty($username)) { 
		array_push($errors, "Username - campo obrigatório"); 
	}	
	if (empty($password_1)) { 
		array_push($errors, "Password - campo obrigatório"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "As passwords não são iguais!");
	}

	// registo de utilizador
	if (count($errors) == 0) {
		$password = md5($password_1); // encripta a password antes de guardar na base de dados		
		$user_type = e($_POST['user_type']);
		$query = "INSERT INTO users (username, userType, password, checkAdmin) 
					VALUES('$username', '$user_type', '$password', 1)";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Registado com sucesso!";		
	}
}

// retorna user array a partir do id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{		
		return false;
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['userType'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

if (isset($_POST['login_btn'])) {
	login();
}


function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// validação do formulário
	if (empty($username)) {
		array_push($errors, "Username é requerido");
	}
	if (empty($password)) {
		array_push($errors, "Password é requerido");
	}

	// Se sem erros faz log in se user existir
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user encontrado
			// verifica se user é administrador ou user normal
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['userType'] == 'admin') {
				$_SESSION['user'] = $logged_in_user;				
				header('location: admin.php');		  
			}else if ($logged_in_user['userType'] == 'user' && $logged_in_user['checkAdmin'] == '0'){ // verifica se já foi validado por um administrador
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "Espere que um administrador o autorize!";
				header('location: unchecked.php');
			}else if ($logged_in_user['userType'] == 'user' && $logged_in_user['checkAdmin'] == '1'){
				$_SESSION['user'] = $logged_in_user;
				header('location: user.php');
			}
		}else {
			array_push($errors, "Combinação username/password errada!");
		}
	}
}