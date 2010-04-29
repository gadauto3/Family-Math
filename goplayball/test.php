<?php   

include("pChart/pChart.class");
include("pChart/pData.class");     

$list = array();
array_unshift($list, 7);
array_unshift($list, 7);
array_unshift($list, 3);
array_unshift($list, 0);

$DataSet = new pData;
$DataSet->AddPoint($list, "Serie1");
$DataSet->AddAllSeries();  

 $Test = new pChart(320,150);
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->setGraphArea(30,5,300,132);
// $Test->drawFilledRoundedRectangle(7,7,313,143,5,240,240,240);   
// $Test->drawRoundedRectangle(5,5,315,145,5,230,230,230);   
 $Test->drawGraphArea(255,255,255,TRUE);
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,0,FALSE);   
 $Test->drawGrid(4,TRUE,230,230,230,50); 
  
 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);   
 $Test->setFontProperties("Fonts/tahoma.ttf",10); 

 $Test->Stroke();

?>