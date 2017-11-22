<?php

namespace PHPixie\Slice;

class Iterator implements \Iterator
{
    protected $data;
    protected $keys;
    
    protected $keyOffset;
    protected $keyCount;
    protected $currentKey;
    
    public function __construct(Data $data)
    {
        $this->data = $data;
        $this->rewind();
    }
    
    public function current()
    {
        return $this->data->getRequired($this->currentKey);
    }
    
    public function key()
    {
        return $this->currentKey;
    }
    
    public function next() : void
    {
        $this->keyOffset++;
        if($this->valid()) {
            $this->currentKey = $this->keys[$this->keyOffset];
        }
    }
        
    public function rewind() : void
    {
        $this->keys = $this->data->keys();
        
        $this->keyOffset  = 0;
        $this->currentKey = null;

        if($this->keys !== null) {
            $this->keyCount   = count($this->keys);
            $this->currentKey = $this->keys[$this->keyOffset];
        }
    }
    
    public function valid() : bool
    {
        return $this->keyOffset < $this->keyCount;
    }
}