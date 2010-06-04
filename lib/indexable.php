<?

abstract class __Indexable_implements_ArrayAccess__ extends Enumerable implements ArrayAccess {

    #
    # this private function can index arrays with negative indicies by starting at the end of the array
    #

    protected function __index__($offset) {
		if(is_o($offset))
			return (string)$offset;
        if($offset < 0)
            return $this->size() + $offset;
        return $offset;
    }

    #
    # this is the default implementation for the ArrayAccess interface
    #

    public function offsetSet($offset, $value) {
        $this->DATA[$this->__index__($offset)] = $value;
    }

    public function offsetExists($offset) {
        return isset($this->DATA[$this->__index__($offset)]);
    }

    public function offsetUnset($offset) {
        unset($this->DATA[$this->__index__($offset)]);
    }

    public function offsetGet($offset) {
        return isset($this->DATA[$this->__index__($offset)]) ? $this->DATA[$this->__index__($offset)] : null;
    }
}

abstract class Indexable extends __Indexable_implements_ArrayAccess__ {

	function at($i) {
		return $this[$i];
	}

	function choice() {
		return $this[rand(0, $this->size())];
	}
}
