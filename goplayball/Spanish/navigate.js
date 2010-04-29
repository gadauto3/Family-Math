var currentScreen = "Front";
var title = "Go Play Ball!";

function switchto(targetScreen)
{
    alert(targetScreen);
	if (targetScreen == "Front") {
		window.navigate("http://localhost/GoPlayBall%20old/index.php");
		return;
	} else {
		document.getElementById(currentScreen).style.display = "none";
		currentScreen = targetScreen;
		document.getElementById(currentScreen).style.display = "block";
	}
}

function createXMLHttpRequest()
{
    var XMLhttpObject = null;
    try 
    {
        XMLhttpObject = new XMLHttpRequest(); //For Firefox etc.
    } 
    catch(e) 
    {
        try 
        {
            XMLhttpObject = new ActiveXObject("Msxml2.XMLHTTP");  //for IE >= 6.0
        } 
        catch(e)
        {
            try 
            {
                XMLhttpObject = new ActiveXObject("Microsoft.XMLHTTP");  //for IE < 6.0
            }
            catch(e) 
            {
                return null;
            }
        }
    }
    XMLhttpObject.onreadystatechange = CHANGE;
    return XMLhttpObject;
}

function CHANGE()
{
    if ((loader.readyState == 4) && (loader.status == 200))
    {
        //loader.loadedFunction();
		getYears();
		calculateStats();
		populateList();
		populateMLBList();
		document.getElementById("Alert").style.display = "none";
		// alert(loader.responseText);
		switchto("SeasonStats");
    }
    else
    {
        //loader.loadingFunction();
		document.getElementById("AlertText").innerHTML = "Guardando Datos...";
		document.getElementById("Alert").style.display = "block";
    }
}

var loader;

function setLoader(loadingFunction, loadedFunction)
{
    loader.loadingFunction = loadingFunction;
    loader.loadedFunction = loadedFunction;
}

function loading()
{
    document.getElementById("Alert").innerHTML = "Loading server data... Please wait.";
    document.getElementById("Alert").style.display = "block";
}

function saveGame()
{	
	var data = new Array(document.getElementById("VerifyOpponent").value, document.getElementById("VerifyDate").value.substr(6) + "-" + document.getElementById("VerifyDate").value.substr(0, 5), parseInt(document.getElementById("BAHits").value), parseInt(document.getElementById("BAAppearances").value), parseInt(document.getElementById("BAWalks").value), parseInt(document.getElementById("SummaryRuns").value), parseInt(document.getElementById("SummaryRBI").value), ((win == "win" || win == "won") ? 1: 0));
	var i;
	for (i = 0; i < gameData.length && data[1] > gameData[i][1]; i++);
	gameData.splice(i, 0, data);
	var win = document.getElementById("VerifyWin").value;
	var sendText =  	"date=" + document.getElementById("VerifyDate").value.substr(6) + "-" + document.getElementById("VerifyDate").value.substr(0, 5)
				+ "&opponent=" + document.getElementById("VerifyOpponent").value
				+ "&hits=" + document.getElementById("BAHits").value 
				+ "&pa=" + document.getElementById("BAAppearances").value 
				+ "&walks=" + document.getElementById("BAWalks").value
				+ "&runs=" + document.getElementById("SummaryRuns").value
				+ "&rbi=" + document.getElementById("SummaryRBI").value
				+ "&team=" + "NONE"
				+ "&gamewon=" + ((win == "win" || win == "won") ? 1: 0);
        loader = createXMLHttpRequest();
	loader.loadedFunction = function() {
		getYears();
		calculateStats();
		populateList();
		document.getElementById("Alert").style.display = "none";
		switchto("SeasonStats");
	}

	loader.loadingFunction = function() {
		document.getElementById("AlertText").innerHTML = "Guardando Datos...";
		document.getElementById("Alert").style.display = "block";
	}
	
	if (loader) {
		loader.open("POST","addGame.php?time="+(new Date().toString()),true);
		loader.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		loader.send(sendText);
	}
}



function saveMLB()
{
	if (!MLB.contains(MLBName)) { MLB.push(MLBName); }
	var win = document.getElementById("MLBNewWin").value;
	var sendText =  	"date=" + document.getElementById("MLBNewDate").value.substr(6) + "-" + document.getElementById("MLBNewDate").value.substr(0, 5)
				+ "&opponent=" + document.getElementById("MLBNewOpponent").value
				+ "&ba=" + document.getElementById("MLBNewBA").value
				+ "&obp=" + document.getElementById("MLBNewOBP").value
				+ "&runs=" + document.getElementById("MLBNewRuns").value
				+ "&rbi=" + document.getElementById("MLBNewRBI").value
				+ "&gamewon=" + ((win == "win" || win == "won") ? 1: 0)
				+ "&name=" + MLBName;
        loader = createXMLHttpRequest();
	loader.loadedFunction = function() {
		getYears();
		calculateStats();
		populateList();
		populateMLBList();
		document.getElementById("Alert").style.display = "none";
		switchto("SeasonStats");
	}

	loader.loadingFunction = function() {
		document.getElementById("AlertText").innerHTML = "Guardando Datos...";
		document.getElementById("Alert").style.display = "block";
	}

	if (loader) {
		loader.open("POST","addMLB.php?time="+(new Date().toString()),true);
		loader.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		loader.send(sendText);
	}
}

var start;
var numMonths;

function setStart()
{
    start = 0;
    numMonths = 0;
    var monthYear = "";
    for (var i = 0; i < gameData.length; i++)
    {
        if (gameData[i][1].substr(0,7) != monthYear)
        {
            monthYear = gameData[i][1].substr(0,7);
            numMonths++;
        }
    }
}

function getMonth(m)
{
    var monthYear = "";
    n = 0;
    for (var i = gameData.length - 1; i >= 0; i--)
    {
        if (gameData[i][1].substr(0,7) != monthYear)
        {
            monthYear = gameData[i][1].substr(0,7);
            n++;
        }
        if (n == m)
        document.title = title + " " + gameData[i][1].substr(5, 2) + " - " + gameData[i][1].substr(0,4);
    }
}

function prevMonth()
{
    start++;
    if (start <= numMonths)
    {
      document.getElementById('Chart').src = 'chart.php?start=' + start + '&stat=' + document.getElementById('GraphSelect').value;
      getMonth(start);
    }
}