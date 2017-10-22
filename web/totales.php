<?php
require_once('app/config.php');
$sql = "SELECT players.name AS name, player_stats.uid as uid, played, won, lost, survived, roles.name AS most_common_role, most_killed, most_killed_name, most_killed_by, most_killed_by_name FROM player_stats INNER JOIN ( ( SELECT MAX(id) id, MAX(updated) FROM player_stats GROUP BY uid ) b, players, roles ) ON( player_stats.id = b.id AND player_stats.uid = players.uid AND player_stats.most_common_role_id = roles.id ) WHERE players.status > 0 ORDER BY played DESC";
$db = DbConfig::getConnection();
$result = $db->query($sql);
$data = array();
while ($row = $result->fetch_assoc()) {
        $data[] = $row;
}

$sql = "SELECT MAX(updated) as last_update FROM player_stats LIMIT 1";
$res = $db->query($sql);
$last_update = "nunca";
if($row = $res->fetch_assoc()) {
	$last_update = $row['last_update'];
}
?>
<!DOCTYPE html>
<html>
<head prefix="og: http://ogp.me/ns#">
<title>Estadísticas Werewolf Beauchef</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#main_table').DataTable({
	paging: false,
	order: [[1,"desc"]]	
	});
});
</script>
<meta property="og:site_name" content="Werestats" />
<meta property="og:title" content="Estadísticas totales" />
<meta property="og:url" content="https://badger.cl/werestats/totales.php" />
<meta property="og:image" content="https://badger.cl/werestats/img/lobo.jpg" />
</head>
<body>
<div class="container">
<h1>Estadísticas Werewolf Beauchef</h1>
<h2>Última actualización: <?php echo $last_update; ?></h2>
<ul class="nav nav-tabs">
  <li role="presentation"><a href="/werestats">Resumen diario</a></li>
  <li role="presentation" class="active"><a href="#">Totales</a></li>
</ul>
<table id="main_table" class="table table-hover">
<thead>
<tr>
	<th>Nombre</th>
	<th>Partidas</th>
	<th>Ganadas</th>
	<th>Perdidas</th>
	<th>Sobrevividas</th>
	<th>Rol más común</th>
	<th>Más veces ha matado a</th>
	<th>Más veces matado por</th>
</tr>
</thead>
<tbody>
<?php foreach($data as $d){ ?>
<tr>
<td><a href="user.php?uid=<?php echo $d['uid']; ?>"><?php echo $d['name'];?></a></td>
<td><?php echo $d['played'];?></td>
<td><?php echo $d['won'];?></td>
<td><?php echo $d['lost'];?></td>
<td><?php echo $d['survived'];?></td>
<td><?php echo ucfirst($d['most_common_role']);?></td>
<td><?php echo $d['most_killed_name'];?> (<?php echo $d['most_killed'];?>)</td>
<td><?php echo $d['most_killed_by_name'];?> (<?php echo $d['most_killed_by'];?>)</td>
</tr>
<?php } ?>
</tbody>
</table>
</div><!-- Container -->
<?php require_once('ga.php'); ?>
</body>
</html>
