<?php

namespace PHPixie\Slice\Type;

class ArrayData extends    \PHPixie\Slice\Data\Implementation
                implements \PHPixie\Slice\Data\Editable
{
    protected $data;

    public function __construct($sliceBuilder, $data = null)
    {
        parent::__construct($sliceBuilder);
        $this->data = $data;
    }

    public function set($path, $value)
    {
        if ($path === null) {
            
            if (!is_array($value)) {
                throw new \PHPixie\Slice\Exception("Only array values can be set as root");
            }
            $this->data = $value;
            return;
        }
        
        list($path, $key) = $this->splitPath($path);
        $parent = &$this->findGroup($path, true);
        $parent[$key] = $value;
    }

    public function remove($path = null)
    {
        if ($path === null) {
            $this->data = null;
            return;
        }
        
        list($path, $key) = $this->splitPath($path);
        $parent = &$this->findGroup($path);
        
        if($parent !== null) {
            unset($parent[$key]);
        }
    }
    
    public function keys($path = null, $isRequired = false)
    {
        $data = $this->getData($path, $isRequired, array());
        return array_keys($data);
    }
    
    public function getData($path = null, $isRequired = false, $default = null)
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
        
        throw new \PHPixie\Slice\Exception("Data for '$path' is not set.");
    }
                    
    public function slice($path = null)
    {
        return $this->sliceBuilder->editableSlice($this, $path);
    }
    
    protected function splitPath($path)
    {
        $path = explode('.', $path);
        $key = array_pop($path);
        return array($path, $key);
    }
    
    protected function &findGroup($path, $createMissing = false) {
        if($this->data === null) {
            if(!$createMissing) {
                $return = null;
                return $return;
            }
            
            $this->data = array();
        }
        
        $group = &$this->data;
        $count = count($group);
        foreach ($path as $i => $key) {

            if (!array_key_exists($key, $group)) {
                if (!$createMissing) {
                    $return = null;
                    return $return;
                }

                $group[$key] = array();
            }

            if (!is_array($group[$key])) {
                if (!$createMissing) {
                    $return = null;
                    return $return;
                }

                throw new \PHPixie\Slice\Exception("An element with key '$key' is not an array.");
            }

            $group = &$group[$key];
        }

        return $group;
    }

}