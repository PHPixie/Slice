<?php

namespace PHPixie\Slice\Type\ArrayData;

class Editable extends    \PHPixie\Slice\Type\ArrayData
               implements \PHPixie\Slice\Data\Editable
{
    /**
     * @param string $path
     * @param array  $value
     * @throws \PHPixie\Slice\Exception
     */
    public function set($path = null, $value)
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

    public function add($path, $value)
    {
        if ($path === null) {

            if (!is_array($value)) {
                throw new \PHPixie\Slice\Exception("Only array values can be set as root");
            }
            $this->data = array_replace_recursive($this->data, $value);

            return;
        }
        if ($this->data === null) {
            $this->data = array();
        }
        list($path, $key) = $this->splitPath($path);
        $parent = &$this->findGroup($path, true);
        $parent[$key] = isset($parent[$key]) ? array_replace_recursive($parent[$key], $value) : $value;
    }

    /**
     * @throws \PHPixie\Slice\Exception
     */
    public function remove($path = null)
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

    /**
     * @return \PHPixie\Slice\Type\Slice\Editable
     */
    public function slice($path = null)
    {
        return $this->sliceBuilder->editableSlice($this, $path);
    }
}
