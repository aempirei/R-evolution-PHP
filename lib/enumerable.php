<?

abstract class __Enumerable_implements_Iterator__ extends Object implements Iterator {

	private $__POSITION__ = 0;

	function rewind() {
		$this->__POSITION__ = 0;
	}

	function current() {
		return $this[$this->__POSITION__];
	}

	function key() {
		return $this->__POSITION__;
	}

	function next() {
		++$this->__POSITION__;
	}

	function valid() {
		return isset($this[$this->__POSITION__]);
	}
}

abstract class Enumerable extends __Enumerable_implements_Iterator__ {

	#
	# this is where the rest of the Enumerable class is implemented
	#

	function all($f) {
		return $this->select($f)->count() == $this->count();
		return $this->inject(true, function($acc, $x) use($f) { return $acc and ($f($x) != false); });
	}

	function any($f) {
		return $this->select($f)->count() > 0;
		return $this->inject(false, function($acc, $x) use($f) { return $acc or ($f($x) != false); });
	}

	function map($f) {
		return $this->inject(new A(), function ($acc, $x) use($f) { $acc->push($f($x)); return $acc; });
	}

	function collect($f) {
		return $this->map($f);
	}

	abstract function load($data);

	function count($filter=null) {

		if($filter == null and $this->respond_to('size'))
			return $this->size();
		
		$sum = 0;

		$this->each(function($x) use(&$sum,$filter) {
			if($filter == null) {
				$sum++;
			} elseif(is_callable($filter) and $filter($x) == true) {
					$sum++;
			} elseif(equ($filter, $x)) {
				$sum++;
			}
		});

		return $sum;
	}

	function is_empty() {
		return $this->count() == 0;
	}

	function cycle() {

		$n = null;

		list($f, $n) = array_reverse(func_get_args());

		if($n <= 0 or $this->count() == 0)
			return;
		
		for($i = 0; is_null($n) or (is_int($n) and $i < $n); $i++)
			$this->each(function($x) use($f) { $f(x); });
	}

	function find() {

		$ifnone = null; 

		list($f, $ifnone) = array_reverse(func_get_args());

		$found = null;

		foreach($this as $x)
			if($f($x))
				return $x;

		return is_callable($ifnone) ? $ifnone() : $ifnone;
	}

	function detect() {
		return $this->call('find', func_get_args());
	}

	function drop($n) {
		return $this->slice($n);
	}

	function drop_while($f) {
		$a = $this->to_a()->dup();
		while($f($a->first()))
			$a->shift();
		return $a;
	}

	function each_cons($n,$f=null) {
		if($f == null)
			throw new Exception($this->classname().' doesnt implement each_cons(n) only each_cons(n,f)');
		for($i = 0; $i < $n; $i++)
			$f($this->slice($i, $n));
	}

	function each($f) {
		foreach($this as $x)
			$f($x);
	}

	function each_slice($n, $f=null) {
		if($f == null)
			throw new Exception($this->classname().' doesnt implement each_slice(n) only each_slice(n,f)');
		for($i = 0; $i < $n; $i += $n)
			$f($this->slice($i, $n));
	}

	function each_with_index($f) {
		foreach($this as $i => $x)
			$f($i, $x);
	}

	function entries() {
		return $this->to_a();
	}

	function to_a() {
		return $this->map(function($x) { return $x; });
	}

	function select($f) {
		return $this->inject(new A(), function($acc,$x) use($f) {
			if($f($x))
				$acc->push($x);
			return $acc;
		});
	}

	function find_all($f) {
		return $this->select($f);
	}

	function find_index($any) {
		foreach($this as $i => $x) {
			if(is_callable($any) and $any($x))
				return $i;
			elseif(!is_callable($any) and equ($x,$any))
				return $i;
		}
	}

	function first($n=null) {
		if($n == null)
			return $this->is_empty() ? null : $this->take(1)->to_a()->at(0);
		return $this->take($n);
	}

	function last($n=null) {
		if($n==null)
			return $this->is_empty() ? null : $this->slice(-1)->first();
		return $this->slice(-$n);
	}

	function head() {
		return $this->first();
	}

	function tail() {
		return $this->drop(1);
	}

	function grep($pattern, $f=null) {
		$a = $this->select(function($x) use($pattern) { return preg_match($pattern, $x); });
		return is_callable($f) ? $a->map($f) : $a;
	}

	function group_by($f) {
		return $this->inject(new H(), function($acc, $x) use($f) {
			$key = $f($x);
			if(!$acc->has_key($key))
				$acc->set($key, new A());
			$acc->get($key)->push($x);
			return $acc;
		});
	}

	function included($x) {
		return $this->member($x);
	}

	function member($obj) {
		return $this->find(function($y) use($obj) { return equ($obj, $y); }) != null;
	}

	function inject($init, $f) {
		$this->each(function($x) use(&$init, $f) { $init = $f($init, $x); });
		return $init;
	}

	function max($f=null) {
		return $this->max_by(get_cmp($f));
	}

	function max_by($f) {
		return $this->inject($this->first(), function($acc, $x) { $acc = ($f($acc,$x) == 1) ? $acc : $x; });
	}

	function min($f=null) {
		return $this->min_by(get_cmp($f));
	}

	function min_by($f) {
		return $this->inject($this->first(), function($acc, $x) { $acc = ($f($acc,$x) == -1) ? $acc : $x; });
	}

	function minmax($f=null) {
		return $this->minmax_by(get_cmp($f));
	}

	function minmax_by($f) {
		return new A($this->min_by($f), $this->max_by($f));
	}

	function none($f) {
		return $this->select($f)->count() == 0;
	}

	function one($f) {
		return $this->select($f)->count() == 1;
	}

	function partition($f) {
		return new A($this->select($f), $this->reject($f));
	}

	function reject($f) {
		return $this->select(function($x) use($f) { return !$f($x); });
	}

	function reverse_each($f) {
		foreach($this->reverse() as $x)
			$f($x);
	}

	function slice() {
		return $this->to_a()->call('slice', func_get_args());
	}

	function sort($f=null){
		return $this->sort_by(get_cmp($f));
	}
	
	function sort_by($f) {
		$a = $this->to_a()->native();
		usort($a, $f);
		return new A($a);
	}

	function take($n) {
		return $this->slice(0, $n);
	}

	function take_while($f) {
		$a = $this->to_a();
		$b = new A();
		while($f($a->first()))
			$b->push($a->first());
		return $b;
	}

	function zip() {
		$args = func_get_args();
		$a = new A();
		$a->push($this);
		foreach($args as $arg)
			$a->push(new A($arg));
		throw new Exception($this->classname().' doesnt implement zip');
	}
}

