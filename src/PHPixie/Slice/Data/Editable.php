<?php

namespace PHPixie\Slice\Data;

interface Editable extends \PHPixie\Slice\Data
{
    public function remove($path = null);
    public function set($path, $value);
    public function editableSlice($path);
}
