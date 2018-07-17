<?php

class MockTest extends \PHPUnit\Framework\TestCase
{
    public function testMock()
    {
        $behaviors = (new \Lxj\OneStepMock\Behaviors())->addOne(
            'test',
            [1,2],
            true
        );
        $mock_obj = \Lxj\OneStepMock\Mock::mock(
            '\Foo',
            $behaviors
        );

        $this->assertTrue($mock_obj->test(1, 2));
    }

    public function testNamedMockAlias()
    {
        include_once __DIR__ . '/stubs/Bar.php';

        \Lxj\OneStepMock\Mock::mock(
            '\Test',
            null,
            Bar::class,
            true
        );

        $this->assertEquals(Bar::TEST_C, \Test::TEST_C);
    }

    public function testMockProperties()
    {
        $mock_obj = \Lxj\OneStepMock\Mock::mock(
            '\Foo',
            null,
            '',
            false,
            ['test' => true]
        );

        $this->assertTrue($mock_obj->test);
    }
}
