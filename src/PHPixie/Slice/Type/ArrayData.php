<?php

namespace PHPixie\Slice\Type;

use PHPixie\Slice;

class ArrayData extends Slice\Data\Implementation
{
    protected $data;

    public function __construct(Slice $sliceBuilder, ?array $data = array())
    {
        parent::__construct($sliceBuilder);
        $this->data = $data;
    }

    public function keys(?string $path = null, bool $isRequired = false) : ?array
    {
        $data = $this->getData($path, $isRequired, array());
        if(!is_array($data)) {
            return null;
        }
        return array_keys($data);
    }

    public function getData(?string $path = null, bool $isRequired = false,  $default = null)
    {
        if ($path !== null) {
            list($parentPath, $key) = $this->splitPath($path);
            $parent = &$this->findGroup($parentPath);
            if ($parent !== null && array_key_exists($key, $parent)) {
                return $parent[$key];
            }
            
        }elseif(!empty($this->data)) {
            return $this->data;
            
        }
        
        if (!$isRequired) {
            return $default;
        }
        
        throw new Slice\Exception("Data for '$path' is not set.");
    }

    public function slice(?string $path = null) : Slice\Data\Slice
    {
        return $this->arraySlice($path);
    }

    public function arraySlice(?string $path = null) : ArrayData\Slice
    {
        $data = $this->get($path);
        return $this->sliceBuilder->arraySlice($data, $path);
    }
    
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }
    
    protected function splitPath(string $path) : array
    {
        $path = explode('.', $path);
        $key = array_pop($path);
        return array($path, $key);
    }
    
    protected function &findGroup(?array $path, bool $createMissing = false) : ?array
    {
        $null = null;
        
        if(!is_array($this->data)) {
            return $null;
        }
        
        $group = &$this->data;
        
        foreach ($path as $i => $key) {

            if (!array_key_exists($key, $group)) {
                if (!$createMissing) {
                    return $null;
                }

                $group[$key] = array();
            }

            if (!is_array($group[$key])) {
                if (!$createMissing) {
                    return $null;
                }

                throw new Slice\Exception("An element with key '$key' is not an array.");
            }

            $group = &$group[$key];
        }

        return $group;
    }

}
