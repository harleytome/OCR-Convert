<?php

$START_TIME = 0;
$END_TIME = 0;
$SPEND_TIME = 0;

class Performance {
    
    public function Start_Time() {
        list($usec, $sec) = explode(' ', microtime());
        $this->START_TIME = (float) $sec + (float) $usec;      
    }
    
    public function End_Time() {
        list($usec, $sec) = explode(' ', microtime());
        $this->END_TIME = (float) $sec + (float) $usec;
        $this->SPEND_TIME = round($this->END_TIME - $this->START_TIME, 5);
    }

    public function Memory_Used() {
        //Mbytes
        return round(((memory_get_peak_usage(true) / 1024) / 1024), 2);
    }
}