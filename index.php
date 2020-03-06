<?php require 'process.php'; ?>
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
	      <a class="nav-item nav-link active" href="index.php">Товары<span class="sr-only">(current)</span></a>
	      <a class="nav-item nav-link " href="clients.php">Заказчики</a>
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
	<form action="process.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="form-group">
		<label for="">Наименование</label>
		<input type="text" name="name" class="form-control" value="<?php echo $name; ?>" placeholder ="Введите наименование товара">
		</div>
		<div class="form-group">
		<label for="">Стоимость</label>
		<input type="text" name="price" class="form-control" value="<?php echo $price; ?>" placeholder ="Введите цену">
		</div>
		<div class="form-group">
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
	</form>
	</div>
	<div class="container">

	<?php
		$mysqli = new mysqli('fedoseev.h1n.ru', 'fed','V5d7H0q1','avtoshop') or die(mysqli_error($mysqli));
		$result = $mysqli->query("SELECT * FROM товар") or die($mysqli->error);
	?>

	<div class="row justify-content-center">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Наименование</th>
					<th>Стоимость</th>
					<th colspan="2">Действие</th>
				</tr>
			</thead>
				<?php while($row =$result->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['кодТовара']; ?></td>
						<td><?php echo $row['название']; ?></td>
						<td><?php echo $row['цена']; ?> руб.</td>
						<td>
							<a href="index.php?edit=<?php echo $row['кодТовара']; ?>" class="btn btn-info">Изменить </a>
							<a href="process.php?delete=<?php echo $row['кодТовара']; ?>" class="btn btn-danger">Удалить </a>
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