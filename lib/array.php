<?php

abstract class ArrayMethods {
    
    function concat($arrays) {
        $arrays = func_get_args();
        foreach ($arrays as $array) {
            if ($array instanceof Enumerable) $array = $array->array;
            foreach ($array as $value) $this[] = $value;
        }
        return $this;
    }
    
    function compact() {
        return $this->reject('$value == null');
    }
    
    function flatten() {
        $result = $this->new_instance();
        foreach ($this as $value) {
            if (is_array($value)) $value = new A($value);
            if ($value instanceof A) {
                foreach ($value->flatten() as $flattened_value) $result[] = $flattened_value;
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
    
}

class A extends Enumerable {
    
    function offsetSet($offset, $value) {
        $this->super($this->count(), $value);
    }
    
    function unshift($value) {
        return array_unshift($this->array, $value);
    }
    
}

extend('A', 'ArrayMethods');

?>