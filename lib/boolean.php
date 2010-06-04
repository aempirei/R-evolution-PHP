<?

class B extends Numeric {

	protected $DATA = false;
	
	function not() {
		$class = $this->classname();
		return new $class(!$this->DATA);
	}

	function inverse() {
		return $this->not();
	}

	function __toString() {
		return $this->DATA === true ? 'TRUE' : 'FALSE';
	}

	function load($boolean) {
		$this->DATA = (boolean)$boolean;
		return $this;
	}
}

