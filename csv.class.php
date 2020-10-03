<?php
class CSV {
	/*
	http://www.tristanwaddington.com/2010/02/create-a-csv-with-php/
	*/
	protected $data;
	/*
	* @params array $columns
	* @returns void
	*/
	public function __construct($columns) {
		$this->data = '"' . implode('";"', $columns) . '"' . "\n";
	}
	/*
	* @params array $row
	* @returns void
	*/
	public function addRow($row) {
		$this->data .= '"' . implode('";"', $row) . '"' . "\n";
	}
	/*
	* @returns void
	*/
	public function export($filename) {
		//header('Content-type: application/csv');
		//header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
		$fp = fopen($filename,"w");
		fwrite($fp,$this->data);
		fclose($fp);

		//echo $this->data;
		
	}
	public function __toString() {
		return $this->data;
	}
}
?>