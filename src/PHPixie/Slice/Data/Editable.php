<?php

namespace PHPixie\Slice\Data;

interface Editable extends \PHPixie\Slice\Data
{
    public function remove(?string $path = null) : void;
    public function set(?string $path,  $value) : void;
    public function slice(?string $path = null) : Slice;
}
