<?

function is_o($a) {
	return is_a($a, 'Object');
}

function equ($a,$b) {
  return (is_o($a) and is_o($b) and $a->equ($b)) or ($a === $b);
}

function get_cmp($f=null) {
   if($f===null)
      return function($x,$y) { return $x->cmp($y); };
   return $f;
}

function lift($x) {
	if(is_float ($x)) return new F($x);	
	if(is_bool  ($x)) return new B($x);	
	if(is_int   ($x)) return new I($x);	
	if(is_o     ($x)) return $x;
	if(is_object($x)) throw new Exception('cannot lift object');
	if(is_array ($x)) throw new Exception('cannot lift array');
	if(is_null  ($x)) throw new Exception('cannot lift null');
}

# error_reporting(E_ALL);
# set_error_handler('default_error_handler', E_ALL);

function default_error_handler($errno, $errstr, $errfile, $errline) {

   static $errorTypes = array(E_ERROR => 'Error',
                              E_WARNING => 'Warning',
                              E_PARSE => 'Parse Error',
                              E_NOTICE => 'Notice',
                              E_CORE_ERROR => 'Core Error',
                              E_CORE_WARNING => 'Core Warning',
                              E_COMPILE_ERROR => 'Compile Error',
                              E_COMPILE_WARNING => 'Compile Warning',
                              E_USER_ERROR => 'User Error',
                              E_USER_WARNING => 'User Warning',
                              E_USER_NOTICE => 'User Notice',
                              E_STRICT => 'Strict Notice',
                              E_RECOVERABLE_ERROR => 'Recoverable Error');

	echo $errorTypes[$errno]."($errno) in $errfile($errline)\n";
	echo $errstr."\n";
	throw new Exception;
}

require_once('./lib/object.php');
require_once('./lib/comparable.php');
require_once('./lib/enumerable.php');
require_once('./lib/indexable.php');
require_once('./lib/numeric.php');
require_once('./lib/precision.php');
require_once('./lib/rational.php');
require_once('./lib/array.php');
require_once('./lib/float.php');
require_once('./lib/hash.php');
require_once('./lib/integer.php');
require_once('./lib/nilclass.php');
require_once('./lib/string.php');
