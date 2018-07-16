<?php

namespace Lxj\OneStepMock;

use Mockery as M;

class Mock
{
    /**
     * Mock class or object
     *
     * @param  $class
     * @param  Behaviors|null $behaviors
     * @param  string         $named_mock_class
     * @param  bool           $is_alias
     * @param  array          $properties
     * @param  null           $mock_obj
     * @return M\MockInterface
     */
    public static function mock(
        $class,
        ?Behaviors $behaviors = null,
        $named_mock_class = '',
        $is_alias = false,
        $properties = [],
        $mock_obj = null
    ) {
        if ($is_alias) {
            $class = 'alias:' . $class;
        }

        if (is_null($mock_obj)) {
            if ($named_mock_class) {
                $mock_obj = M::mock($class, $named_mock_class);
            } else {
                $mock_obj = M::mock($class);
            }
        }

        //Mock properties of instance
        if (!$is_alias) {
            if (is_null($behaviors)) {
                $behaviors = new Behaviors();
            }
            foreach ($properties as $property_name => $property_value) {
                $behaviors->addOne('__get', [$property_name], $property_value);
            }
        }

        if (!is_null($behaviors)) {
            foreach ($behaviors as $behavior) {
                $mock = $mock_obj->shouldReceive($behavior['method']);
                if (isset($behavior['args'])) {
                    $mock = $mock->withArgs($behavior['args']);
                }
                if (isset($behavior['return'])) {
                    if (is_callable($behavior['return'])) {
                        $mock->andReturnUsing($behavior['return']);
                    } else {
                        $mock->andReturn($behavior['return']);
                    }
                }
                if (isset($behavior['times'])) {
                    $mock->times($behavior['times']);
                }
            }
        }

        return $mock_obj;
    }
}
