<?php
require_once('app/config.php');
$sql = 'SELECT players.name AS name, player_stats_delta.uid, played, won, lost, survived, roles.name AS most_common_role, most_killed, most_killed_name, most_killed_by, most_killed_by_name FROM player_stats_delta INNER JOIN ( ( SELECT MAX(id) id, MAX(date) FROM player_stats_delta GROUP BY uid ) b, players, roles ) ON( player_stats_delta.id = b.id AND player_stats_delta.uid = players.uid AND player_stats_delta.most_common_role_id = roles.id ) WHERE players.status>0';
$db = DbConfig::getConnection();
$result = $db->query($sql);
$data = array();
while ($row = $result->fetch_assoc()) {
        if(substr($row['most_killed_name'],0,1) == '+'){
		$names = substr($row['most_killed_name'],1);
		$names = explode("-",$names);
		$row['most_killed_name'] = $names[0];
		$row['most_killed_name_before'] = $names[1];
		$row['most_killed'] = 0;
	}
	
	if(substr($row['most_killed_by_name'],0,1) == '+'){
                $names = substr($row['most_killed_by_name'],1);
                $names = explode("-",$names);
                $row['most_killed_by_name'] = $names[0];
                $row['most_killed_by_name_before'] = $names[1];
                $row['most_killed_by'] = 0;
        }
	$row['won_percentaje'] = $row['played']==0?"0":number_format($row['won']/$row['played']*100, 0);
	$row['lost_percentaje'] = $row['played']==0?"0":number_format($row['lost']/$row['played']*100,0);
	$row['survived_percentaje'] = $row['played']==0?"0":number_format($row['survived']/$row['played']*100,0);
	$data[] = $row;
}
$sql = 'SELECT DISTINCT date last_update FROM player_stats_delta ORDER BY date DESC LIMIT 2';
$res = $db->query($sql);
$last_update = [];
while($row = $res->fetch_assoc()) {
	$last_update[] = $row['last_update'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Estadísticas Werewolf Beauchef</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#main_table').DataTable({paging: false, order:[[1,"desc"]]});
});
</script>
</head>
<body>
<div class="container">
<h1>Estadísticas Werewolf Beauchef</h1>
<h2>Resumen de partidas entre el <?php echo $last_update[1]; ?> y el <?php echo $last_update[0]; ?></h2>
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Resumen diario</a></li>
  <li role="presentation"><a href="totales.php">Totales</a></li>
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
<td><?php echo $d['won'];?> <span class="label label-success"><?php echo $d['won_percentaje'] ?>%</span></td>
<td><?php echo $d['lost'];?> <span class="label label-danger"><?php echo $d['lost_percentaje'] ?>%</span></td>
<td><?php echo $d['survived'];?> <span class="label label-primary"><?php echo $d['survived_percentaje'] ?>%</span></td>
<td><?php echo ucfirst($d['most_common_role']);?></td>
<td>
	<?php if(isset($d['most_killed_name_before'])){ ?>
		<h4><span class="label label-success"><?php echo $d['most_killed_name'];?></span></h4>
		<span class="label label-default"><?php echo $d['most_killed_name_before'];?></span> 
	<?php } else { ?> 
	<?php echo $d['most_killed_name']; ?>
	(<?php echo $d['most_killed']>0?"+":"";  echo $d['most_killed'];?>)
	<?php } ?>
</td>
<td>
        <?php if(isset($d['most_killed_by_name_before'])){ ?>
                <h4><span class="label label-success"><?php echo $d['most_killed_by_name'];?></span></h4>
                <span class="label label-default"><?php echo $d['most_killed_by_name_before'];?></span>
        <?php } else { ?>
        <?php echo $d['most_killed_by_name']; ?>
        (<?php echo $d['most_killed_by']>0?"+":"";  echo $d['most_killed_by'];?>)
        <?php } ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div><!-- Container -->
<?php require_once('ga.php'); ?>
</script>
</body>
</html>
