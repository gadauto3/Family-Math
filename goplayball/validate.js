var daysInMonths = new Array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var intRegex = 	/^ *[0-9]+ *$/
var dateDelimiters = " /:-.|\#,;";

function isLeapYear(year) {
    if (!(year % 400))
        return true;

    if (year % 100 && !(year % 4))
        return true;
    else
        return false;
}

function isInt(num) {
	return intRegex.test(num);
}

function parseInteger(num) {
	return parseInt(num, 10);
}

function parseDateOld(d)
{
    var date = new Array();
    var sub;
    d = eatDelimiters(d, dateDelimiters);
    sub = d.substr(0, 2);
    d = d.substr(2, d.length);
    date[0] = sub;
    d = eatDelimiters(d, dateDelimiters);
    sub = d.substr(0, 2);
    d = d.substr(2, d.length);
    date[1] = sub;
    d = eatDelimiters(d, dateDelimiters);
    if (d.charAt(0) == "0") d = d.substr(1,4);
    date[2] = parseInteger(d);
    if (date[2] < 100) {
		if (date[2] < 60) {
			date[2] += 2000;
		} else {
			date[2] += 1900;
		}
	}
    return date;
}

function parseDate(d) {
	var date = new Array();
	var sub;
	d = normalizeDelimiters(d, dateDelimiters);
	//loop to go through and keep parsing data.
	var i = 0;
	while((index = d.indexOf("-")) != -1) {
		date[i] = parseInteger(d.substr(0, index));
		d = d.substr(index+1, d.length);
		i++;
	}
	if (i == 1) {
		date[1] = 1;
		i++;
	}
	date[i] = parseInteger(d);
	date[i] = fixYear(date[i]);
	return date;
}

function fixYear(year) {
	if (year < 100) {
		if (year < 60) {
			year += 2000;
		} else {
			year += 1900;
		}
	}
	return year;
}

//Takes any string and makes all the delimiters become dashes
function normalizeDelimiters(str, delimiters) {
	var newStr = "";
	for(var i = 0; i < str.length; i++) {
		var ch = str.charAt(i);
		if(delimiters.indexOf(ch) != -1) {
			newStr += "-";
		}else{
			newStr += ch;
		}
	}
	return newStr;
}

function eatDelimiters(str, delimiters)
{
    while(str.length && delimiters.indexOf(str.charAt(0)) != -1)
        str = str.substr(1, str.length);
    return str;
}

function nextDelimiter(str, delimiters)
{
    var found = false;
    for (var i = 0; i < str.length && !found; i++)
        if (delimiters.indexOf(str.charAt(i)) != -1)
            found = true;
    if (found)
        return i - 1;
    else
        return -1;
}

function validateDate(dateArray){
	var day = dateArray[1];
	var month = dateArray[0];
	var year = dateArray[2] + "";
	
	if (dateArray.length != 3) 
		return false;
	
	for (var i = 0; i < 3; i++) {
		if (!isInt(dateArray[i])) {
			return false;
		}
	}
	
	if (month > 12 || month < 1) 
		return false;
	
	if (year < 0) 
		return false;
	
	if (isLeapYear(year)) {
		daysInMonths[2] = 29;
	} else {
		daysInMonths[2] = 28;
	}
	
    if (day > daysInMonths[month] || day < 1)
        return false;

    return true;
}

var nameChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";

function validateName(name)
{
    if (name.length < 1 || name.length > 20)
        return false;

    for (var i = 0; i < name.length; i++)
        if (nameChars.indexOf(name.charAt(i)) == -1)
            return false;

    return true;
}

function validateLogin()
{
    if (validateName(document.getElementById("LoginFirstName").value) && validateName(document.getElementById("LoginLastName").value)) {
        return true;
    } else {
        document.getElementById("AlertText").innerHTML = "First and last name must be between 1 and 20 letters long. No symbols." + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }
}

function validateNewAccount()
{
    if (validateName(document.getElementById("NewFirstName").value) && validateName(document.getElementById("NewLastName").value)
        && validateName(document.getElementById("NewTeam").value)) {
        return true;
    } else {
        document.getElementById("AlertText").innerHTML = "First and last name and team name must be between 1 and 20 letters long. No symbols." + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }
}

function validateNewGame()
{
    var error = "";
    var date = parseDate(document.getElementById("NewDate").value);
    var win = document.getElementById("NewWin").value.toLowerCase();
    document.getElementById("NewWin").value = win;

    var runs = document.getElementById("NewRuns").value;
    var rbi = document.getElementById("NewRBI").value;
	win = fixWinEntry(win);
	var opponent = document.getElementById("NewOpponent").value;
    error = createErrorMessage(runs, rbi, date, opponent, win);
	if (error != "") {
        document.getElementById("AlertText").innerHTML = error + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }
	
    document.getElementById("VerifyDate").value = date.join("-");
    document.getElementById("VerifyOpponent").value = document.getElementById("NewOpponent").value;
    document.getElementById("VerifyWin").value = win;
    document.getElementById("SummaryRuns").value = document.getElementById("VerifyRuns").value = document.getElementById("NewRuns").value;
    document.getElementById("SummaryRBI").value = document.getElementById("VerifyRBI").value = document.getElementById("NewRBI").value;

    return true;
}

