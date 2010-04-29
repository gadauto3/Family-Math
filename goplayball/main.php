<div id="SeasonStats" style="display:block;">
 <select id="SeasonSelect" style="position:absolute; top:58px; left:215px;" onchange="calculateStats();"><option>All</option></select>
 <?php leftButton("NEW GAME", "switchto('NewGame');"); rightButton("HISTORY", "switchto('ViewHistory');"); ?>
 <div class="button" style="top:155px; left:126px;"><div class="right">&nbsp;</div><div class="left">&nbsp;</div><input type="button" class="buttonText" value="MLB STATS" onclick="switchto('MLBStart');"></input></div>
 <div class="button" style="top:10px; left:20px;"><div class="right">&nbsp;</div><div class="left">&nbsp;</div><input type="button" class="buttonText" value="LOG OUT" onclick="switchto('Front');"></input></div>
 <input type="text" id="BAStat" style="position:absolute; top:115px; left:50px; border:none; background:none; width:35px;">
 <input type="text" id="OBPStat" style="position:absolute; top:115px; left:110px; border:none; background:none; width:35px;">
 <input type="text" id="RunsStat" style="position:absolute; top:115px; left:182px; border:none; background:none; width:35px;">
 <input type="text" id="RBIStat" style="position:absolute; top:115px; left:250px; border:none; background:none; width:35px;">
</div>

<!-- Left New Game Tier -->

<div id="NewGame">
 <input type="text" id="NewDate" style="position:absolute; top:51px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="NewOpponent" style="position:absolute; top:76px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="NewWin" style="position:absolute; top:101px; left:194px; width:100px;" maxlength=20>

 <input type="text" id="NewRuns" style="position:absolute; top:126px; left:194px; width:34px;" maxlength=20>
 <input type="text" id="NewRBI" style="position:absolute; top:126px; left:258px; width:34px;" maxlength=20>
 <?php leftButton("BACK", "switchto('SeasonStats');"); rightButton("NEXT", "if (validateNewGame()) { switchto('VerifyInfo'); }"); ?>
</div>

<div id="VerifyInfo">
 <input type="text" id="VerifyDate" style="position:absolute; top:51px; left:194px; width:100px;" disabled="disabled">
 <input type="text" id="VerifyOpponent" style="position:absolute; top:76px; left:194px; width:100px;" disabled="disabled">
 <input type="text" id="VerifyWin" style="position:absolute; top:101px; left:194px; width:100px;" disabled="disabled">

 <input type="text" id="VerifyRuns" style="position:absolute; top:126px; left:194px; width:34px;" disabled="disabled">
 <input type="text" id="VerifyRBI" style="position:absolute; top:126px; left:258px; width:34px;" disabled="disabled">
 <?php leftButton("BACK", "switchto('NewGame');"); rightButton("NEXT", "switchto('BattingAverage');"); ?>
</div>

<div id="BattingAverage">
 <input type="text" id="BAHits" style="position:absolute; top:80px; left:200px; width:30px;">
 <input type="text" id="BAAppearances" style="position:absolute; top:112px; left:165px; width:30px;">
 <input type="text" id="BAWalks" style="position:absolute; top:112px; left:265px; width:30px;">
 <?php leftButton("BACK", "switchto('VerifyInfo');"); rightButton("NEXT", "if (validateBA()) { switchto('GameStats');}"); ?>
</div>

<div id="GameStats">
 <input type="text" id="GameBA" style="position:absolute; top:80px; left:240px; width:50px; border:none; background:none;">
 <input type="text" id="GameOBP" style="position:absolute; top:120px; left:240px; width:50px; border:none; background:none;">
 <input type="text" id="GameBACalc" style="position:absolute; top:94px; left:228px; width:60px; border:none; background:none; text-align:center;">
 <input type="text" id="GameOBPCalc" style="position:absolute; top:134px; left:228px; width:60px; border:none; background:none; text-align:center;">
 <?php leftButton("BACK", "switchto('BattingAverage');"); rightButton("NEXT", "switchto('GameSummary');"); ?>
</div>

<div id="GameSummary">
 <input type="text" id="SummaryBA" style="position:absolute; top:70px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="SummaryOBP" style="position:absolute; top:90px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="SummaryRuns" style="position:absolute; top:110px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="SummaryRBI" style="position:absolute; top:130px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <?php leftButton("BACK", "switchto('GameStats');"); rightButton("SAVE GAME", "if (saveGame()) { switchto('SeasonStats'); }"); ?>
</div>

<!-- Middle MLB Tier -->

<div id="MLBStart">
 <select id="MLBSelect" style="position:absolute; top:70px; left:140px;" onchange="if (this.value == 'New Player') { switchto('MLBNew'); } else { MLBName = this.value; switchto('MLBInfo'); }"><option>Choose Player</option></select>
 <?php leftButton("BACK", "switchto('SeasonStats');"); ?>
</div>

