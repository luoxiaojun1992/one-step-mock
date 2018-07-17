<?php

class MockTest extends \PHPUnit\Framework\TestCase
{
    public function testMock()
    {
        require_once __DIR__ . '/stubs/Foo.php';

        $behaviors = (new \Lxj\OneStepMock\Behaviors())->addOne(
            'test',
            [1,2],
            true
        );
        $mock_obj = \Lxj\OneStepMock\Mock::mock(
            Foo::class,
            $behaviors
        );

        $this->assertTrue($mock_obj->test(1, 2));
    }
}
