<?php
header('Content-Type: text/html; charset=utf-8');

require_once 'fun/mi.php';
require_once 'fun/config.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>Heroes II Map Scanner</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" />
	<script type="application/javascript" src="js/jquery-2.1.3.min.js"></script>
	<script type="application/javascript" src="js/jquery-ui.js"></script>
  <script type="application/javascript" src="js/mapread.js"></script>
<style>
	* {background: #ddc; font-family: calibri, arial, sans-serif; }
	table {border-collapse:collapse; margin: 1em; border: solid 1px #000;}
	th { background: #dd1;}
	th, td {border: solid 1px #000; min-width: 1em; padding: 1px 5px;}
	.ar { text-align:right; }
	.ac { text-align:center; }

	.smalltable {font-size: 14px;}
	pre { font-family: monospace; }
</style>
</head>
<body>
<a href="mapscan.php">Reload</a> | <a href="mapindex.php">Map List</a> <br />
<?php


require_once 'fun/mapscanf.php';
require_once 'fun/mapsupport.php';
require_once 'fun/mapconstants.php';

$mapok = false;
$buildmap = true;
$mapfiledb = false;
$mapid = intval(exget('mapid', 0));

$mapcode = exget('mapcode');

if($mapid) {
	$sql = "SELECT m.mapfile FROM heroes2_maps AS m WHERE m.idm = $mapid";
	$mapfiledb = mgr($sql);
}


$scan = new ScanSubDir();
$scan->SetFilter(array('mp2', 'mx2'));
$scan->scansubdirs(MAPDIR);
$files = $scan->GetFiles();


if(!empty($files)) {
	echo 'Maps in folder which are not saved and scanned yet<br /><br />';

	$displayed = 0;
	$maplist = '';
	$maplistjs = array();
	$maplist .= '<table><tr>';
	foreach($files as $k => $mfile) {
		$mapname = str_replace(MAPDIR, '', $mfile);
		$par = base64_encode($mapname);
		if($mapcode == $par) {
			//continue;
		}

		$smapname = mes($mapname);
		$sql = "SELECT m.mapfile FROM heroes2_maps AS m WHERE m.mapfile='$smapname'";
		$mapdb = mgr($sql);
		if($mapdb) {
			continue;
		}

		$maplistjs[] = $smapname;

		$maplist .= '<td>'.($k + 1).' <a href="?mapcode='.$par.'">'.$mapname.'</a></td>';
		$displayed++;
		if($k % 12 == 0) {
		  $maplist .= '</tr><tr>';
		}
	}
	$maplist .= '</tr></table>';

	if($displayed == 0) {
		echo 'There are no maps to proccess in map folder. You can go to <a href="mapindex.php">Map List</a><br /><br />';
	}
	else {
		echo '<a href="saveall" id="mapread" onclick="return false;">Read and save all maps</a><br />';
		echo '<p>'.$maplist.'</p>';
		echo '<p id="maplist"></p>';
		echo '<script type="text/javascript">'.EOL.'var maplist = ['.EOL.TAB.'"'.implode($maplistjs, '",'.EOL.TAB.'"').'"'.EOL.']'.EOL.'</script>';
	}

}


if($mapfiledb) {
	$mapfile = MAPDIR.$mapfiledb;
	$mapok = true;
	echo $mapfiledb.'<br />';
}
if($mapcode) {
  $mapok = true;
	$mapfile = MAPDIR.base64_decode($mapcode);
}
//read some maps only
if($mapok) {

	global $tm;
	$tm = new TimeMeasure();
	$map = new H2MAPSCAN($mapfile, true);
	$map->PrintStateSet(1, $buildmap);
  $map->SetSaveMap(1);
	$map->ReadMap();
	
	$tm->Measure('End');
	$tm->showTimes();
}

//read all maps
if(false) {
	$scan = new ScanSubDir();
	$scan->SetFilter(array('mp2'));
	$scan->scansubdirs(MAPDIR);
	$files = $scan->GetFiles();

	echo 'FILES: '.count($files).ENVE;

	$tm = new TimeMeasure();

	foreach($files as $k => $mapfile) {
		$map = new H2MAPSCAN($mapfile, true);
		$map->SetSaveMap(1);
		$map->ReadMap();

		$tm->Measure();
		$tm->ShowTime(true, $k, $mapfile);
	}
}


?>
</body>
</html>