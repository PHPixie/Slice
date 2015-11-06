<?php

namespace PHPixie\Slice\Type\ArrayData;

class Slice extends    \PHPixie\Slice\Type\ArrayData
            implements \PHPixie\Slice\Data\Slice
{
    protected $path;

    public function __construct($sliceBuilder, $path, $data = null)
    {
        parent::__construct($sliceBuilder, $data);
        $this->path = $path;
    }
    
    public function path($path = null)
    {
        return $this->dataPath($path);
    }
    
    public function dataPath($path)
    {
        return $this->mergePath($this->path, $path);
    }
}
