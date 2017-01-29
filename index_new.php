session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ggnow.tv - Your esports schedule
    </title>
    <style type="text/css">
      @import url("OpenSans/stylesheet.css");
      @import url("webfonts/OpenSans/stylesheet.css");
    </style>
    <link href="/style.css" rel="stylesheet" type="text/css" />

  </head>
  <body link="#000" vlink="#000" alink="#000">
  <div class="wrapperall">
    <?php
/* connect to the db */
$mysqli = new mysqli("localhost", "ggnowuser", "Trcbgd2vkd", "ggnow");
if ($mysqli->connect_errno) {
echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if (empty($_GET)) {		//if there is no variable passed by URL
$CurrentGame = NULL;	//Current game is empty
}
else {					//else if variable is passed
$CurrentGame = $_GET['game'];		//current game is set to variable
}
?>
      <?php 
	  require('header.php');		//include header
	  require('menu.php'); 			//include menu
	  ?>

    <div class="wrapper">
        <div class="today">
          <?php
//Get live games (now-3hrs)
switch ($CurrentGame) {
case "":															//Select name from temams HomeTeamNamne and AwayTeamName
$select = "SELECT *,
(SELECT name FROM teams WHERE idteam = schedule.team_a
) AS HomeTeamName,
(SELECT name FROM teams WHERE idteam = schedule.team_b
) AS AwayTeamName,
(SELECT tournament_id FROM Tournaments WHERE tournament_id = tournament 
) AS tournament_id,
(SELECT name FROM tournaments WHERE tournament_id = schedule.Tournament
) AS tournament_name
FROM `schedule` where start BETWEEN DATE_SUB(NOW() , INTERVAL 3 HOUR) AND NOW() ORDER BY start DESC"; //Query betwene now and 3 hours ago

	$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>
          <div class="rowtitlelive">
  <div class="divhighlightlive">
</div>
<span class="divdate"> <strong>DATE</strong></span>
<span class="divtournament"> <strong>TORUNAMENT</strong></span>
<span class="divteams"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteams"> <strong>TEAM </strong></span>
</div>
    <?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightlive">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdate">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournament">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<span class="vs"> VS </span>
<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span>
<div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a>
</div>
</div>
      <?php
    }
} else {
}
break;
default:
$select = "SELECT *,
(SELECT name FROM teams WHERE idteam = Schedule.team_a
) AS HomeTeamName,
(SELECT name FROM teams WHERE idteam = Schedule.team_b
) AS AwayTeamName,
(SELECT Tournament_id FROM Tournaments WHERE Tournament_id = Tournament 
) AS Tournament_id,
(SELECT name FROM Tournaments WHERE Tournament_id = Schedule.Tournament
) AS Tournament
FROM `schedule` where game='$CurrentGame' and  start BETWEEN DATE_SUB(NOW() , INTERVAL 3 HOUR) AND NOW() ORDER BY start DESC";
$result = mysqli_query($mysqli, $select);
$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>
      <div class="rowtitlelive">
  <div class="divhighlightlive">
</div>
<span class="divdatetitle"> <strong>DATE</strong></span>
<span class="divtournamenttitle"> <strong>TORUNAMENT</strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
</div>
    <?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightlive">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdate">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournament">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<span class="vs"> VS </span>
<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span><div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a></div>
</div>
      <?php
    }
} else {
	
?>
      <?php	
}
break;
}
//Echo todays weekday
$tomorrow2  = mktime(0, 0, 0, date("m")  , date("d")+0, date("Y"));


