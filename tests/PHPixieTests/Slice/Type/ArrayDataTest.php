<?php

namespace PHPixieTests\Slice\Type;

/**
 * @coversDefaultClass \PHPixie\Slice\Type\ArrayData
 */
class ArrayDataTest extends \PHPixieTests\Slice\Data\ImplementationTest
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
    
    /**
     * @covers ::set
     * @covers ::<protected>
     */
    public function testSet()
    {
        $this->sliceData->set('meadow.grass_type', 8);
        $this->assertEquals(8, $this->sliceData-> get('meadow.grass_type'));
        $this->sliceData->set('meadow.trail.length', 8);
        $this->assertEquals(8, $this->sliceData-> get('meadow.trail.length'));
        $this->assertSliceException(function () {
            $this->sliceData-> set('meadow.grass_type.pixies', 8);
        });
        $this->sliceData->set('meadow', array(
            'grass_type' => 6,
            'fairies' => array(
                'names' => array('Pixie')
            )
        ));
        $this->assertEquals('Pixie', $this->sliceData->get('meadow.fairies.names.0'));
        $this->assertEquals(1, $this->sliceData-> get('meadow.trees.oak', 1));
        $this->sliceData->set(null, array('test' => 5));
        $this->assertEquals('5', $this->sliceData-> get('test'));
        
        $sliceData = $this->sliceData;
        $this->assertSliceException(function () use($sliceData) {
            $sliceData->set(null, 5);
        });
    }
    
    /**
     * @covers ::remove
     * @covers ::getData
     * @covers ::<protected>
     */
    public function testRemove()
    {
        $this->sliceData->remove('meadow.grass_type');
        $this->assertEquals('test', $this->sliceData->get('meadow.grass_type', 'test'));
        $this->sliceData->remove('meadow.fairies');
        $this->assertEquals('test', $this->sliceData->get('meadow.fairies,names', 'test'));
        $this->sliceData->remove();
        $this->assertEquals('test', $this->sliceData->get('meadow', 'test'));
        $this->assertEquals('test', $this->sliceData->get(null, 'test'));
        
        $sliceData = $this->sliceData;
        $this->assertSliceException(function () use($sliceData) {
            $sliceData->getRequired();
        });
    }
    
    /**
     * @covers ::slice
     * @covers ::<protected>
     */
    public function testSlice()
    {
        $slice = $this->getSlice();
        
        $this->method($this->sliceBuilder, 'editableSlice', $slice, array($this->sliceData, null), 0);
        $this->assertSame($slice, $this->sliceData->slice());
        
        $this->method($this->sliceBuilder, 'editableSlice', $slice, array($this->sliceData, 'pixie'), 0);
        $this->assertSame($slice, $this->sliceData->slice('pixie'));
    }
    
    /**
     * @covers ::remove
     * @covers ::getData
     * @covers ::<protected>
     */
    public function testRemoveCreate()
    {
        $this->sliceData->remove();
        $this->sliceData->set('meadow.grass_type', 8);
        $this->assertEquals(8, $this->sliceData-> get('meadow.grass_type'));
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