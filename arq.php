<?php

require_once "performance.class.php";

$path_in  = "/Users/harleytome/Arquivos Pessoais/SISTEMAS/OCR/pdf/";
$path_out = "/Users/harleytome/Arquivos Pessoais/SISTEMAS/OCR/jpg/";

$diretorio = dir($path_in);
$i = 0;

echo "\nFase 1 ---------------- \n";
while($arquivo = $diretorio -> read()){
    if($arquivo != "." && $arquivo !=".." && $arquivo !=".DS_Store" ) {
        //        Saneamento do nome dos diretorios e arquivos
        
        $arq_disp = $arquivo;
        $path_disp = $path_out;

        $wpath_in = str_replace( " ","\ ",$path_in);
        $wpath_out = str_replace( " ","\ ",$path_out);
        
        $arquivo = str_replace( " ","\ ",$arquivo);
        $arquivo = str_replace( "(","\(",$arquivo);
        $arquivo = str_replace( ")","\)",$arquivo);
        
        echo "Convertendo arquivo ".$arq_disp." em imagem ... ";
        if (file_exists($path_disp.$arq_disp."-0.jpg")) {
            echo "já processado\n";
        } else {
            $output = "convert -quality 100 -density 300 ".$wpath_in.$arquivo." ".$wpath_out.$arquivo.".jpg";
            $shell = shell_exec( $output );
            echo "(Ok)\n";
        }
        $i++;
    }
    
}
$diretorio -> close();
print "\n".$i." arquivos processados.\n";

// Fase 2

$path_in  = "/Users/harleytome/Arquivos Pessoais/SISTEMAS/OCR/jpg/";
$path_out = "/Users/harleytome/Arquivos Pessoais/SISTEMAS/OCR/txt/";

$diretorio = dir($path_in);
$i = 0;

echo "\nFase 2 ---------------- \n";
while($arquivo = $diretorio -> read()){
    if($arquivo != "." && $arquivo !=".." && $arquivo !=".DS_Store") {
        /*
        Saneamento do nome dos diretorios e arquivos
        */
        $arq_disp = $arquivo;
        $path_disp = $path_out;

        $arq_disp = $arquivo;
        $wpath_in = str_replace( " ","\ ",$path_in);
        $wpath_out = str_replace( " ","\ ",$path_out);
        
        $arquivo = str_replace( " ","\ ",$arquivo);
        $arquivo = str_replace( "(","\(",$arquivo);
        $arquivo = str_replace( ")","\)",$arquivo);
        
        echo "Convertendo arquivo ".$arq_disp." em texto ...";
        if (file_exists($path_disp.$arq_disp.".txt")) {
            echo "$arq_disp ... já processado\n";
        } else {
            $time = new Performance();
            $time->Start_Time();
            $output = "tesseract -l por ".$wpath_in.$arquivo." ".$wpath_out.$arquivo;
            $shell = shell_exec( $output );
            $time->End_Time();
            
            echo "(Ok) ".$time->SPEND_TIME ." secs. ".$time->Memory_Used(). " Mb\n";;   
        } 
        $i++;
    }
    
}
$diretorio -> close();
print "\n".$i." arquivos processados.\n";

?>