<?php

namespace PHPixie;

use PHPixie\Slice\Data;

class Slice
{
    public function iterator(Slice\Data $data) : Slice\Iterator
    {
        return new Slice\Iterator($data);
    }

    public function slice(Data $data, ?string $path = null) : Slice\Type\Slice
    {
        return new Slice\Type\Slice($this, $data, $path);
    }

    public function editableSlice(Data $data, ?string $path = null) : Slice\Type\Slice\Editable
    {
        return new Slice\Type\Slice\Editable($this, $data, $path);
    }

    public function arrayData(?array $data = null) : Slice\Type\ArrayData
    {
        return new Slice\Type\ArrayData($this, $data);
    }

    public function editableArrayData(?array $data = null) : Slice\Type\ArrayData\Editable
    {
        return new Slice\Type\ArrayData\Editable($this, $data);
    }

    public function mergeData(Slice\Data $baseData, Slice\Data $overrideData) : Slice\Type\Merge
    {
        return new Slice\Type\Merge($this, $baseData, $overrideData);
    }

    public function arraySlice(?array $data = null, ?string $path = null) : Slice\Type\ArrayData\Slice
    {
        return new Slice\Type\ArrayData\Slice($this, $data, $path);
    }
}
