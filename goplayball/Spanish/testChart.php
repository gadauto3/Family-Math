<?php   

session_start();

$firstname = strtolower($_POST["firstname"]);
$lastname = strtolower($_POST["lastname"]);
$location = "localhost";
$username = "cas951";
$password = "arctulis";
$database = "cas951_familymath";

$conn = mysql_connect("$location", "$username", "$password");
if (!$conn) die ("Could not connect MySQL");
mysql_select_db($database, $conn) or die ("Could not open database");

include("pChart/pData.class");   
include("pChart/pChart.class");   
include("pChart/pCache.class"); 

$uid = $_SESSION["uid"];
$stat = $_GET["stat"];
if (strcmp($stat, "BAC") == 0 || strcmp($stat, "BA") == 0 || strcmp($stat, "OBP") == 0) { $item = "`pa`, `hits`, `walks`"; }
else {$item = $stat;}
$start = $_GET["start"];
$name = $uid . $_GET["stat"] . $start;
$list = array();
$result = mysql_query("select `date`, $item from `baseball_games` where `uid` = '$uid' order by `date` desc");
if (mysql_num_rows($result))
{
    $i = 1;
    $r1 = mysql_fetch_array($result);
    $month = substr($r1[0], 0, 7);
    while ($r2 = mysql_fetch_array($result))
    {echo $r1[0] . "<br>";
        if ($i == $start)
        {
            if (strcmp($stat, "BA") == 0 || strcmp($stat, "BAC") == 0)
            {
                if (($r1[1] - $r1[3]) != 0)
                {
                    array_unshift($list, $r1[2] / ($r1[1] - $r1[3]));
                }
                else
                {
                    array_unshift($list, 0);
                }
            }
            else if (strcmp($stat, "OBP") == 0)
            {
                if ($r1[1] != 0)
                {
                    array_unshift($list, ($r1[2] + $r1[3]) / $r1[1]);
                }
                else
                {
                    array_unshift($list, 0);
                }
            }
            else
            {
                array_unshift($list, $r1[1]);
            }
        }
        if (strcmp($month, substr($r2[0], 0, 7)))
        {
            $month = substr($r2[0], 0, 7);
            $i++;
        }
        $r1 = $r2;
        if ($i > $start) { break; }
    }
    if ($i == $start)
    {
            if (strcmp($stat, "BA") == 0 || strcmp($stat, "BAC") == 0)
            {
                if (($r1[1] - $r1[3]) != 0)
                {
                    array_unshift($list, $r1[2] / ($r1[1] - $r1[3]));
                }
                else
                {
                    array_unshift($list, 0);
                }
            }
            else if (strcmp($stat, "OBP") == 0)
            {
                if ($r1[1] != 0)
                {
                    array_unshift($list, ($r1[2] + $r1[3]) / $r1[1]);
                }
                else
                {
                     array_unshift($list, 0);
                }
            }
            else
            {
                array_unshift($list, $r1[1]);
            }
    }
}

if (strcmp($stat, "BAC") == 0)
{
    $temp = array();
    for ($i = 0; $i < count($list); $i++)
    {
        $sum = 0;
        for ($j = 0; $j <= $i; $j++)
        {
            $sum += $list[$j];
        }
        array_push($temp, $sum / $j);
    }
    $list = $temp;
}

for ($i = 0; $i < count($list); $i++)
{
    if ($list[$i] > 8)
    {
        $list[$i] = 7;
    }
    elseif ($list[$i] > 0.7 && $list[$i] < 1)
    {
        $list[$i] = 0.7;
    }
}

array_push($list, "");
array_unshift($list, "");

$games = array();
for ($i = 0; $i < count($list) - 2; $i++)
{
    array_push($games, ($i + 1));
}
array_push($games, "");
array_unshift($games, "");

$DataSet = new pData;
if (count($list) == 1)
{
    $DataSet->AddPoint($list[0], "Serie1");
}
else
{
    $DataSet->AddPoint($list, "Serie1");
}

if (strcmp($stat, "BAC") == 0)
{
    $xLabel = "Cumulative BA";
}
elseif (strcmp($stat, "BA") == 0)
{
    $xLabel = "Batting Average";
}
elseif (strcmp($stat, "hits") == 0)
{
    $xLabel = "Hits";
}
elseif (strcmp($stat, "OBP") == 0)
{
    $xLabel = "On Base Percentage";
}
else
{
    $xLabel = "Runs Batted In";
}


foreach ($list as $item)
{
    echo "$item<br>";
}

?>