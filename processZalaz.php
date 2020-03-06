<?php 
	session_start();

		$mysqli = new mysqli('fedoseev.h1n.ru', 'fed','V5d7H0q1','avtoshop') or die(mysqli_error($mysqli));

	$update = false;
	$tel ='';
	$id = 0;

	if (isset($_POST['save'])){
	$dateOfor = $_POST['dateOfor'];
	$tel = $_POST['tel'];



	$searchClient = $mysqli->query("SELECT кодЗаказчика FROM заказчик WHERE телефон=$tel") or die($mysqli->error);
	$rowS = $searchClient->fetch_array();
	$id = $rowS['кодЗаказчика'];


	$mysqli->query("INSERT INTO накладная (заказчик,датаОформления) VALUES ('$id','$dateOfor')") or
		die($mysqli->error);

	$_SESSION['message'] = "Запись добавлена в БД";
	$_SESSION['msg_type'] = "success";

	header("location: zakaz.php");


	}

	if (isset($_GET['delete'])){
		$id = $_GET['delete'];
		$mysqli->query("DELETE FROM накладная WHERE кодНакладной=$id") or die ($mysqli->error());

		$_SESSION['message'] = "Накладная удалена из БД";
		$_SESSION['msg_type'] = "danger";

		header("location: zakaz.php");
	}


	if (isset($_GET['includeZakaz'])){
		$id = $_GET['includeZakaz'];
		$update = true;
		
	}

	if (isset($_POST['add'])){
		$id = $_POST['id'];
		$tovar = $_POST['tovar'];
		$tovarCount = $_POST['tovarCount'];

		try {
		$mysqli->query("INSERT INTO продажа (накладная,товар,количество) VALUES ('$id','$tovar',$tovarCount)");
		$_SESSION['message'] = "Товар уже есть в накладной";
		$_SESSION['msg_type'] = "danger";
		header("location: zakaz.php?includeZakaz=$id");
		} catch (Exception $mysqli_error) {
		$_SESSION['message'] = "Товар rrrrr";
		$_SESSION['msg_type'] = "success";
		header("location: zakaz.php?includeZakaz=$id");
		} 


		 
		}

		if (isset($_POST['deleteInOrder'])){
		$tover = $_POST['tovar'];
		$nak = $_POST['nak'];
		$tovarName = $_POST['tovarName'];
	
		$mysqli->query("DELETE FROM `продажа` WHERE продажа.накладная = '$nak' AND продажа.товар = '$tover'")   or die(mysqli_error($mysqli));


		$_SESSION['message'] = "$tovarName удален из накладной # $nak ";
		$_SESSION['msg_type'] = "danger";

		header("location: zakaz.php?includeZakaz=$nak");
	}




?>