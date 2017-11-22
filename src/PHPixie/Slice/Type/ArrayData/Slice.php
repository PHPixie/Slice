<?php

namespace PHPixie\Slice\Type\ArrayData;

class Slice extends    \PHPixie\Slice\Type\ArrayData
            implements \PHPixie\Slice\Data\Slice
{
    protected $path;

    public function __construct(\PHPixie\Slice $sliceBuilder, array $data = null, ?String $path = null)
    {
        parent::__construct($sliceBuilder, $data);
        $this->path = $path;
    }
    
    public function path(?string $path = null) : ?string
    {
        return $this->mergePath($this->path, $path);
    }
}
