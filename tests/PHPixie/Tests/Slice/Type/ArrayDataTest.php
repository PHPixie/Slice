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
        $mock = $this->sliceDataMock(array('arraySlice'));
        
        foreach(array(true, false) as $withPath) {
            $path = $withPath ? 'pixie' : null;
            
            $slice = $this->getArraySlice();
            $this->method($mock, 'arraySlice', $slice, array($path), 0);
            
            $args = array();
            if($withPath) {
                $args[]= $path;
            }
            $result = call_user_func_array(array($mock, 'slice'), $args);
            $this->assertSame($slice, $result);
        }
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
    
    /**
     * @covers ::getIterator
     * @covers ::<protected>
     */
    public function testIterator()
    {
        $iterator = $this->sliceData->getIterator();
        $this->assertInstance($iterator, '\ArrayIterator');
        $this->assertSame($this->data, $iterator->getArrayCopy());
    }
    
    protected function sliceData()
    {
        return new \PHPixie\Slice\Type\ArrayData(
            $this->sliceBuilder,
            $this->data
        );
    }
    
    protected function sliceDataMock($methods = null)
    {
        return $this->getMock(
            '\PHPixie\Slice\Type\ArrayData',
            $methods,
            array(
                $this->sliceBuilder,
                $this->data
            )
        );
    }
}
