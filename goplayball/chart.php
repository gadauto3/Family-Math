<?php   

session_start();

$location = "localhost";
$username = "webuser";
$password = "familymath";
$database = "goplayball";

$conn = mysql_connect("$location", "$username", "$password");
if (!$conn) die ("Could not connect MySQL");
mysql_select_db($database, $conn) or die ("Could not open database");

include("pChart/pData.class");   
include("pChart/pChart.class");   
include("pChart/pCache.class"); 

$uid = $_SESSION["uid"];
$stat = $_GET["stat"];
$player = $_GET["playerid"];
if(!is_numeric($uid)) {
	die("invalid user id in chart.php");
}
$stat = mysql_real_escape_string($stat);
$player = mysql_real_escape_string($player);
$stat = strtolower($stat);

if (strcmp($stat, "bac") == 0 || strcmp($stat, "ba") == 0 || strcmp($stat, "obp") == 0) { 
	$item = "`pa`, `hits`, `walks`"; 
} else {
	$item = "`".$stat."`";
}
$start = $_GET["start"];
$name = $uid . $stat . $start;
$list = array();
$result = mysql_query("select `date`, $item from `baseball_games` where `uid` = '$uid' order by `date` desc");


$list = processGames($list, $result, $stat, $start);
$list2 = array();
if($player != 'none' && ($stat == "obp" || $stat == "ba" || $stat == "runs" || $stat == "rbi")) {
	$item2 = "`".$stat."`";
	$result2 = mysql_query("select `date`, $item2 from `mlb` where `uid` = '$uid' and `name` = '$player' order by `date` desc");
	$list2 = processGames($list2, $result2, "runs", $start);
	while(count($list) > count($list2)) {
		array_push($list2, "");
	}
	while(count($list2) > count($list)) {
		array_push($list, "");
	}
}

$games = array();
for ($i = 0; $i < count($list) - 2; $i++) {
    array_push($games, ($i + 1));
}
array_push($games, "");
array_unshift($games, "");

if (strcmp($stat, "bac") == 0) {
    $xLabel = "Cumulative BA";
	$scaleMin = 0;
	$scaleMax = 1.2;
	$scaleStep = .2;
} elseif (strcmp($stat, "ba") == 0) {
    $xLabel = "Batting Average";
	$scaleMin = 0;
	$scaleMax = 1.2;
	$scaleStep = .2;
} elseif (strcmp($stat, "runs") == 0) {
    $xLabel = "Runs";
	$scaleMin = 0;
	$scaleMax = 10;
	$scaleStep = 2;
} elseif (strcmp($stat, "obp") == 0) {
    $xLabel = "On Base Percentage";
	$scaleMin = 0;
	$scaleMax = 1.2;
	$scaleStep = .2;
} else {
    $xLabel = "Runs Batted In";
	$scaleMin = 0;
	$scaleMax = 8;
	$scaleStep = 2;
}

$DataSet = new pData;
if (count($list) == 1) {
    $DataSet->AddPoint($list[0], "Me");
} else {
    $DataSet->AddPoint($list, "Me");
}
if (count($list2) == 1) {
	$DataSet->AddPoint($list2[0], $player);
} else {
    $DataSet->AddPoint($list2, $player);
}
$DataSet->AddAllSeries();  
//$DataSet->SetXAxisName("Day of the month");
//adding games to take a look at the results

//$DataSet->AddPoint($games, "Serie2");
$DataSet->SetYAxisName($xLabel);
$DataSet->SetXAxisName("Game");
//$DataSet->SetAbsciseLabelSerie("Serie2");
//$MyCache = new pCache();
//$MyCache->GetFromCache($name,$DataSet->GetData());

 $Test = new pChart(280,150);
 $Test->drawFilledRectangle(0,0,280,150,250,250,250,TRUE,255);
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->setGraphArea(45,10,270,116);
 $Test->drawGraphArea(255,255,255,FALSE);
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_START0,150,150,150,TRUE,0,3,FALSE,1);   
 $Test->setFixedScale($scaleMin, $scaleMax, $scaleStep);
 $Test->drawGrid(4,FALSE,230,230,230,255); 

 $Test->setColorPalette(0,5,0,0);
 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);   

 $Test->setFontProperties("Fonts/tahoma.ttf",8);  
 $Test->drawLegend(0,120,$DataSet->GetDataDescription(),255,255,255);  
 //$MyCache->WriteToCache($name,$DataSet->GetData(),$Test);
 $Test->Stroke();

 function checkStat($stat) {
 	return strcmp($stat, "obp") == 0 || strcmp($stat, "ba") == 0 || strcmp($stat, "bac") == 0 || strcmp($stat, "runs") == 0 || strcmp($stat, "rbi") == 0; 
 }
 
 function processGames($glist, $result, $stat, $start){
	if (mysql_num_rows($result)) {
	    $i = 1;
	    $r1 = mysql_fetch_array($result);
	    $month = substr($r1[0], 0, 7);
	    /*Bug here: no checking on prev month to make sure there's enough data*/
	    while ($r2 = mysql_fetch_array($result)) {
	        if ($i == $start) {
	            if (strcmp($stat, "ba") == 0 || strcmp($stat, "bac") == 0) {
	                if (($r1[1] - $r1[3]) != 0) {
	                    array_unshift($glist, $r1[2] / ($r1[1] - $r1[3]));
	                } else {
	                    array_unshift($glist, 0);
		            }
    	        } else if (strcmp($stat, "obp") == 0) {
    	            if ($r1[1] != 0) {
    	                array_unshift($glist, ($r1[2] + $r1[3]) / $r1[1]);
    	            } else {
    	                array_unshift($glist, 0);
    	            }
    	        } else {
    	            array_unshift($glist, $r1[1]);
    	        }
    	    }
    	    if (strcmp($month, substr($r2[0], 0, 7))) {
    	        $month = substr($r2[0], 0, 7);
    	        $i++;
    	    }
    	    $r1 = $r2;
    	    if ($i > $start) { break; }
    	}
    	if ($i == $start) {
        	if (strcmp($stat, "ba") == 0 || strcmp($stat, "bac") == 0) {
           		if (($r1[1] - $r1[3]) != 0) {
                	array_unshift($glist, $r1[2] / ($r1[1] - $r1[3]));
            	} else {
    	            array_unshift($glist, 0);
    	        }
    	    } else if (strcmp($stat, "obp") == 0) {
        	    if ($r1[1] != 0) {
        	        array_unshift($glist, ($r1[2] + $r1[3]) / $r1[1]);
        	    } else {
        	          array_unshift($glist, 0);
        	    }
        	} else {
        	    array_unshift($glist, $r1[1]);
        	}
    	}
	}
	if (strcmp($stat, "bac") == 0) {
	    $temp = array();
	    for ($i = 0; $i < count($glist); $i++) {
	        $sum = 0;
	        for ($j = 0; $j <= $i; $j++) {
	            $sum += $glist[$j];
	        }
	        array_push($temp, $sum / $j);
	    }
	    $list = $temp;
	}
	
	for ($i = 0; $i < count($glist); $i++) {
	    if ($glist[$i] > 8) {
	        $glist[$i] = 7;
	    } else if ($glist[$i] > 0.7 && $glist[$i] < 1) {
	        $glist[$i] = 0.7;
	    }
	}
	
	array_push($glist, "");
	array_unshift($glist, "");
	return $glist;
}
?>