<div id="SeasonStats" style="display:block;">
 <select id="SeasonSelect" style="position:absolute; top:58px; left:225px;" onchange="calculateStats();"><option>Todos</option></select>
 <?php leftButton("PARTIDO NVO", "switchto('NewGame');"); rightButton("HISTORIAL", "switchto('ViewHistory');"); ?>
 <div class="button" style="top:155px; left:126px;"><div class="right">&nbsp;</div><div class="left">&nbsp;</div><input type="button" class="buttonText" value="STATS MLB" onclick="switchto('MLBStart');"></input></div>
 <input type="text" id="BAStat" style="position:absolute; top:115px; left:50px; border:none; background:none; width:35px;" disabled="disabled">
 <input type="text" id="OBPStat" style="position:absolute; top:115px; left:110px; border:none; background:none; width:35px;" disabled="disabled">
 <input type="text" id="RunsStat" style="position:absolute; top:115px; left:182px; border:none; background:none; width:35px;" disabled="disabled">
 <input type="text" id="RBIStat" style="position:absolute; top:115px; left:250px; border:none; background:none; width:35px;" disabled="disabled">
</div>

<!-- Left New Game Tier -->

<div id="NewGame">
 <input type="text" id="NewDate" style="position:absolute; top:51px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="NewOpponent" style="position:absolute; top:76px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="NewWin" style="position:absolute; top:101px; left:194px; width:100px;" maxlength=20>

 <input type="text" id="NewRuns" style="position:absolute; top:126px; left:194px; width:34px;" maxlength=20>
 <input type="text" id="NewRBI" style="position:absolute; top:126px; left:258px; width:34px;" maxlength=20>
 <?php leftButton("ATRAS", "switchto('SeasonStats');"); rightButton("PROX", "if (validateNewGame()) { switchto('VerifyInfo'); }"); ?>
</div>

<div id="VerifyInfo">
 <input type="text" id="VerifyDate" style="position:absolute; top:51px; left:194px; width:100px;" disabled="disabled">
 <input type="text" id="VerifyOpponent" style="position:absolute; top:76px; left:194px; width:100px;" disabled="disabled">
 <input type="text" id="VerifyWin" style="position:absolute; top:101px; left:194px; width:100px;" disabled="disabled">

 <input type="text" id="VerifyRuns" style="position:absolute; top:126px; left:194px; width:34px;" disabled="disabled">
 <input type="text" id="VerifyRBI" style="position:absolute; top:126px; left:258px; width:34px;" disabled="disabled">
 <?php leftButton("ATRAS", "switchto('NewGame');"); rightButton("PROX", "switchto('BattingAverage');"); ?>
</div>

<div id="BattingAverage">
 <input type="text" id="BAHits" style="position:absolute; top:80px; left:200px; width:30px;">
 <input type="text" id="BAAppearances" style="position:absolute; top:112px; left:165px; width:30px;">
 <input type="text" id="BAWalks" style="position:absolute; top:112px; left:265px; width:30px;">
 <?php leftButton("ATRAS", "switchto('VerifyInfo');"); rightButton("PROX", "if (validateBA()) { switchto('GameStats');}"); ?>
</div>

<div id="GameStats">
 <input type="text" id="GameBA" style="position:absolute; top:80px; left:240px; width:50px; border:none; background:none;" disabled="disabled">
 <input type="text" id="GameOBP" style="position:absolute; top:120px; left:240px; width:50px; border:none; background:none;" disabled="disabled">
 <input type="text" id="GameBACalc" style="position:absolute; top:94px; left:228px; width:60px; border:none; background:none; text-align:center;" disabled="disabled">
 <input type="text" id="GameOBPCalc" style="position:absolute; top:134px; left:228px; width:60px; border:none; background:none; text-align:center;" disabled="disabled">
 <?php leftButton("ATRAS", "switchto('BattingAverage');"); rightButton("PROX", "switchto('GameSummary');"); ?>
</div>

<div id="GameSummary">
 <input type="text" id="SummaryBA" style="position:absolute; top:70px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="SummaryOBP" style="position:absolute; top:90px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="SummaryRuns" style="position:absolute; top:110px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="SummaryRBI" style="position:absolute; top:130px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <?php leftButton("ATRAS", "switchto('GameStats');"); rightButton("GUARDAR", "if (saveGame()) { switchto('SeasonStats'); }"); ?>
</div>

<!-- Middle MLB Tier -->

<div id="MLBStart">
 <select id="MLBSelect" style="position:absolute; top:70px; left:140px;" onchange="if (this.value == 'New Player') { switchto('MLBNew'); } else { MLBName = this.value; switchto('MLBInfo'); }"><option>Elige Jugador</option></select>
 <?php leftButton("ATRAS", "switchto('SeasonStats');"); ?>
</div>

