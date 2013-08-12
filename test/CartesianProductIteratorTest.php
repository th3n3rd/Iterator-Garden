<?php
/**
 * Iterator Garden
 */

class CartesianProductIteratorTest extends IteratorTestCase
{
    public function testConstructor()
    {
        $it = new CartesianProductIterator();
        $this->assertInstanceOf('CartesianProductIterator', $it);
    }

    public function productsProvider()
    {
        return array(
            array(
                NULL,
                array(
                    array(0, 1),
                    array(2, 3),
                ),
                array(
                    array(0, 2),
                    array(0, 3),
                    array(1, 2),
                    array(1, 3),
                ),
            ),
            array(
                CartesianProductIterator::ORDER_LAST_FIRST,
                array(
                    array(0, 1),
                    array(2, 3),
                ),
                array(
                    array(0, 2),
                    array(0, 3),
                    array(1, 2),
                    array(1, 3),
                ),
            ),
            array(
                CartesianProductIterator::ORDER_FIRST_FIRST,
                array(
                    array(0, 1),
                    array(2, 3),
                ),
                array(
                    array(0, 2),
                    array(1, 2),
                    array(0, 3),
                    array(1, 3),
                ),
            ),
            array(
                NULL,
                array(
                    array(0, 1),
                    array(2),
                ),
                array(
                    array(0, 2),
                    array(1, 2),
                ),
                array(
                    array(0, 0),
                    array(1, 0),
                ),
            ),
        );
    }

    /**
     * @dataProvider productsProvider
     */
    public function testIteration($orderMode, $arrays, $expected, $expectedKeys = NULL)
    {
        $actual = new CartesianProductIterator($orderMode);

        foreach ($arrays as $array) {
            $actual->append(new ArrayIterator($array));
        }

        $this->assertIterationValues($expected, $actual);

        if ($expectedKeys) {
            $actual->rewind();
            $this->assertIterationKeys($expectedKeys, $actual);
        }

    }

    public function testGetArrayIterator()
    {
        $it = new CartesianProductIterator();
        $it->append($inner[] = new ArrayIterator(range(0, 2)));
        $it->append($inner[] = new ArrayIterator(range(3, 5)));

        $actual = $it->getArrayIterator();
        $this->assertInstanceOf('ArrayIterator', $actual);
        $this->assertCount(2, $actual);

        $this->assertSame($inner[0], $actual[0]);
        $this->assertSame($inner[1], $actual[1]);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function invalidSortModeThrowsException()
    {
        $it = new CartesianProductIterator(42);
    }

    /**
     * @test
     */
    public function finalNextDoesNotRewindAllIterators()
    {
        $iterator = new DebugCountingIteratorDecorator(new ArrayIterator([1]));
        $subject  = new CartesianProductIterator();
        $subject->append(new ArrayIterator([1, 2]));
        $subject->append($iterator);

        $this->assertEquals(2, iterator_count($subject));
        $this->assertEquals(2, $iterator->getRewindCount());
    }
}
