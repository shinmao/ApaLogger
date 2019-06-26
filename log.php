<!DOCTYPE html>
<html lang="en">
<head>
<link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" rel="stylesheet"></link>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script crossorigin="anonymous" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<style>
.col-md-4,.col-md-2 {
    background-color: #e3e3e3;
}
.col-md-6 {
    background-color: #f5f3f3;
}
.col-md-2 {
    border-radius: 15px 0 0 15px;
}
.col-md-4 {
    border-radius: 0 15px 15px 0;
}
.box {
	border: solid #0f0f0f;
}
</style>
<title>1pwnch logger</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">ApaLogger</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Log count
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		<a class="dropdown-item" href="/log.php?n=5">5</a>
		<a class="dropdown-item" href="/log.php?n=10">10</a>
		<a class="dropdown-item" href="/log.php?n=15">15</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="/log.php">Default one but not suggested!</a>
		</div>
		</li>
		<li class="nav-item">
		<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Damn No License :)</a>
		</li>
		</ul>
		<form class="form-inline my-2 my-lg-0">
		<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
		<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>
</div>
</nav>
<?php
$f = fopen("/var/log/apache2/access.log", "r");
$r = array();
while(!feof($f)){
	$result = fgets($f);
	$patt_for_ip = "/^([\d]+)\.([\d]+)\.([\d]+)\.([\d]+)/";
	$patt_for_time = "/\[.+\]/";
	$patt_for_url = '/\"(.*?)\"/';
	$agent = '/\"-\" \"(.*?)\"$/';
	preg_match($patt_for_ip, $result, $client_ip);
	preg_match($patt_for_time, $result, $client_time);
	preg_match($patt_for_url, $result, $request_url);
	preg_match($agent, $result, $client_agent);
	array_push( $r, array('<div class="col-md-2 box">', $client_ip[0], '</div>', '<div class="col-md-6 box">', $request_url[0], '</div>', '<div class="col-md-4 box">', $client_agent[1], '</div>') );
}
$counter = count($r) - 1;
if($_GET['n']){
	$end = $_GET['n'];
}
fclose($f);
?>

<div class="alert alert-primary" role="alert">
  Remember to turn on your permission to read the log! 🤟
  The log is limited to success GET one currently.
</div>

<button type="button" class="btn btn-primary">
  GET <span class="badge badge-light"><?php echo $end; ?></span>
  <span class="sr-only">unread messages</span>
</button>

<div class="container">
<div class="row">
<div class="col-md-2">Client IP</div>
<div class="col-md-6">URI</div>
<div class="col-md-4">User agent</div>
</div>
<?php
for($i=0; $i<$end; $i++){
	echo '<div class="row">';
	foreach($r[$counter - 1] as $e){
		echo $e;
	}
	echo '</div>';
	$counter = $counter - 1;
}
?>
</div>

<?php
$f1 = fopen("/var/log/apache2/post_log", "r");
$r1 = array();
while(!feof($f1)){
	$result1 = fgets($f1);
	$patt_for_ip1 = "/ ([\d]+)\.([\d]+)\.([\d]+)\.([\d]+) /";
	$patt_for_url1 = '/\"(.*?)\"/';
	$patt_for_data1 = '/(application)\/(.*?)$/';
	preg_match($patt_for_ip1, $result1, $client_ip1);
	preg_match($patt_for_url1, $result1, $request_url1);
	preg_match($patt_for_data1, $result1, $payload1);
	array_push( $r1, array('<div class="col-md-2 box">', $client_ip1[0], '</div>', '<div class="col-md-6 box">', $payload1[0], '</div>', '<div class="col-md-4 box">', $request_url1[0], '</div>') );
}
$counter1 = count($r1) - 1;
if($_GET['n']){
	$end = $_GET['n'];
}
fclose($f1);
?>

<button type="button" class="btn btn-primary">
  POST <span class="badge badge-light"><?php echo $counter1; ?></span>
  <span class="sr-only">unread messages</span>
</button>

<div class="container">
<div class="row">
<div class="col-md-2">Client IP</div>
<div class="col-md-6">Data</div>
<div class="col-md-4">URI</div>
</div>
<?php
for($i=0; $i<$end; $i++){
	echo '<div class="row">';
	foreach($r1[$counter1 - 1] as $e){
		echo $e;
	}
	echo '</div>';
	$counter1 = $counter1 - 1;
}
?>
</div>

</body>
</html>
