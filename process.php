<?php 
	session_start();

		$mysqli = new mysqli('fedoseev.h1n.ru', 'fed','V5d7H0q1','avtoshop') or die(mysqli_error($mysqli));

	$update = false;
	$name ='';
	$price ='';
	$id = 0;

	if (isset($_POST['save'])){
		$name = $_POST['name'];
		$price = $_POST['price'];


	$mysqli->query("INSERT INTO товар (название,цена) VALUES ('$name','$price')") or
		die($mysqli->error);

	$_SESSION['message'] = "Запись добавлена в БД";
	$_SESSION['msg_type'] = "success";

	header("location: index.php");


	}

	if (isset($_GET['delete'])){
		$id = $_GET['delete'];
		$mysqli->query("DELETE FROM товар WHERE кодТовара=$id") or die(mysqli_error($mysqli));
		$_SESSION['message'] = "Запись удалена из БД";
		$_SESSION['msg_type'] = "danger";

		header("location: index.php");
	}

		if (isset($_GET['edit'])){
		$id = $_GET['edit'];
		$update = true;
		$result = $mysqli->query("SELECT * FROM товар WHERE кодТовара=$id") or die($mysqli->error());

	
			$row = $result->fetch_array();
			$name = $row['название'];
			$price = $row['цена'];

	
	}

		if (isset($_POST['update'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$price = $_POST['price'];

		$mysqli->query("UPDATE `товар` SET `название`='$name', `цена` ='$price' WHERE `кодТовара` = $id ") or die($mysqli->error);

		$_SESSION['message'] = "Запись изменена";
		$_SESSION['msg_type'] = "warning";
		header("location: index.php");
		}



	?>