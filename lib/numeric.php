<?

abstract class Numeric extends Object {
	function to_f() {
		return new F($this);
	}

	function to_i() {
		return new I($this);
	}

	function to_b() {
		return new B($this);
	}
}