<div id="MLBNew">
 <input type="text" name="firstname" id="MLBFirstName" style="position:absolute; top:80px; left:195px; width:100px;" maxlength=20>
 <input type="text" name="lastname" id="MLBLastName" style="position:absolute; top:104px; left:195px; width:100px;" maxlength=20>
 <input type="text" name="team" id="MLBTeam" style="position:absolute; top:128px; left:195px; width:100px;" maxlength=20>
 <?php leftButton("BACK", "switchto('MLBStart');"); rightButton("NEXT", "MLBName = document.getElementById('MLBFirstName').value + ' ' + document.getElementById('MLBLastName').value; switchto('MLBInfo');"); ?>
</div>

<div id="MLBInfo">
 <input type="text" id="MLBNewDate" style="position:absolute; top:76px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="MLBNewOpponent" style="position:absolute; top:101px; left:194px; width:100px;" maxlength=20>
 <input type="text" id="MLBNewWin" style="position:absolute; top:101px; left:78px; width:50px;" maxlength=20>

 <input type="text" id="MLBNewBA" style="position:absolute; top:126px; left:45px; width:34px;" maxlength=20>
 <input type="text" id="MLBNewOBP" style="position:absolute; top:126px; left:125px; width:34px;" maxlength=20>
 <input type="text" id="MLBNewRuns" style="position:absolute; top:126px; left:194px; width:34px;" maxlength=20>
 <input type="text" id="MLBNewRBI" style="position:absolute; top:126px; left:258px; width:34px;" maxlength=20>
 <?php leftButton("BACK", "switchto('MLBStart');"); rightButton("NEXT", "if (validateMLB()) { switchto('MLBGameSummary');}"); ?>
</div>

<div id="MLBGameSummary">
 <input type="text" id="MLBSummaryBA" style="position:absolute; top:70px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="MLBSummaryOBP" style="position:absolute; top:90px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="MLBSummaryRuns" style="position:absolute; top:110px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="MLBSummaryRBI" style="position:absolute; top:130px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="MLBSummaryWin" style="position:absolute; top:110px; left:60px; width:50px; border:none; background:none;" maxlength=20>
 <input type="text" id="MLBSummaryDate" style="position:absolute; top:90px; left:60px; width:80px; border:none; background:none;" maxlength=20>
 <?php leftButton("BACK", "switchto('MLBInfo');"); rightButton("SAVE GAME", "saveMLB();"); ?>
</div>

<!-- Right History Tier -->

<div id="ViewHistory">
 <select id="HistorySelect" style="position:absolute; top:58px; left:215px;" onchange="calculateStats();"><option>All</option></select>
 <?php leftButton("BACK", "switchto('SeasonStats');"); rightButton("PRIOR GAMES", "switchto('PriorGames');"); ?>
 <div class="button" style="top:155px; left:82px;"><div class="right">&nbsp;</div><div class="left">&nbsp;</div>
 <input type="button" class="buttonText" value="GRAPH STATS" onclick="switchto('GraphStats');"></input></div>
 <input type="text" id="BAHistory" style="position:absolute; top:115px; left:50px; border:none; background:none; width:34px;">
 <input type="text" id="OBPHistory" style="position:absolute; top:115px; left:110px; border:none; background:none; width:34px;">
 <input type="text" id="RunsHistory" style="position:absolute; top:115px; left:182px; border:none; background:none; width:34px;">
 <input type="text" id="RBIHistory" style="position:absolute; top:115px; left:250px; border:none; background:none; width:34px;">
</div>

<div id="PriorGames">
 <select id="PriorSelect" onchange="displayPriorGame();" style="position:absolute; top:50px; right:30px;"></select>
 <input type="text" id="PriorBA" style="position:absolute; top:85px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="PriorOBP" style="position:absolute; top:105px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="PriorRuns" style="position:absolute; top:125px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <input type="text" id="PriorRBI" style="position:absolute; top:145px; left:190px; width:34px; border:none; background:none;" maxlength=20>
 <?php leftButton("BACK", "switchto('ViewHistory');"); ?>
</div>

<div id="GraphStats">
 <div id="GraphStatsMsg" style="position:absolute; top:85px; left:20px; border:none; background:none;"></div>
 <select id="GraphMLBSelect" style="position:absolute; top:70px; left:180px;"><option value="none">None</option></select>
 <select id="GraphSelect" style="position:absolute; top:90px; left:180px;" onchange="changeChartParams();"><option value="BA">BA</option><option value="BAC">Cumulative BA</option><option value="OBP">OBP</option><option value="runs">Runs</option><option value="rbi">RBI</option></select>
 <?php leftButton("BACK", "switchto('ViewHistory');"); rightButton("NEXT", "setStart(); prevMonth(); switchto('Blank');"); ?>
</div>  
<div id="Blank">
 <img id="Chart" src="" style="position:absolute; top:13px; left:30px; height:140px;"> 
 <?php leftButton("BACK", "document.title = title; switchto('GraphStats');"); rightButton("PREV MONTH", "prevMonth();"); ?>
</div>                                                         