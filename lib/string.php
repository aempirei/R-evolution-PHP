<?

function S() {
	if(func_num_args() == 0)
		return new S();
	return new S(func_get_arg(0));
}

class S extends Indexable implements Comparable {

	protected $DATA = '';

	function cmp($a) {
		return strcmp((string)$this, (string)$a);
	}

	public function offsetGet($offset) {
		return isset($this->DATA[$this->__index__($offset)]) ? S($this->DATA[$this->__index__($offset)]) : null;
	}

	function __toString() {
		return (string)$this->DATA;
	}

	function reverse() {
		$class = $this->classname();
		return new $class(strrev($this->DATA));
	}

	function load($string) {
		$this->DATA = (string)$string;
		return $this;
	}

	function concat($x) {
		$this->DATA .= (string)$x;
		return $this;
	}

	function size() {
		return strlen($this->DATA);
	}

	function slice($first, $length=null) {
		$class = $this->classname();
		if($length === null)
			return new $class(substr($this->DATA, $first));
		return new $class(substr($this->DATA, $first, $length));
    }
}
