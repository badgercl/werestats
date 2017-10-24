<?php
if(!isset($_GET['uid'])) {
	header('Location: /werestats');
	return;
}
require_once('app/config.php');
$uid = intval($_GET['uid']);
if(!$uid) die("uid inválido");

$sql = "SELECT players.name AS name, played, won, lost, survived, roles.name AS most_common_role, most_killed, most_killed_name, most_killed_by, most_killed_by_name, date FROM player_stats_delta JOIN (players, roles) ON ( player_stats_delta.uid = players.uid AND player_stats_delta.most_common_role_id = roles.id ) WHERE player_stats_delta.uid = $uid ORDER BY date DESC LIMIT 30";
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
$data = array_reverse($data);
$sql = 'SELECT DISTINCT DATE(date) last_update FROM player_stats_delta ORDER BY DATE(date) DESC LIMIT 2';
$res = $db->query($sql);
$last_update = [];
while($row = $res->fetch_assoc()) {
	$last_update[] = $row['last_update'];
}
if(!$data) die('No hay datos a mostrar');
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart(){
// Create the data table.
var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Partidas', 'Ganadas', 'Perdidas', 'Sobrevividas'],
<?php
$cd = "";
foreach($data as $d){
	$cd .= sprintf("['%s', %d, %d, %d, %d],", $d['date'], $d['played'], $d['won'], $d['lost'], $d['survived']);
}
if(strlen($cd)>0) $cd = substr($cd,0, strlen($cd)-1);
echo $cd;
?>
        ]);
       
// Set chart options
        var options = {'title':'Resumen para <?php echo $data[0]['name']; ?>',
                       'width':'100%',
                       'height':300,
		 	'bars': 'vertical'};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
     } 



$(document).ready(function(){
	$('#main_table').DataTable({paging: false});
});
</script>
</head>
<body>
<div class="container">
<h1>Estadísticas Werewolf Beauchef</h1>
<h2>Resumen de partidas entre el <?php echo $last_update[1]; ?> y el <?php echo $last_update[0]; ?></h2>
<ul class="nav nav-tabs">
  <li role="presentation"><a href="/werestats">Resumen diario</a></li>
  <li role="presentation"><a href="totales.php">Totales</a></li>
</ul>

<div id="chart_div"></div>

<table id="main_table" class="table table-hover">
<thead>
<tr>
	<th>Fecha</th>
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
<td><?php echo $d['date'];?></td>
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
</body>
</html>