<div id="MLBNew">
 <input type="text" name="firstname" id="MLBFirstName" style="position:absolute; top:80px; left:195px; width:100px;" maxlength=20>
 <input type="text" name="lastname" id="MLBLastName" style="position:absolute; top:104px; left:195px; width:100px;" maxlength=20>
 <input type="text" name="team" id="MLBTeam" style="position:absolute; top:128px; left:195px; width:100px;" maxlength=20>
 <?php leftButton("ATRAS", "switchto('MLBStart');"); rightButton("PROX", "MLBName = document.getElementById('MLBFirstName').value + ' ' + document.getElementById('MLBLastName').value; switchto('MLBInfo');"); ?>
</div>

<div id="MLBInfo">
 <input type="text" id="MLBNewDate" style="position:absolute; top:76px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="MLBNewOpponent" style="position:absolute; top:101px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="MLBNewWin" style="position:absolute; top:101px; left:78px; width:50px;" maxlength=20>

 <input type="text" id="MLBNewBA" style="position:absolute; top:126px; left:45px; width:34px;" maxlength=20>
 <input type="text" id="MLBNewOBP" style="position:absolute; top:126px; left:125px; width:34px;" maxlength=20>
 <input type="text" id="MLBNewRuns" style="position:absolute; top:126px; left:194px; width:34px;" maxlength=20>
 <input type="text" id="MLBNewRBI" style="position:absolute; top:126px; left:258px; width:34px;" maxlength=20>
 <?php leftButton("ATRAS", "switchto('MLBStart');"); rightButton("PROX", "if (validateMLB()) { switchto('MLBGameSummary');}"); ?>
</div>

<div id="MLBGameSummary">
 <input type="text" id="MLBSummaryBA" style="position:absolute; top:70px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="MLBSummaryOBP" style="position:absolute; top:90px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="MLBSummaryRuns" style="position:absolute; top:110px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="MLBSummaryRBI" style="position:absolute; top:130px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <?php leftButton("ATRAS", "switchto('MLBInfo');"); rightButton("GUARDAR", "saveMLB();"); ?>
</div>

<!-- Right History Tier -->

<div id="ViewHistory">
 <select id="HistorySelect" style="position:absolute; top:58px; left:215px;" onchange="calculateStats();"><option>Todos</option></select>
 <?php leftButton("ATRAS", "switchto('SeasonStats');"); rightButton("PART PREVIOS", "switchto('PriorGames');"); ?>
 <div class="button" style="top:155px; left:102px;"><div class="right">&nbsp;</div><div class="left">&nbsp;</div>
 <input type="button" class="buttonText" value="GRAFICAS" onclick="switchto('GraphStats');"></input></div>
 <input type="text" id="BAHistory" style="position:absolute; top:115px; left:50px; border:none; background:none; width:34px;" disabled="disabled">
 <input type="text" id="OBPHistory" style="position:absolute; top:115px; left:110px; border:none; background:none; width:34px;" disabled="disabled">
 <input type="text" id="RunsHistory" style="position:absolute; top:115px; left:182px; border:none; background:none; width:34px;" disabled="disabled">
 <input type="text" id="RBIHistory" style="position:absolute; top:115px; left:250px; border:none; background:none; width:34px;" disabled="disabled">
</div>

<div id="PriorGames">
 <select id="PriorSelect" onchange="displayPriorGame();" style="position:absolute; top:50px; right:30px;"></select>
 <input type="text" id="PriorBA" style="position:absolute; top:85px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="PriorOBP" style="position:absolute; top:105px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="PriorRuns" style="position:absolute; top:125px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <input type="text" id="PriorRBI" style="position:absolute; top:145px; left:190px; width:34px; border:none; background:none;" maxlength=20 disabled="disabled">
 <?php leftButton("ATRAS", "switchto('ViewHistory');"); ?>
</div>

<div id="GraphStats">
 <select id="GraphMLBSelect" style="position:absolute; top:70px; left:180px;"><option>None</option></select>
 <select id="GraphSelect" style="position:absolute; top:90px; left:180px;" onchange="document.getElementById('Chart').src = 'chart.php?start=1&stat=' + this.value;"><option value="BA">BA</option><option value="BAC">Cumulative BA</option><option value="OBP">OBP</option><option value="hits">Hits</option><option value="rbi">RBI</option></select>
 <?php leftButton("ATRAS", "switchto('ViewHistory');"); rightButton("PROX", "setStart(); prevMonth(); switchto('Blank');"); ?>
</div>  
<div id="Blank">
 <img id="Chart" src="" style="position:absolute; top:13px; left:30px; height:140px;">        
 <?php leftButton("ATRAS", "document.title = title; switchto('GraphStats');"); rightButton("MES PREVIO", "prevMonth();"); ?>
</div>                                                         