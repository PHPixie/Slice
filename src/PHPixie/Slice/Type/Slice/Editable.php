<?php

namespace PHPixie\Slice\Type\Slice;

use PHPixie\Slice;

class Editable extends    Slice\Type\Slice
               implements Slice\Data\Slice\Editable
{
    public function set(?string $path = null,  $value = null) : void
    {
        $this->data->set($this->dataPath($path), $value);
    }

    public function remove(?string $path = null) :void
    {
        $this->data->remove($this->dataPath($path));
    }
}
