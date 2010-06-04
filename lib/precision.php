<?

abstract class Precision extends Numeric implements Comparable {
   function __toString() {
      return (string)$this->native();
   }
   function cmp($a) {
      return $this->native() - $a->native();
   }
}

