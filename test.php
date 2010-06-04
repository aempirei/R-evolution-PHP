#!/usr/local/bin/php
<?

require('./lib/revo.php');

echo "loading array\n";

# although the native php array is associative, numerically indexed Arrays and associative Hashes are actually different classes
# from within the R:evolution (RevoPHP) alternative standard php library.

#
# ways to create an Array (A) object
# the Array class is actually named A
#
# A(...) takes a variable argument list which is then turned into an Array (A) object
# new A(array(...)) takes a single native array as a parameter which is then turned into an Array (A) object
# new A() returns an empty Array object

$a = new A();
$a = new A(array(1,2,3,4,5,6,7));
$a = A(3,4,9,5,7,4);

# all objects are assigned a unique Id
# their classname is accessable to them
# they are always castable to a string

echo "object id is ".$a->object_id()." and object type is ".$a->classname()."\n";
echo "object looks like ".$a."\n";

# all Enumerable objects can be iterated with each() which is an alternative to the foreach() syntax

$a->each(function($x) { echo "using each outputting ".$x."\n"; });

foreach($a as $x) echo "using foreach outputting ".$x."\n";

# join() is a method on any Enumerable class, which optionally takes a seperator string otherwise defaults to a comma

echo "forward ".$a->join()."\n";

# reverse() reverses the order of any Enumerable object, attempting to retain the type otherwise resulting in an Array

echo "reverse ".$a->reverse()->join('-')."\n";

# slice() works like PHP slice and operates on any Enumerable class

echo "slicing array : ".$a->slice(-3)->join(' ')."\n";
echo "slicing array : ".$a->slice(-3,1)->join(' ')."\n";
echo "lasting array : ".$a->slice(3)->join(' ')."\n";
echo "lasting array : ".$a->slice(3,1)->join(' ')."\n";

# any class derived from 'Indexable' is indexible using [] notation, which includes Array (A), Hash (H) and String (S).

echo "indexing array : ".$a[0].' <=> '.$a[-1]."\n";

echo "mapping array through y = x / 5\n";

# map() is much like array_map in php or map in ruby, perl or haskell. it requires a function as an argument
# and is available to any Enumerable object and returns an Array
# each_with_index() accepts a 2-place function with the index and value of each element within the Enumerable object

$a->map(function($x) { return $x / 5; })->each_with_index(function($i, $x) { echo $i.' => '.$x."\n"; });

echo "getting methods\n";

# the method 'methods' is availble to any object and returns an Array of all methods the objecth as available to it.

echo "sorting/joining methods : ".$a->methods()->sort()->join(' ')."\n";

# any Enumerable object can be sorted so long as the the objects contained within the Enumerable object are 'Comparable'

echo "sorting some various integers : ".A(1,4,6,4,2,23,4,4,11,111)->map(function($x) { return I::N($x); })->sort()->join(' ')."\n";

echo "assigning a string\n";

# creating a String (S) is much like creating an Array
# the String class is actually named S

$s = new S("I'm with stupid");
$s = S("Magical");

echo "the string is : ".$s."\n";

echo "interating over a string\n";

# map() on a string works but returns an Array
# reverse_each() is a superfluous iterator method like each() but in reverse

$s->map(function($x) { return ">> $x <<\n"; })->reverse_each(function($x) { echo $x; });
echo $s->map(function($x) { return ">> $x <<\n"; })->reverse()->join('');

# again, slice() works on all Enumerable objects

echo "slicing string : ".$s->slice(0,3)."\n";

# last() and first() work similarly to ruby but attempts to retain type.
# without an argument it simply returns the bare element without wrapping in the origical Enumerable derived type

echo "lasting string : ".$s->last(3)."\n";

echo "getting first and last characters of string: ".$s->first().' <=> '.$s->last()."\n";
echo "getting first and last values of array : ".$a->first().' <=> '.$a->last()."\n";

# indexing strings works like indexing any Indexable type

echo "indexing string, getting first and last characters : ".$s[0].' <=> '.$s[-1]."\n";

# any Enumerable type can be explicitly converted into an Array via an implicit map() function through the identity function f(x)=x

echo "string to array : ".$s->to_a()->join('-')."\n";

# concat() works to append to the string being operated on

echo "building some stupid ass string : ".$s->concat($s)->concat('hello')->concat('world')."\n";

# reject() and select() operate on Enumerable types returning either removing or limiting the resultant set to the members that
# either pass or fail the test function

echo "rejecting all L's ".$s->reject(function($x) { return $x == 'l'; })->join('-')."\n";
echo "selecting only L's ".$s->select(function($x) { return $x == 'l'; })->join('-')."\n";

# first,last,take,drop all will operate on objects that are too small and returns an empty set of the original Enumerable derived type

echo "firsting empty string : ".S()->first(2)."\n";
echo "firsting empty string : ".S()->last(2)."\n";
echo "firsting empty array : ".A()->first(2)."\n";
echo "firsting empty array : ".A()->last(2)."\n";

echo "first 2 letters : ".S("SATURN")->take(2)."\n";
echo "skip 2 letters : ".S("SATURN")->drop(2)."\n";

# head/tail work like the (x:xs) pattern in haskell, either returning the first bare 'head' element or the remaining 'tail' list

echo "x:xs => ".S("SATURN")->head().':'.S("SATURN")->tail()."\n";
echo "x:xs => ".S("SATURN")->to_a()->head().':'.S("SATURN")->to_a()->tail()."\n";

# creating a Hash (H) is much like creating an Array
# the Hash class is actually named H

# the H() function does not accept the KEY => VALUE syntax, but instead accepts a parameter list of alternating KEY, VALUE, parameters
# the new H(array(...)) syntax does accept KEY => VALUE notation but with the drawback that KEYs must be defined using native types.

$h = H(S("SATURN"), 1, 'hello', 2, 'goodbye', 3, 'fatty', 0);
$h = new H(array("SATURN" => 1, 'hello' => 2, 'goodbye' => 3, 'fatty' => 0));

echo "hash = ".$h."\n";

# the each() iterator for hashes pass a 2-pair array containing at offset 0 the KEY and offset 1 the VALUE i.e. A($key, $value)

$h->each(function($x) { echo ">> each() $x <<\n"; });

# the each_pair() function is an alias of each_with_index() passing each key,value pair to the callback function

$h->each_pair(function($x,$y) { echo ">> each_pair() key={$x} value={$y} <<\n"; });

# there are many other methods
# please refer to the code within the lib/ directory for now
# each class is broken up into seperate files

function quicksort($xs) {

	if($xs->count() < 2)
		return $xs;

	$p = $xs->head();

	$fn = function($x) use($p) { return $x < $p; };

	return
		quicksort($xs->tail()->select($fn))
		->concat(A($p))
		->concat(quicksort($xs->tail()->reject($fn)));
}

echo quicksort(S('Go, team, go!'))->each(function($x) { echo "> $x\n"; });
