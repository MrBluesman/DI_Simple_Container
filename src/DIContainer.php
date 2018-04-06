<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 06.04.18
 * Time: 23:10
 */

/**
 * Class DIContainer
 */
class DIContainer
{
    /**
     * @var array map storage of dependencies
     */
    private $depStorage;

    /**
     * Registers on dependency in the container
     * Creates an array with @value and optional @args, matches with the @key end stores
     * @param $key string identifier of the dependency in the map
     * @param $value object or primitive type to store in dependencies
     * @param $args array optional constructor arguments
     */
    public function register($key, $value, $args)
    {
        $this->addDependency($key, (object) array(
           "value" => $value,
            "args" => $args
        ));
    }

    /**
     * Helping method which only adds a dependency of object to the storage map
     * @param $key string identifier of the dependency in the map
     * @param $object object which dependency will be store in the @DIContainer
     */
    private function addDependency($key, $object)
    {
        //create a new array if depStorage is Empty
        if($this->depStorage === NULL) $this->depStorage = (object) array();
        $this->depStorage->$key = $object;
    }
}