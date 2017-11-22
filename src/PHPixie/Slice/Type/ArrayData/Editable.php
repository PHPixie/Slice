<?php

namespace PHPixie\Slice\Type\ArrayData;

use PHPixie\Slice;

class Editable extends    Slice\Type\ArrayData
               implements Slice\Data\Editable
{
    /**
     * @throws \PHPixie\Slice\Exception
     */
    public function set(?string $path = null,  $value = null) : void
    {
        if ($path === null) {
            
            if (!is_array($value)) {
                throw new Slice\Exception("Only array values can be set as root");
            }
            $this->data = $value;
            return;
        }
        
        list($path, $key) = $this->splitPath($path);
        $parent = &$this->findGroup($path, true);
        $parent[$key] = $value;
    }

    /**
     * @throws \PHPixie\Slice\Exception
     */
    public function remove(?string $path = null) : void
    {
        if ($path === null) {
            $this->data = array();
            return;
        }
        
        list($path, $key) = $this->splitPath($path);
        $parent = &$this->findGroup($path);
        
        if($parent !== null) {
            unset($parent[$key]);
        }
    }

    public function slice(?string $path = null) : Slice\Data\Slice
    {
        return $this->sliceBuilder->editableSlice($this, $path);
    }
}
