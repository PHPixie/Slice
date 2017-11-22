<?php

namespace PHPixie\Slice\Type;

class Slice extends \PHPixie\Slice\Data\Implementation
{
    protected $data;
    protected $path;

    public function __construct(\PHPixie\Slice $sliceBuilder, \PHPixie\Slice\Data $data, ?string $path = null)
    {
        $this->data = $data;
        $this->path = $path;
        parent::__construct($sliceBuilder);
    }

    public function getData(?string $path = null, bool $isRequired = false,  $default = null)
    {
        $path = $this->dataPath($path);
        return $this->data->getData($path, $isRequired, $default);
    }

    public function slice(?string $path = null) : \PHPixie\Slice\Data\Slice
    {
        return $this->data->slice($this->dataPath($path));
    }
    
    public function arraySlice(?string $path = null) : ArrayData\Slice
    {
        return $this->data->arraySlice($this->dataPath($path));
    }
    
    public function keys(?string $path = null, bool $isRequired = false) : ?array
    {
        return $this->data->keys($this->dataPath($path), $isRequired);
    }

    public function path(?string $path = null) : ?string
    {
        $path = $this->dataPath($path);
        
        if($this->data instanceof \PHPixie\Slice\Data\Slice) {
            $path = $this->data->path($path);
        }
        
        return $path;
    }
    
    public function getIterator() : \PHPixie\Slice\Iterator
    {
        return $this->sliceBuilder->iterator($this);
    }
    
    protected function dataPath($path) : string
    {
        return $this->mergePath($this->path, $path);
    }
}
