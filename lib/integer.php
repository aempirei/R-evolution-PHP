<?

class I extends Precision {

	protected $DATA = 0;

	function load($integer) {
		$this->DATA = (integer)$integer;
		return $this;
	}
}
