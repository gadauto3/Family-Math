var daysInMonths = new Array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

function isLeapYear(year)
{
    if (!(year % 400))
        return true;

    if (year % 100 && !(year % 4))
        return true;
    else
        return false;
}

var dateDelimiters = "	 /:-.|\#,;";

function parseDate(d)
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
    date[2] = parseInt(d);
    if (date[2] < 100)
        if (date[2] < 50)
            date[2] += 2000;
        else
            date[2] += 1900;
    return date;
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

function validateDate(dateArray)
{
    var day = dateArray[1];
    var month = dateArray[0];
    var year = dateArray[2] + "";

    if (dateArray.length != 3)
        return false;

    for (var i = 0; i < 3; i++)
        if (isNaN(dateArray[i]))
            return false;

    if (day.charAt(0) == "0") day = day.charAt(1);
    if (month.charAt(0) == "0") month = month.charAt(1);
    if (year.charAt(0) == "0") year = year.substr(1,4);
    month = parseInt(month);
    day = parseInt(day);
    year = parseInt(year);

    if (month > 12 || month < 1)
        return false;

    if (year < 0)
        return false;

    if (isLeapYear(year))
        daysInMonths[2] = 29;
    else
        daysInMonths[2] = 28;

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
        document.getElementById("AlertText").innerHTML = "Nombre y apellido debe ser entre entre 1 y 20 letras. No se admiten simbolos." + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
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
        document.getElementById("AlertText").innerHTML = "Nombre, apellido, y nombre de equipo debe ser entre entre 1 y 20 letras. No se admiten simbolos." + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
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
    if (parseInt(runs) < 0 || parseInt(rbi) < 0)
    {
        error += "<p>Runs y rbi tiene que ser numeros positivos!</p>";
    }
    if (!validateDate(date))
        error += "<p>Fecha tiene que ser valida y debe estar en el formato MMDDAAAA.</p>\n";
    else
        document.getElementById("NewDate").value = date.join("-");
    if (!validateName(document.getElementById("NewOpponent").value))
	error += "<p>Nombre tiene que ser entre 1 y 20 letras.</p>\n";
	if(win == "si")
		win = "win";
	if(win == "no")
		win = "loss";
    if (win != "win" && win != "won" && win != "lose" && win != "lost" && win != "loss" && win != "si" && win != "no")
        error += "<p>Favor contestar la pregunta de ganar con si o no</p>\n";
    if (isNaN(document.getElementById("NewRuns").value) || document.getElementById("NewRuns").value == "")
        error += "<p>Favor de entrar el numero de runs.</p>\n";
    if (isNaN(document.getElementById("NewRBI").value) || document.getElementById("NewRBI").value == "")
        error += "<p>Favor de entrar el RBI.</p>\n";
    if (error != "")
    {
        document.getElementById("AlertText").innerHTML = error + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }

    document.getElementById("VerifyDate").value = document.getElementById("NewDate").value;
    document.getElementById("VerifyOpponent").value = document.getElementById("NewOpponent").value;
    document.getElementById("VerifyWin").value = document.getElementById("NewWin").value;
    document.getElementById("SummaryRuns").value = document.getElementById("VerifyRuns").value = document.getElementById("NewRuns").value;
    document.getElementById("SummaryRBI").value = document.getElementById("VerifyRBI").value = document.getElementById("NewRBI").value;

    return true;
}

function validateMLB()
{
    var error = "";
    var date = parseDate(document.getElementById("MLBNewDate").value);
    var win = document.getElementById("MLBNewWin").value.toLowerCase();
    document.getElementById("MLBNewWin").value = win;

    var runs = document.getElementById("MLBNewRuns").value;
    var rbi = document.getElementById("MLBNewRBI").value;
    if (parseInt(runs) < 0 || parseInt(rbi) < 0)
    {
        error += "<p>Runs y rbi tiene que ser numeros positivos!</p>";
    }
    if (!validateDate(date))
        error += "<p>Fecha tiene que ser valida y debe estar en el formato MMDDAAAA.</p>\n";
    else
        document.getElementById("MLBNewDate").value = date.join("-");
    if (!validateName(document.getElementById("MLBNewOpponent").value))
	error += "<p>Nombre tiene que ser entre 1 y 20 letras.</p>\n";
	if(win == "si")
		win = "win";
	if(win == "no");
		win = "loss";
    if (win != "win" && win != "won" && win != "lose" && win != "lost" && win != "loss")
        error += "<p>Favor de entrar \"si\" o \"no\" si ganaron</p>\n";
    if (isNaN(document.getElementById("MLBNewRuns").value) || document.getElementById("MLBNewRuns").value == "")
        error += "<p>Favor de entrar el numero de runs.</p>\n";
    if (isNaN(document.getElementById("MLBNewRBI").value) || document.getElementById("MLBNewRBI").value == "")
        error += "<p>Favor de entrar el RBI.</p>\n";
    if (error != "")
    {
        document.getElementById("AlertText").innerHTML = error + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }

    document.getElementById("MLBSummaryBA").value = document.getElementById("MLBNewBA").value;
    document.getElementById("MLBSummaryOBP").value = document.getElementById("MLBNewOBP").value;
    document.getElementById("MLBSummaryRuns").value = document.getElementById("MLBNewRuns").value;
    document.getElementById("MLBSummaryRBI").value = document.getElementById("MLBNewRBI").value;

    return true;
}

function validateBA()
{
    var error = "";

    var walks = document.getElementById("BAWalks").value;
    var hits = document.getElementById("BAHits").value;
    var pa = document.getElementById("BAAppearances").value;

    if (isNaN(walks) || walks == "")
        error += "<p>Base Por Bolas tiene que ser un numero</p>";
    if (isNaN(hits) || hits == "")
        error += "<p>Batazos tiene que ser un numero</p>";
    if (isNaN(pa) || pa == "")
        error += "<p>Apariciones al plato tiene que ser un numero</p>";

    walks = parseInt(walks);
    hits = parseInt(hits);
    pa = parseInt(pa);

    if (walks < 0 || hits < 0 || pa < 0)
        error += "<p>Ningunos de los numeros pueden ser negativos</p>";
    if (hits + walks > pa)
        error += "<p>Apariciones al plato tiene que ser mas que batazos y base por bolas</p>";

    if (error != "")
    {
        document.getElementById("AlertText").innerHTML = error + "<br><input type=\"button\" value=\"Ok\" onclick=\"document.getElementById('Alert').style.display = 'none';\"></input>";
        document.getElementById("Alert").style.display = "block";
        return false;
    }

    var ba = Math.round(hits / (pa - walks) * 1000) / 1000;
    var obp = Math.round((hits + walks) / pa * 1000) / 1000;
    ba += "";
    obp += "";
    if (ba.length == 1) { ba += "."; }
    if (obp.length == 1) { obp += "."; }
    while (ba.length < 5) { ba += "0"; }
    while (obp.length < 5) { obp += "0"; } 
    if (hits == 0) { ba = "0.000"; }
    document.getElementById("SummaryBA").value = document.getElementById("GameBA").value = ba;
    document.getElementById("SummaryOBP").value = document.getElementById("GameOBP").value = obp;
    document.getElementById("GameBACalc").value = hits + " / (" + pa + " - " + walks + ")";
    document.getElementById("GameOBPCalc").value = "(" + hits + " + " + walks + ") / " + pa;

    return true;
}