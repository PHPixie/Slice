<?php

namespace PHPixie\Tests\Slice\Type;

/**
 * @coversDefaultClass \PHPixie\Slice\Type\ArrayData
 */
class ArrayDataTest extends \PHPixie\Tests\Slice\Data\ImplementationTest
{
    protected $data = array(
        'meadows' => 5,
        'meadow' => array(
            'grass_type' => 6,
            'fairies' => array(
                'names' => array('Tinkerbell')
            ),
            'trees' => array(
                'oak' => array(
                    'fairy' => array('Trixie')
                )
            )
        ),
        'lake' => array(
            'mermaids' => array(
                            'names' => array('Naiad')
                        )
        )
    );
    
    protected $sliceMethod = 'slice';
    
    /**
     * @covers ::slice
     * @covers ::<protected>
     */
    public function testSlice()
    {
        $slice = $this->getSlice();
        
        $this->method($this->sliceBuilder, $this->sliceMethod, $slice, array($this->sliceData, null), 0);
        $this->assertSame($slice, $this->sliceData->slice());
        
        $this->method($this->sliceBuilder, $this->sliceMethod, $slice, array($this->sliceData, 'pixie'), 0);
        $this->assertSame($slice, $this->sliceData->slice('pixie'));
    }
    
    /**
     * @covers ::keys
     * @covers ::<protected>
     */
    public function testKeys()
    {
        $this->assertSame(array('meadows', 'meadow', 'lake'), $this->sliceData->keys());
        $this->assertSame(array('names'), $this->sliceData->keys('meadow.fairies'));
        $this->assertSame(array(), $this->sliceData->keys('meadow.fairies.pixie'));
        
        $sliceData = $this->sliceData;
        $this->assertSliceException(function () use($sliceData) {
            $sliceData->keys('meadow.fairies.pixie', true);
        });
    }
    
   protected function prepareGetDataSets()
    {
        $sets = array();
        
        $sets[] = array('get', array(), $this->data);
        $sets[] = array('get', array('meadows'), 5);
        $sets[] = array('getRequired', array('meadow.grass_type'), 6);
        
        $sets[] = array('getRequired', array('lake.mermaids'), array('names' => array('Naiad')));
        $sets[] = array('get', array('meadow'), array(
            'grass_type' => 6,
            'fairies' => array(
                'names' => array('Tinkerbell')
            ),
            'trees' => array(
                'oak' => array(
                    'fairy' => array('Trixie')
                )
            )
        ));
        
        $sets[] = array('get', array('meadow.trees.oak.fairy.0'), 'Trixie');
        
        $sets[] = array('get', array('meadow.grass_type.pixies', 'test'), 'test');
        $sets[] = array('getRequired', array('meadow.grass_type.pixies'), 'exception');
        $sets[] = array('getRequired', array('meadow.grass_type.pixies.name'), 'exception');
        
        return $sets;
    }
    
    protected function sliceData()
    {
        return new \PHPixie\Slice\Type\ArrayData($this->sliceBuilder, $this->data);
    }
}