function createErrorMessage(runs, rbi, date, opponent, win) {
	var error = "";
	if (!isInt(runs) || !isInt(rbi)) {
        error += "<p>Runs and rbi must be positive numbers.</p>";
    }
    if (!validateDate(date)) {
		error += "<p>Date must be valid and separated by spaces.</p>\n";
	}
    if (!validateName(opponent)) {
		error += "<p>Name must be between 1 and 20 letters long.</p>\n";
	}
	if (win != "win" && win != "loss") {
		error += "<p>Please enter Win or Loss.</p>\n";
	}
	return error;
}

function createMLBErrorMessage(ba, obp, runs, rbi, date, opponent, win) {
	var errorSoFar = createErrorMessage(runs, rbi, date, opponent, win);
	if (!isRealDecimalPercentage(obp)) {
		errorSoFar += "<p>OBP must be a real number between 0 and 1</p>";
	}
	if(!isRealDecimalPercentage(ba)) {
		errorSoFar += "<p>BA must be a real number between 0 and 1</p>";
	}
	return errorSoFar;
}

function createCalcErrorMessage(walks, hits, pa) {
	var error = "";
	
	if (!isInt(walks))
        error += "<p>Walks has to be a positive number</p>";
    if (!isInt(hits))
        error += "<p>Hits has to be a positive number</p>";
    if (!(isInt(pa) && pa > 0))
        error += "<p>Plate Appearances must be greater than 0</p>";
    if (parseInteger(hits) + parseInteger(walks) > pa) {
		error += "<p>Plate Appearances has to be more than hits and walks.</p>";
	}
	
	return error;
}

function isRealDecimalPercentage(stat) {
	return isFinite(stat) && parseFloat(stat) <= 1 && parseFloat(stat) >= 0;
}

function validateMLB()
{
    var error = "";
    var date = parseDate(document.getElementById("MLBNewDate").value);
    var win = document.getElementById("MLBNewWin").value.toLowerCase();
    document.getElementById("MLBNewWin").value = win;

    var runs = document.getElementById("MLBNewRuns").value;
    var rbi = document.getElementById("MLBNewRBI").value;
	var opponent = document.getElementById("MLBNewOpponent").value;
	var ba = document.getElementById("MLBNewBA").value;
	var obp = document.getElementById("MLBNewOBP").value;
	win = fixWinEntry(win);
    error = createMLBErrorMessage(ba, obp, runs, rbi, date, opponent, win);
    
	if (error != "") {
        document.getElementById("AlertText").innerHTML = error + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }

	document.getElementById("MLBSummaryDate").value = date.join("-");
	document.getElementById("MLBSummaryWin").value = win;
    document.getElementById("MLBSummaryBA").value = ba;
    document.getElementById("MLBSummaryOBP").value = obp;
    document.getElementById("MLBSummaryRuns").value = runs;
    document.getElementById("MLBSummaryRBI").value = rbi;

    return true;
}

//Simple function to try to make sure that they the text entry is easier
//to go along with this, we by default make the input not be a win.
function fixWinEntry(win) {
	win = win.toLowerCase();
	if(win == "won" || win == "w" || win == "y" || win == "yes") {
		win = "win";
	}
	if(win == "lose" || win == "lost" || win == "l" || win == "no" || win == "n" || win =="") {
		win = "loss";
	}
	return win;
}

function validateBA()
{
    var error = "";

    var walks = document.getElementById("BAWalks").value;
    var hits = document.getElementById("BAHits").value;
    var pa = document.getElementById("BAAppearances").value;
	error = createCalcErrorMessage(walks, hits, pa);
	if (error != "") {
        document.getElementById("AlertText").innerHTML = error + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }
	
	walks = parseInteger(walks);
    hits = parseInteger(hits);
    pa = parseInteger(pa);

    if (pa - walks == 0) {
		var ba = 0;
	} else {
		var ba = Math.round(hits / (pa - walks) * 1000) / 1000;
	}
	var obp = Math.round((hits + walks) / pa * 1000) / 1000;
    ba = formatPercentage(ba);
	obp = formatPercentage(obp);
    //if (hits == 0) { ba = "0.000"; }
	
    document.getElementById("SummaryBA").value = document.getElementById("GameBA").value = ba;
    document.getElementById("SummaryOBP").value = document.getElementById("GameOBP").value = obp;
    document.getElementById("GameBACalc").value = hits + " / (" + pa + " - " + walks + ")";
    document.getElementById("GameOBPCalc").value = "(" + hits + " + " + walks + ") / " + pa;

    return true;
}

function formatPercentage(stat) {
	stat += "";
	if(stat.length == 1) {
		stat += "."; 
	}
	while (stat.length < 5) {
		stat += "0";
	}
	return stat;
}
