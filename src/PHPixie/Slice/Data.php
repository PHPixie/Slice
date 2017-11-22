<?php

namespace PHPixie\Slice;

interface Data extends \IteratorAggregate
{
    public function get(?string $path = null, $default = null) ;
    public function getRequired(?string $path = null) ;
    public function getData(?string $path = null, bool $isRequired = false,  $default = null) ;
    
    public function keys(?string $path = null, bool $isRequired = false) : ?array;
    public function slice(?string $path = null) : Data\Slice;
    public function arraySlice(?string $path = null) : Type\ArrayData\Slice;
}
