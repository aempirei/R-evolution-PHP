<?

class NilClass extends Numeric {
	function is_nil() {
		return true;
	}

	function inspect() {
		return 'nil';
	}

	function to_a() {
		return new A();
	}

	function __toString() {
		return '';
	}
}

