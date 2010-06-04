<?

function H() {
	$h = new H();

	$args = func_get_args();

	if(count($args) % 2 != 0)
		throw new Exception('unmatch key in arguements for H()');
	
	for($i = 0; $i < count($args); $i += 2)
		$h[$args[$i]] = $args[$i + 1];
	
	return $h;
}

class H extends Indexable implements Iterator {

	function to_a() {
		$a = new A();
		$this->each_pair(function($k,$v) use(&$a) { $a->push(new A($k,$v)); });
		return $a;
	}
   
	function each_pair($f) {
		return $this->call('each_with_index', func_get_args());
	}

	function load($array) {
		$this->DATA = (array)$array;
		return $this;
	}

	function __toString() {
		return $this->object_string().' { '.$this->map(function($x) { return $x[0].'=>'.$x[1]; })->join(' ').' }';
	}

	function rewind() {
		return reset($this->DATA);
	}

    function current() {
		return current($this->DATA);
    }

    function key() {
		return key($this->DATA);
    }

    function next() {
		return next($this->DATA);
    }

    function valid() {
        return isset($this[key($this->DATA)]);
    }

	function __construct() {
		call_user_func_array('parent::__construct', func_get_args());
	}

	function each($f) {
		foreach($this as $i => $x)
			$f(A($i,$x));
	}
}
