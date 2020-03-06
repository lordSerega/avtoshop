<?php require 'processClients.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Заказчики</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	  <a class="navbar-brand" href="#">Авто магазин</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
	    <div class="navbar-nav">
	      <a class="nav-item nav-link" href="index.php">Товары<span class="sr-only">(current)</span></a>
	      <a class="nav-item nav-link active" href="clients.php">Заказчики</a>
	      <a class="nav-item nav-link" href="zakaz.php">Накладные</a>

	    </div>
	  </div>
	</nav>

	<?php
	if (isset($_SESSION['message'])): ?>
		<div class="alert alert-<?=$_SESSION['msg_type']?>">
			<?php
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			?>

		</div>
	<?php endif ?>




	<div class="row justify-content-center">
	<form action="processClients.php" method="POST">
		<div class="form-row">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="col-md-4 mb-3">
		<label for="">Фамилия</label>
		<input type="text" name="surname" class="form-control" value="<?php echo $surname; ?>" placeholder ="Введите фамилию">
		</div>
		<div class="col-md-4 mb-3">
		<label for="">Имя</label>
		<input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" placeholder ="Введите имя">
		</div>
		<div class="col-md-4 mb-3">
		<label for="">Отчество</label>
		<input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" placeholder ="Введите отчество">
		</div>
		</div>
		<div class="form-row">
		<div class="col-md-5 mb-5">
		<label for="">Телефон</label>
		<input type="text" name="tel" class="form-control" value="<?php echo $tel; ?>" placeholder ="Введите номер телефона">
		</div>
		
		
		<div class="col-md-4 mb-3 mt-md-4 ">


			<?php 
				if ($update == true):
			?>

		<button type="submit" class="btn btn-info" name="update">Изменить</button>
		<?php 
				else:
			?>
		<button type="submit" class="btn btn-primary" name="save">Добавить запись</button>
		<?php 
				endif;
			?>
		</div>
		</div>
	</form>
	</div>
	
	<div class="container">

	<?php
		$mysqli = new mysqli('fedoseev.h1n.ru', 'fed','V5d7H0q1','avtoshop') or die(mysqli_error($mysqli));
		$result = $mysqli->query("SELECT * FROM заказчик") or die($mysqli->error);
	?>

	<div class="row justify-content-center">
		<table class="table">
			<thead>
				<tr>
					<th>Фамилия</th>
					<th>Имя</th>
					<th>Отчество</th>
					<th>Телефон</th>
			
					<th colspan="2">Действие</th>
				</tr>
			</thead>
				<?php while($row =$result->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['фамилия']; ?></td>
						<td><?php echo $row['имя']; ?></td>
						<td><?php echo $row['отчество']; ?></td>
						<td><?php echo $row['телефон']; ?></td>
						<td>
							<a href="clients.php?edit=<?php echo $row['кодЗаказчика']; ?>" class="btn btn-info">Изменить </a>
							<a href="processClients.php?delete=<?php echo $row['кодЗаказчика']; ?>" class="btn btn-danger">Удалить </a>
						</td>
					</tr>
				<?php endwhile; ?>
		</table>
	</div>


	<?php

		function pre_r($array) {
			echo '<pre>';
			print_r($array);
			echo '</pre>';
		}


	?>

	
	</div>
	
</body>
</html>