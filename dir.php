<?php

require_once "suporte.class.php";
require_once "performance.class.php";

$time = new Performance();
$time->Start_Time();

$dir = "/Users/harleytome/Arquivos Pessoais/SISTEMAS/OCR/txt/";

$filtro = "txt"; //array( "txt" );
$nomes = get_files_dir($dir,$filtro);

$total = count($nomes);

 
foreach ($nomes as $key => $value) {
    echo $nomes[$key]."\n";
}

echo "\nLidos $total arquivos\n";

$time->End_Time();

echo 'Elapsed time: ', $time->SPEND_TIME, ' secs. Memory usage: ', $time->Memory_Used(), 'Mb';
echo "\n";



foreach(glob($dir."*0.jpg.txt") as $arq) {
    echo "---> ".basename($arq)." \n";
}


?>