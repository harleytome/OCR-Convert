<?php

require_once "arquivo.class.php";
require_once "suporte.class.php";

class InfoArquivo {
    
    public function Info_Array($caminho,$arquivo) {
        
        $PATH_IN = $caminho;
        $ARQ_IN = $arquivo;
        
        $lines = file($PATH_IN.$ARQ_IN,FILE_SKIP_EMPTY_LINES);
        $arq = new Arquivo($lines);
        
        //Seter para nome do arquivo e path de origem
        $arq->Path_Origem( $PATH_IN );
        $arq->Arquivo_Origem( $ARQ_IN );
        
        $arq->Pesquisa_Palavra("BLEND IT CONSULTORIA");
        if ($arq->POS_WORD > 0) {
            $arq->Set_Blend_Doc();
        }
        
        /*
        Monta os dados da Razão Social do contratante
        */
        
        $arq->Pesquisa_Palavra("A) CONTRATANTE");
        $p1 = $arq->KEY_WORD+1;
        $arq->Pesquisa_Palavra("B) CONTRATADA");
        $p2 = $arq->KEY_WORD-1;
        
        if($p1 >= 0 && $p2 > 0) {
            
            
            $x = $arq->Monta_Array($p1,$p2,$arq->DATA);
            $ARRAYTMP = new Arquivo($x);
            
            $arq->Add_Array("Arquivo",$ARQ_IN);
            
            /*
            $l = count($ARRAYTMP->DATA);
            foreach ($ARRAYTMP->DATA as $key => $value) {
                if($p = strpos($ARRAYTMP->DATA[$key],":")) {
                    $chave = substr($ARRAYTMP->DATA[$key],0,$p);
                    $arq->Add_Array($chave,$ARRAYTMP->Normaliza($ARRAYTMP->DATA[$key]));
                }
            }
            */
            
            /*
            Monta os dados da Razão Social do contratado
            */
            
            $arq->Pesquisa_Palavra("B) CONTRATADA");
            $p1 = $arq->KEY_WORD+1;
            
            $arq->Pesquisa_Palavra("Insc. Municipal");
            $p2 = $arq->KEY_WORD;
            
            if($p2 == 0) { //busca alternativa para construir o outro array
                $arq->Pesquisa_Palavra("DO OBJETO");
                $p2 = $arq->KEY_WORD;
            }
            
            $x = $arq->Monta_Array($p1,$p2,$arq->DATA);
            
            $ARRAYTMP = new Arquivo($x);
            
            $l = count($ARRAYTMP->DATA);
            
            foreach ($ARRAYTMP->DATA as $key => $value) {
                if($p = strpos($ARRAYTMP->DATA[$key],":")) {
                    $chave = "C_".substr($ARRAYTMP->DATA[$key],0,$p);
                    $arq->Add_Array($chave,$ARRAYTMP->Normaliza($ARRAYTMP->DATA[$key]));
                }
                //verifica se o cnpj esta a linha de baixo
                if(strpos($ARRAYTMP->DATA[$key],"/0001") > 0) {
                    $chave = "C_CNPJ";
                    $px = strpos($ARRAYTMP->DATA[$key],"Insc.");
                    $arq->Add_Array($chave,substr($ARRAYTMP->DATA[$key],0,$px-1));
                }
                
            }
            
            //saneia o array a procura do nome inconsistente C_<cnpj>
            if(isset($arq->INFO["C_CNPJ"])) {
                $c_cnpj = "C_".$arq->INFO["C_CNPJ"];
                
                foreach($arq->INFO as $key => $value) {
                    if(substr($key,0,22) == $c_cnpj) {
                        $valor = $arq->INFO[$key]; 
                        unset($arq->INFO[$key]);
                        $arq->INFO["C_Insc. Municipal"] = $valor;
                    }
                }
            }
            //Ajusta o CNPJ que esta na mesma linha
            $arq->Ajusta_CNPJ_Contratado("C_CNPJ");
            //        dd($arq->INFO);die();
            
            /*
            Leitura da proxima página
            */
            /*
            if ($arq->Arquivo_Origem_Pagina(1)) {
                $lines = file($PATH_IN.$arq->ARQUIVO_PROX,FILE_SKIP_EMPTY_LINES);
                $seq = new Arquivo($lines);
                $seq->Pesquisa_Palavra("firme e valioso");
                $p1 = $seq->KEY_WORD+1;
                $p2 = count($arq->DATA);
                
                $x = $seq->Monta_Array($p1,$p2,$arq->DATA);
                
                $seq->Pesquisa_Palavra("São Paulo");
                
                if($seq->KEY_WORD > 0) {
                    //achou a data
                    $data = $seq->DATA[$seq->KEY_WORD];
                    $arq->Add_Array("Data Contrato",$data);
                } else {
                    $arq->Add_Array("Data Contrato","");
                }
                
                $p1_restante = $p1+1;
                $seq->Pesquisa_Palavra("Testemunhas");
                
                $x = $seq->Monta_Array($p1_restante+1,($seq->KEY_WORD)-1,$seq->DATA);
                
                $s = $seq->Array_To_String($x);
                $arq->Add_Array("Restante Info",$s);
            } 
            */           
            return ($arq->INFO);
        } else {
            $arq->Add_Array("Arquivo",$ARQ_IN);
            return (array());
        }
        
    }
}

?>