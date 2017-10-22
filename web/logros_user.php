<?php
require_once('app/config.php');
require_once('logros_func.php');

$db = DbConfig::getConnection();
$uid = $db->real_escape_string($_GET['uid']);
if(!is_numeric($uid)) die('ID de usuario incorrecto');


$u = DbConfig::sql($db,"SELECT uid, name, username FROM players WHERE uid = '$uid'");
if(!$u) {
	die('usuario no existe en la base de datos, tienes que inicializarte en el bot');
}
$u = $u[0];
$res = get_user_logros($db, $uid);
$user = $res[1];
$data = $res[0];


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
<style>
.center{
	text-align:center;
}
</style>
</head>
<body>
<div class="container">
<h1>Logros Werewolf de <?php echo $u['name'] ?></h1>
<div class="alert alert-warning" role="alert">Hasta el momento la <a href="http://www.tgwerewolf.com/Stats/Player/<?php echo $u['uid']?>">web ofical de stats</a> no esta considerando los logros nuevos, éstos aparecerán como no obtenidos hasta que lleguen bien los datos</div>
<div class="alert alert-info" role="alert">Tienes <?php echo count($user) ?> de <?php echo count($data)-1;?> logros posibles.</div>
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Resumen diario</a></li>
  <li role="presentation"><a href="totales.php">Totales</a></li>
</ul>
<table id="main_table" class="table table-hover">
<thead>
<tr>
	<th>Nº</th>
	<th>Obtenido</th>
	<th>Nombre</th>
	<th>Descripción</th>
</tr>
</thead>
<tbody>
<?php foreach($data as $d){ ?>
<tr>
<td><?php echo $d['id']; ?></td>
<td class="center"><span class="glyphicon glyphicon-<?php echo(isset($user[$d['id']])?"ok":"remove");?>"/></span></td>
<td><?php echo $d['name']; ?></a></td>
<td><?php echo $d['description']; ?></a></td>
</tr>
<?php } ?>
</tbody>
</table>
</div><!-- Container -->
<?php require_once('ga.php'); ?>
</body>
</html>
