<?php
require_once('app/config.php');
$sql = "SELECT id, name, description FROM achievements";
$db = DbConfig::getConnection();
$result = $db->query($sql);
$data = [];
while($row = $result->fetch_assoc()){
$data[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Werewolf Beauchef</title>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#main_table').DataTable({paging: false, order:[[0,"asc"]]});
});
</script>
</head>
<body>
<div class="container">
<h1>Logros Werewolf</h1>
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Resumen diario</a></li>
  <li role="presentation"><a href="totales.php">Totales</a></li>
</ul>
<table id="main_table" class="table table-hover">
<thead>
<tr>
	<th>Nº</th>
	<th>Nombre</th>
	<th>Descripción</th>
</tr>
</thead>
<tbody>
<?php foreach($data as $d){ ?>
<tr>
<td><?php echo $d['id']; ?></td>
<td><?php echo $d['name']; ?></a></td>
<td><?php echo $d['description']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div><!-- Container -->
<?php require_once('ga.php'); ?>
</body>
</html>
