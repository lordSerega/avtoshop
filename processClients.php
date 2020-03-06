<?php 
	session_start();

		$mysqli = new mysqli('fedoseev.h1n.ru', 'fed','V5d7H0q1','avtoshop') or die(mysqli_error($mysqli));

	$update = false;
	$firstname ='';
	$surname ='';
	$lastname ='';
	$tel ='';
	$id = 0;

	if (isset($_POST['save'])){
		$firstname = $_POST['firstname'];
		$surname = $_POST['surname'];
		$lastname = $_POST['lastname'];
		$tel = $_POST['tel'];

	try {
	$mysqli->query("INSERT INTO заказчик (фамилия,имя,отчество,телефон) VALUES ('$surname','$firstname','$lastname','$tel')");

	$_SESSION['message'] = "Запись добавлена в БД";
	$_SESSION['msg_type'] = "success";

	header("location: clients.php");
	} catch (Exception $mysqli_error) {
		$_SESSION['message'] = "Номер телефона уже есть в базе";
		$_SESSION['msg_type'] = "danger";
		header("location: clients.php");
		
		}


	}

	if (isset($_GET['delete'])){
		$id = $_GET['delete'];
		$mysqli->query("DELETE FROM заказчик WHERE кодЗаказчика=$id") or die ($mysqli->error());

		$_SESSION['message'] = "Запись удалена из БД";
		$_SESSION['msg_type'] = "danger";

		header("location: clients.php");
	}

		if (isset($_GET['edit'])){
		$id = $_GET['edit'];
		$update = true;
		$result = $mysqli->query("SELECT * FROM заказчик WHERE кодЗаказчика=$id") or die($mysqli->error());

	
			$row = $result->fetch_array();
			$surname = $row['фамилия'];
			$firstname = $row['имя'];
			$lastname = $row['отчество'];
			$tel = $row['телефон'];
	}

		if (isset($_POST['update'])){
		$id = $_POST['id'];
		$surname = $_POST['surname'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$tel = $_POST['tel'];


		$mysqli->query("UPDATE `заказчик` SET `фамилия`='$surname', `имя` ='$firstname', `отчество` ='$lastname', `телефон` ='$tel' WHERE `кодЗаказчика` = $id ") or die($mysqli->error);

		$_SESSION['message'] = "Запись изменена";
		$_SESSION['msg_type'] = "warning";
		header("location: clients.php");
		}



	?>