<?
class F extends Precision {

	protected $DATA = 0.0;

	function load($float) {
		$this->DATA = (float)$float;
		return $this;
	}
}