//Query for games played today (where DATE(start) is current date)
switch ($CurrentGame) {
//Select name from teams where the id = team_a and team_b from schedule
//Make it HomeTeamName and AwayTeamName
//It's pretty much just get name of team with id xy
case "":


$select = "SELECT *,

		(SELECT name FROM teams WHERE idteam = schedule.team_a
		) AS HomeTeamName,
		(SELECT name FROM teams WHERE idteam = schedule.team_b
		) AS AwayTeamName,
		(SELECT name FROM tournaments WHERE tournament_id = schedule.tournament
       ) AS tournament_name


FROM `schedule` where DATE(start) = CURDATE() ORDER BY start ASC";
$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>

<div class="rowtitle">
<div class="divhighlightdota">
</div>
<span class="divdatetitle"> <strong>DATE</strong></span>
<span class="divtournamenttitle"> <strong>TORUNAMENT</strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
</div>
    <?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightdota">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdate">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournament">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<span class="vs"> VS </span>
<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span><div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a></div>
</div>
      <?php
    }
} else {
	
	?>

      <?php
}
default:
$select = "SELECT *,
		(SELECT name FROM teams WHERE idteam = schedule.team_a
		) AS HomeTeamName,
		(SELECT name FROM teams WHERE idteam = schedule.team_b
		) AS AwayTeamName,
		(SELECT name FROM tournaments WHERE tournament_id = schedule.tournament
       ) AS tournament_name
FROM `schedule` where game='$CurrentGame' and DATE(start) = CURDATE() ORDER BY start ASC";
$result = mysqli_query($mysqli, $select);	
$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>

<div class="rowtitle">
<div class="divhighlightdota">
</div>
<span class="divdatetitle"> <strong>DATE</strong></span>
<span class="divtournamenttitle"> <strong>TORUNAMENT</strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
</div>
<?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightdota">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdate">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournament">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<span class="vs"> VS </span>
<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteams">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span><div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a></div>
</div>
      <?php
    }
} else {
}
break;
}
?>
      </div>
      <div class="today">
        <?php
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
?>
        <?php
//Query for games played tomorrow
switch ($CurrentGame) {
//Select name from teams where the id = team_a and team_b from schedule
//Make it HomeTeamName and AwayTeamName
//It's pretty much just get name of team with id xy
case "":
$select = "SELECT *,
		(SELECT name FROM teams WHERE idteam = schedule.team_a
		) AS HomeTeamName,
		(SELECT name FROM teams WHERE idteam = schedule.team_b
		) AS AwayTeamName,
		(SELECT name FROM tournaments WHERE tournament_id = schedule.tournament
       ) AS tournament_name
FROM `schedule` where DATE(start) = CURDATE() + INTERVAL 1 DAY ORDER BY start ASC";
$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>

<div class="rowtitletomorrow">
<div class="divhighlightlol">
</div>
<span class="divdatetitle"> <strong>DATE</strong></span>
<span class="divtournamenttitle"> <strong>TORUNAMENT</strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
</div>

    <?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightlol">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdatetomorrow">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournamenttomorrow">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteamstomorrow">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<div class="vs"> VS </div>

<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteamstomorrow">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span><div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a></div>
</div>
      <?php
    }
} else {
}
break;
//Select name from teams where the id = team_a and team_b from schedule
//Make it HomeTeamName and AwayTeamName
//It's pretty much just get name of team with id xy
default:
$select = "SELECT *,
		(SELECT name FROM teams WHERE idteam = schedule.team_a
		) AS HomeTeamName,
		(SELECT name FROM teams WHERE idteam = schedule.team_b
		) AS AwayTeamName,
		(SELECT name FROM tournaments WHERE tournament_id = schedule.tournament
       ) AS tournament_name
FROM `schedule` where game='$CurrentGame' and DATE(start) = CURDATE() + INTERVAL 1 DAY ORDER BY start ASC";
$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>

<div class="rowtitletomorrow">
<div class="divhighlightlol">
</div>
<span class="divdatetitle"> <strong>DATE</strong></span>
<span class="divtournamenttitle"> <strong>TORUNAMENT</strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
</div>
    <?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightlol">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdatetomorrow">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournamenttomorrow">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteamstomorrow">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<div class="vs"> VS </div>
<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteamstomorrow">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span><div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a></div>
</div>
      <?php
    }
} else {
}
break;
}
?>
      </div>
    </div>
        <?php 
//Get day of the week in +2 days
$tomorrow3  = mktime(0, 0, 0, date("m")  , date("d")+2, date("Y")); 

