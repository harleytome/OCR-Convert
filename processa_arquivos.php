<?php

require_once "infoarquivo.class.php";
require_once "performance.class.php";
require_once "csv.class.php";

/*
Medição de tempo de execução
*/
$time = new Performance();
$time->Start_Time();
$x = new InfoArquivo();

$PATH_IN = "/Users/harleytome/Arquivos Pessoais/SISTEMAS/OCR/txt/";
//$ARQ_IN = "2018-05-09 (1).pdf-0.jpg.txt";
//$ARQ_IN = "2018-05-09 (10).pdf-0.jpg.txt";
//$ARQ_IN   = "2018-05-09 (12).pdf-0.jpg.txt";
//$ARQ_IN = "2018-05-11 (43).pdf-0.jpg.txt";
$ARQ_IN = "*0.jpg.txt";
//$ARQ_IN = "2018-05-11 (41).pdf-0.jpg.txt";

$i = 0;
$inc = 0;
$con = 0;

foreach(glob($PATH_IN.$ARQ_IN) as $arq) {
    $ARQ_IN = basename($arq);
    echo $ARQ_IN." ... ";
    $myarray =  $x->Info_Array($PATH_IN,$ARQ_IN);
    if($i == 0) { //primeira linha então adiciona no arquivo CSV as colunas
        $csv = new CSV(array_keys($myarray));
    } 
    if(count(array_values($myarray)) == 0) {
        print_r(" inconsistente....");
        //$p = strpos($ARQ_IN,".");
        //$arqorig = substr($ARQ_IN,0,$p+3);
        $csv->addRow(array($ARQ_IN,"inconsistente"));
        $inc++;
    } else {
        $csv->addRow(array_values($myarray));       
        $con++;
    }
    print "\n";
    
    $i++;  
}

/*
foreach ($nomes as $key => $value) {
    if (substr($nomes[$key],0,1) != ".") { //Pula arquivos .DStore e outros ocultos
        echo $nomes[$key]." ... \n";
        $ARQ_IN = $nomes[$key];
        $myarray =  $x->Info_Array($PATH_IN,$ARQ_IN);
        if($i == 0) { //primeira linha então adiciona no arquivo CSV as colunas
            $csv = new CSV(array_keys($myarray));
        } else {
            $csv->addRow(array_values($myarray));
        }
        $i++;  
    }
}
*/

$csv->export("teste.csv");
//print_r(array_keys($myarray));
//print_r(array_values($myarray));

$time->End_Time();

echo "\n=========== Resumo ==============\n";
echo "Elapsed time: ". $time->SPEND_TIME ." secs.\n";
echo "Memory usage: ". $time->Memory_Used(). " Mb\n";
echo "Arquivos processados: $i\n";
echo "Arquivos inconsistentes: $inc\n";
echo "Arquivos consistentes: $con\n";
echo "\n\n";

?>
