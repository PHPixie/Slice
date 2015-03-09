<?php

namespace PHPixie\Slice\Data;

abstract class Implementation implements \PHPixie\Slice\Data
{
    protected $sliceBuilder;
    
    public function __construct($sliceBuilder)
    {
        $this->sliceBuilder = $sliceBuilder;
    }
    
    public function get($key = null, $default = null)
    {
        return $this->getData($key, false, $default);
    }
    
    public function getRequired($key = null)
    {
        return $this->getData($key, true);
    }

    public function getIterator()
    {
        return $this->sliceBuilder->iterator($this);
    }
}