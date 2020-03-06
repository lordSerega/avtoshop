<?php require 'processZalaz.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Накладные</title>
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
	      <a class="nav-item nav-link" href="clients.php">Заказчики</a>
	      <a class="nav-item nav-link active" href="zakaz.php">Накладные</a>
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
	<form action="processZalaz.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
			<?php 
				if ($update == true):
			?>
			<h3>Добавление товаров в заказ #<?php echo $id; ?></h3>

		<div class="form-group">
		<label for="">Товар</label>
		<input type="text" name="tovar" class="form-control" value="<?php echo $name; ?>" placeholder ="Введите код товара">
		</div>
		<div class="form-group">
		<label for="">Количество</label>
		<input type="number" name="tovarCount" class="form-control" value="<?php echo $name; ?>" placeholder ="Введите количество">
		</div>
		<div class="form-group">
			
		<button type="submit" class="btn btn-success" name="add">Добавить товар</button>

	
		</div>

			<?php 
				else:
			?>
		<div class="form-group">
		<label for="">Номер телефона заказчика</label>
		<input type="text" name="tel" class="form-control" value="<?php echo $name; ?>" placeholder ="Введите телефон">
		</div>
		<div class="form-group">
		<label for="inputDate">Дата оформления</label>
    	<input type="date" name ="dateOfor"class="form-control" value="<?php echo $dateOfor; ?>" >
		</div>
		<div class="form-group">
			
		<button type="submit" class="btn btn-primary" name="save">Добавить запись</button>
	
		</div>
		<?php 
				endif;
			?>
	</form>
</div>
	<?php 
				if ($update == true):
			?>

			<div class="container">

				<h3>Состав заказа:</h3>

	<?php
		$mysqli = new mysqli('fedoseev.h1n.ru', 'fed','V5d7H0q1','avtoshop') or die(mysqli_error($mysqli));
		$result = $mysqli->query("SELECT
  продажа.накладная,
  товар.кодТовара,
  товар.название,
  товар.цена,
  продажа.количество
FROM продажа
  INNER JOIN товар
    ON продажа.товар = товар.кодТовара
  INNER JOIN накладная
    ON продажа.накладная = накладная.кодНакладной
WHERE продажа.накладная = $id") or die($mysqli->error);
	?>

	<div class="row justify-content-center">
		<table class="table">
			<thead>
				<tr>
					<th>Товар</th>
					<th>Количество</th>
					<th>Цена</th>
					<th>Сумма</th>
					<th colspan="2">Действие</th>
				</tr>
			</thead>
				<?php while($row =$result->fetch_assoc()): ?>
					<tr>

						<td><?php echo $row['название']; ?></td>
						<td><?php echo $row['количество']; ?></td>
						<td><?php echo $row['цена']; ?></td>
						<td class="font-weight-bold"><?php echo $row['цена']*$row['количество']; ?></td>
						<td>	
						<form action="processZalaz.php" method="POST">	
						<input type="hidden" name="tovar" class="form-control" value="<?php echo $row['кодТовара']; ?>">
						<input type="hidden" name="tovarName" class="form-control" value="<?php echo $row['название']; ?>">
						<input type="hidden" name="nak" class="form-control" value="<?php echo $row['накладная']; ?>">
						<button type="submit" class="btn btn-danger" name="deleteInOrder">Удалить</button>
						</form>					
						</td>
					</tr>
				<?php endwhile; ?>
		</table>
	</div>



			<?php 
				else:
			?>

	
	<div class="container">

	<?php
		$mysqli = new mysqli('localhost', 'root','','avtoshop') or die(mysqli_error($mysqli));
		$result = $mysqli->query("SELECT накладная.кодНакладной, заказчик.фамилия, заказчик.телефон, накладная.датаОформления FROM накладная INNER JOIN заказчик ON накладная.заказчик = заказчик.кодЗаказчика") or die($mysqli->error);
	?>

	<div class="row justify-content-center">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Заказчик</th>
					<th>Телефон</th>
					<th>Дата оформления</th>
		
			
					<th colspan="1">Действие</th>
				</tr>
			</thead>
				<?php while($row =$result->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['кодНакладной']; ?></td>
						<td><?php echo $row['фамилия']; ?></td>
						<td><?php echo $row['телефон']; ?></td>
						<td><?php echo $row['датаОформления']; ?></td>
						<td>
							<a href="zakaz.php?includeZakaz=<?php echo $row['кодНакладной']; ?>" class="btn btn-success">Детали заказа</a>
							<a href="processZalaz.php?delete=<?php echo $row['кодНакладной']; ?>" class="btn btn-danger">Удалить </a>
						</td>
					</tr>
				<?php endwhile; ?>
		</table>
	</div>
	<?php 
				endif;
			?>


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