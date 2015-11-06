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
    
    public function arraySlice($path = null)
    {
        $data = $this->get($path);
        $path = $this->path($path);
        return $this->sliceBuilder->arraySlice($path, $data);
    }
    
    protected function dataPath($path)
    {
        return $path;
    }
    
    protected function mergePath($prefix, $path = null)
    {
        if($prefix === null)
            return $path;
        
        if ($path === null)
            return $prefix;
        
        return $prefix.'.'.$path;
    }
}