//Query games played in two days
switch ($CurrentGame) {
//Select name from teams where the id = team_a and team_b from schedule
//Make it HomeTeamName and AwayTeamName
//It's pretty much just get name of team with id xy
case "":
$select = "SELECT *,
		(SELECT name FROM teams WHERE idteam = schedule.team_a
		) AS HomeTeamName,
		(SELECT name FROM teams WHERE idteam = schedule.team_b
		) AS AwayTeamName,
		(SELECT name FROM tournaments WHERE tournament_id = schedule.tournament
       ) AS tournament_name
FROM `schedule` where DATE(start) >= CURDATE() + INTERVAL 2 DAY and DATE(start) <= CURDATE() +INTERVAL 2 DAY ORDER BY start ASC";
$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>

<div class="rowtitlefuture">
<div class="divhighlightcsgo">
</div>
<span class="divdatetitle"> <strong>DATE</strong></span>
<span class="divtournamenttitle"> <strong>TORUNAMENT</strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
</div>
    <?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightcsgo">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdatefuture">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournamenfuture">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteamsfuture">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<span class="vs"> VS </span>
<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteamsfuture">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span>
<div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a></div>
</div>
      <?php
    }
} else {
}
break;
//Select name from teams where the id = team_a and team_b from schedule
//Make it HomeTeamName and AwayTeamName
//It's pretty much just get name of team with id xy
default:
$select = "SELECT *,
		(SELECT name FROM teams WHERE idteam = schedule.team_a
		) AS HomeTeamName,
		(SELECT name FROM teams WHERE idteam = schedule.team_b
		) AS AwayTeamName,
		(SELECT name FROM tournaments WHERE tournament_id = schedule.tournament
       ) AS tournament_name
FROM `schedule` where game='$CurrentGame' and DATE(start) >= CURDATE() + INTERVAL 2 DAY and DATE(start) <= CURDATE() +INTERVAL 2 DAY ORDER BY start ASC";
$result = mysqli_query($mysqli, $select);	
	if ($result->num_rows > 0) {?>

<div class="rowtitlefuture">
<div class="divhighlightcsgo">
</div>
<span class="divdatetitle"> <strong>DATE</strong></span>
<span class="divtournamenttitle"> <strong>TORUNAMENT</strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
<span class="vs"> <strong>VS </strong></span>
<span class="divteamstitle"> <strong>TEAM </strong></span>
</div>

    <?php
	while($row = $result->fetch_array()) {
		?>

<div class="row">
<div class="divhighlightcsgo">
</div>

  <a href="/view_match.php?match_id=<?php echo $row['id']; ?>">
  <span class="divdatefuture">
  <?php
				$timestamp = $row['start'];
				echo date('M d Y', strtotime($timestamp));
				echo " - ";
				echo date('H:i', strtotime($timestamp));
?>
</span></a>
<a href="/view_tournament.php?tournament_id=<?php echo $row['tournament']; ?>">
<span class="divtournamenfuture">
<?php echo $row['tournament_name']; ?>
</span>
</a>
<a href="/view_team.php?=<?php echo $row['team_a']; ?>">
<span class="divteamsfuture">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['HomeTeamName'];
					}
?>
</span></a>
<span class="vs"> VS </span>
<a href="/view_team.php?=<?php echo $row['team_b']; ?>">
<span class="divteamsfuture">
<?php
				if($row['HomeTeamName']===NULL){
					echo $row['name'];
				} else {
					echo $row['AwayTeamName'];
					}
?>
</span>
</a>
</span><div style="width:109px; text-align:center;">
<a href="download-ics.php?mid=<?php echo $row['id']; ?>">
<img src="cal.png" alt="" width="18" height="20" style="margin-top:5px;" /></a><a href="/index.php?game=<?php echo $row['game']; ?>"><img style="margin-top:5px;" src="<?php echo $row['game']; ?>.png" width="20" height="20"/></a><a href="/index.php?game=<?php echo $row['game']; ?>"></a></div>
</div>
      <?php
    }
} else {
}
}
?>
  </div>  <?php require('footer.php'); ?>
    </div>
</div>
  </body>
</html>
