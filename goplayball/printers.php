<?php 

function leftButton($text, $action)
{
    echo " <div class=\"leftButton\"><div class=\"right\">&nbsp;</div><div class=\"left\">&nbsp;</div>\n";
    echo "  <input type=\"button\" class=\"buttonText\" value=\"$text\" onclick=\"$action\"></input></div>\n";
}

function rightButton($text, $action)
{
    echo " <div class=\"rightButton\"><div class=\"right\">&nbsp;</div><div class=\"left\">&nbsp;</div>\n";
    echo "  <input type=\"button\" class=\"buttonText\" value=\"$text\" onclick=\"$action\"></input></div>\n";
}

?>