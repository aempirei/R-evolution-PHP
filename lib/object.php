<?

class Object extends stdClass {
	private static $__ID_SEQ__ = 0;

	private $__ID__;
	private $__FROZEN__ = false;
	private $__TAINTED__ = false;

	protected $DATA = null;

	static public function N() {
		if(func_num_args() > 0)
			return new static(func_get_arg(0));
		return new static();
	}

	function __construct() {

		$this->__ID__ = Object::$__ID_SEQ__;

		Object::$__ID_SEQ__++;

		if(func_num_args() > 0)
			$this->load(func_get_arg(0));
	}

	// new

	// ==

	function equal($b) {
      return is_o($b) and $this->object_id() == $b->object_d();
	}

	function equ($b) {
      return is_o($b) and $this->hash() == $b->hash();
	}

	// =~

	final protected function __id__() {
		return $this->__ID__;
	}

	final function object_id() {
		return $this->__id__();
	}

	// send
	// __send__

	final function classname() {
		return get_class($this);
	}
	
	// clone

   function __clone() {
      $this->DATA = clone $this->DATA;
    	$this->__ID__ = Object::$__ID_SEQ__;
		Object::$__ID_SEQ__++;
   }
   
	function display($port='php://stdout') {
		$fp = fopen($port, 'w');
		fputs($fp, $this);
	}

   function dup() {
      return clone $this;
   }

	function to_enum($method='each') {
		$args = func_get_args();
		array_shift($args);
		return new \Enumerable\Enumerator($this, $method, $args); // FIXME: this should NOT
	}

	function enum_for() {
		return $this->call('to_enum', func_get_args());
	}

	// extend -- this is some fancy shit, somehow dynamically pull the instance methods from the listed modules and add it to the current object

	function freeze() {
		$this->__FROZEN__ = true;
	}

	function is_frozen() {
		return $this->__FROZEN__;
	}

	function hash() {
		return md5((string)$this);
	}

	function inspect() {
		return $this->to_s();
	}

	// instance_eval

	// instance_exec

	function is_instance_of($class) {
		return $class == $this->classname();
	}

	// is_instance_variable_defined

	// is_instance_variable_defined

	// instance_variable_get

	// instance_variable_set

	function instance_variables() {
		return new A(get_object_vars($this));
	}

	function is_a($class) {
		return is_a($this, $class);
	}

	function is_kind_of($class) {
		return $this->is_a($class);
	}

	function methods($filter=-1) {
		$r = new ReflectionClass($this);
		return A::N($r->getMethods($filter))->map(function($m) { return new S($m->name); });
	}

	function is_nil() {
		return false;
	}

	function private_methods() {
		return $this->methods(ReflectionMethod::IS_PRIVATE);
	}

	function protected_methods() {
		return $this->methods(ReflectionMethod::IS_PROTECTED);
	}

	function public_methods() {
		return $this->methods(ReflectionMethod::IS_PUBLIC);
	}

	// remove_instance_variable

	function respond_to($name, $include_private=false) {
		return method_exists($this, $name);
		if($include_private)
			throw new Exception($this->classname().' doesnt implement include_private'); 
	}

	// singleton_method_added

	// singleton_method_removed

	// singleton_method_undefined

	// singleton_methods

	function taint() {
		$this->__TAINTED__ = true;
	}

	function is_tainted() {
		return $this->__TAINTED__;
	}

	function tap($f) {
		$f($this);
		return $this;
	}

	function to_a() {
		return new A($this);
	}

	function to_s() {
		return new S((string)$this);
	}

   function object_string() {
		return $this->classname().'('.$this->object_id().')';
   }

	function __toString() {
		return $this->object_string();
	}

   function type() {
      return $this->classname();
   }

   function untaint() {
      $this->__TAINTED__ = false;
   }

   function gt($x) {
      return $this->cmp($x) > 0;
   }

   function lt($x) {
      return $this->cmp($x) < 0;
   }

   function ge($x) {
      return $this->cmp($x) >= 0;
   }

   function le($x) {
      return $this->cmp($x) <= 0;
   }

   function eq($x) {
      return $this->cmp($x) == 0;
   }

   function between($min,$max) {
      return $this->ge($min) and $this->le($max);
   }

	function call($method, $args) {
		return call_user_func_array(array($this, $method), $args);
	}

   function native() {
      return $this->DATA;
   }
};

