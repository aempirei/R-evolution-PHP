<?

function A() {
	return new A(func_get_args());
}

class A extends Indexable {

	protected $DATA = array();

	function slice($first, $length=null) {
		$class = $this->classname();
		if($length === null)
			return new $class(array_slice($this->DATA, $first));
		return new $class(array_slice($this->DATA, $first, $length));
	}

	// assoc

	function size() {
		return sizeof($this->DATA);
	}

	function clear() {
		$this->DATA = array();
		return $this;
	}

	// combination

	function compact() {
		$this->reject(function($x) { return $x == null; });
		return $this;
	}

	function concat($a) {
		$this->DATA = array_merge($this->DATA, $a->DATA);
		return $this;
	}

	function delete($obj,$f=null) {
		$data = $this->reject(function($x) { return equ($x, $obj); });
		if($data->size() == $this->size())
			return is_callable($f) ? $f() : $f;
		$this->DATA = $data->native();
		return $obj;
	}

	function delete_at($i) {
		if($i < 0)
			$this->delete_at($this->size() - $i);
		else {
			unset($this->DATA[$i]);
			$this->DATA = array_values($this->DATA);
		}
	}

	function delete_if($f) {
	  $data = $this->reject($f);
	  if($data->size() < $this->size())
		 $this->DATA = $data->native();
	  return $this;
	}

	function index() {
		return $this->call('find_index', func_get_args());
	}

	function replace($a) {
		if(!(is_o($a) and $a->is_a('Array')))
			throw new Exception($this->classname().' is not an Array');
		$this->DATA = clone $a->native();
	}

	// insert

	function __toString() {
		return $this->object_string().' [ '.$this->join(',').' ]';
	}

	function join($sep=',') {
		return new S( join($sep, $this->map(function($x) { return (string)$x; })->native()) );
	}

	function nitems() {
		$count = 0;
		foreach($this->DATA as $value)
			if($value != null)
				$count++;
		return $count;
	}

	// pack

	// permutation

	// product

	// rassoc

	function reverse() {
		return new A(array_reverse($this->DATA));
	}

	function rindex() {
		$i = $this->reverse()->call('index', func_get_args());
		return $this->size() - $i - 1;
	}

	// transpose

	// uniq

	function to_a() {
		return $this;
	}

	function set() {
	  
	  $args = func_get_args();

	  $first = $args[0];

	  if(is_a($first, 'Range')) {
		 list($first, $value) = $args;
		 $last = $first->last();
		 $first = $first->first();
		 $length = $last - $first + 1;
		 return $this->set($first,$length,$value);
	  } elseif(sizeof($args) == 3) {
		 list($offset, $length, $value) = $args;
		 throw new Exception($this->classname().' does not implement set(offset,length,value)');
	  } else {
		 list($offset, $value) = $args;
		 $this->DATA[$i] = $x;
	  }

	  return $this;
	}

	// new

	function push() {
	  foreach(func_get_args() as $x)
		 $this->DATA[] = $x;
	}

	function pop($n=null) {
	  if($n!=null)
		 throw new Exception($this->classname().' does not implement pop(n)');
	  return array_pop($this->DATA);
	}

	function shift() {
	   if($n!=null)
		 throw new Exception($this->classname().' does not implement shift(n)');
	   return array_shift($this->DATA);
	}

	// shuffle

	function to_ary() {
	  return $this;
	}

	function unshift() {
	  foreach(array_reverse(func_get_args()) as $arg) 
		 array_unshift($this->DATA, $arg);
	}

	function load($array) {
		$this->DATA = (array)$array;
		return $this;
	}
}
