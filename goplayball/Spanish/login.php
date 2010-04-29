<script>currentScreen = "Front";</script>
<div id="Front">
 <div class="button" style="top:155px; left:60px;"><div class="right">&nbsp;</div><div class="left">&nbsp;</div><input type="button" class="buttonText" value="CUENTA NUEVA" onclick="switchto('NewAccount');"></input></div>
 <div class="button" style="top:155px; left:190px;"><div class="right">&nbsp;</div><div class="left">&nbsp;</div><input type="button" class="buttonText" value="ACEDER" onclick="switchto('Login');"></input></div>
</div>

<div id="Login">
 <form action="index.php" method="POST">
 <?php leftButton("ATRAS", "switchto('Front');"); rightButton("PROX", "if (validateLogin()) { document.forms[0].submit(); };"); ?>
 <input type="text" name="firstname" id="LoginFirstName" style="position:absolute; top:80px; left:194px; width:100px;" maxlength=20>
 <input type="text" name="lastname" id="LoginLastName" style="position:absolute; top:105px; left:194px; width:100px;" maxlength=20>
 </form>
</div>

<div id="NewAccount">
 <form action="index.php" method="POST">
 <?php leftButton("ATRAS", "switchto('Front');"); rightButton("ENVIAR", "if (validateNewAccount()) { document.forms[1].submit(); };"); ?>
 <input type="text" name="firstname" id="NewFirstName" style="position:absolute; top:80px; left:195px; width:100px;" maxlength=20>
 <input type="text" name="lastname" id="NewLastName" style="position:absolute; top:104px; left:195px; width:100px;" maxlength=20>
 <input type="text" name="team" id="NewTeam" style="position:absolute; top:128px; left:195px; width:100px;" maxlength=20>
 </form>
</div>