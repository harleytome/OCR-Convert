<?php

$BLEND = false;     //empresa BLEND
$POS_BLEND = 0;     //Posição
$DATA = array();
$INFO = array();
$SIZE_DATA = 0;
$POS_WORD = 0;
$KEY_WORD = 0;
$ARQUIVO_PDF = "";
$ARQUIVO_PROX = "";
$PATH_ORIGEM = "";

class Arquivo {
    
    public function __construct($myarray) {
        $this->DATA = $myarray;
        $this->SIZE_DATA = count($this->DATA)-1;
    }
    
    public function Set_Blend_Doc(){
        $this->BLEND = true;
    }
    
    public function Pesquisa_Palavra($word) {
        $l = 0;
        while($l <= $this->SIZE_DATA){
            $pos = strpos(trim($this->DATA[$l]),$word);
            if($pos === false){               
                $this->POS_WORD = 0;
                $this->KEY_WORD = 0;
            } else {
                $this->POS_WORD = $pos;
                $this->KEY_WORD = $l;
                break;
            }
            $l++;
        }
    }
    
    public function Add_Array( $key, $val ){
        $this->INFO[$key] = $val;
        $this->INFO[$key];
    }
    
    public function Normaliza($val) {
        $pos = strpos($val,":");       
        if($pos == false){
            return $val;
        }
        return trim(substr($val,$pos+1));
    }
    
    public function Get_INFO() {
        return  ($this->INFO);
    }
    
    public function Monta_Array( $p1, $p2, $myarray, $passo = null ) {
        $tmp = array();
        // apenas para debug do codigo
        if (isset($passo)) {
            echo "\nPASSO = $passo\n";
        }

        $i = $p1;
        for ($i; $i <= $p2 ; $i++) { 
            if(strlen(trim($myarray[$i]))>1) {
                $tmp[] = trim($myarray[$i]);
            }
        }
        return $tmp;
    }
    
    public function Arquivo_Origem( $arq ) {
        //Exemplo : $ARQ_IN = "2018-05-09 (1).pdf-0.jpg.txt";
        $pos = strpos($arq,".");
        return ($this->ARQUIVO_PDF = substr($arq,0,$pos+4));
    }
    
    public function Path_Origem( $path ) {
        return ( $this->PATH_ORIGEM = $path );
    }
    
    public function Arquivo_Origem_Pagina( $pag ){
        $ARQ = $this->ARQUIVO_PDF."-"."$pag".".jpg.txt";
        if(file_exists($this->PATH_ORIGEM.$ARQ)) {
            $this->ARQUIVO_PROX = $ARQ;
            return true;
        } else {
            return false;
        }
    }
    
    public function Array_To_String( $myarray ) {
        $s = "";
        foreach ($myarray as $key => $value) {
            $s .= $myarray[$key]."\n";
        }
        return $s;
    }
    
    public function Ajusta_CNPJ_Contratado( $key ) { 
        if (isset($this->INFO[$key])) {
            $this->INFO["C_Insc.Munic"] = $this->Normaliza(substr($this->INFO[$key],strpos($this->INFO[$key],"Insc.")));
            $this->INFO[$key] = substr($this->INFO[$key],0,strpos($this->INFO[$key],"Insc."));
            if(strlen(trim($this->INFO["C_CNPJ"]))==0) {
                $this->INFO["C_CNPJ"] = $this->INFO["C_Insc.Munic"];
                $this->INFO["C_Insc.Munic"] = "";            
            }
        }
    }
}

?>