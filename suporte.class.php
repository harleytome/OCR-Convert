<?php

function dd($v){
    echo "\n========== dump/debug ============\n";
    print_r($v);
    echo "\n";
}

/*
    * http://www.rafaelwendel.com/2011/07/funcao-para-listar-arquivos-de-um-diretorio/
    * Retorna os nomes dos arquivos de um diretório
    * @author Rafael Wendel Pinheiro
    * @param String $dir Caminho do diretório a ser utilizado
    * @return array
*/
function get_files_dir($dir, $tipos = null){
      if(file_exists($dir)){
          $dh =  opendir($dir);
          while (false !== ($filename = readdir($dh))) {
              if($filename != '.' && $filename != '..'){
                  if(is_array($tipos)){
                      $extensao = get_extensao_file($filename);
                      if(in_array($extensao, $tipos)){
                          $files[] = $filename;
                      }
                  }
                  else{
                      $files[] = $filename;
                  }
              }
          }
          if(is_array($files)){
              sort($files);
          }
          return $files;
      }
      else{
          return false;
      }
}
 
/**
    * Retorna a extensão de um arquivo
    * @author Rafael Wendel Pinheiro
    * @param String $nome Nome do arquivo a se capturar a extensão
    * @return resource Caminho onde foi salvo o arquivo, ou false em caso de erro
*/
function get_extensao_file($nome){
    $verifica = explode('.', $nome);
    return $verifica[count($verifica) - 1];
}

?>
