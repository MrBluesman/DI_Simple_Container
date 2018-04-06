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
     * Creates an array with $value and optional $args, matches with the $key end stores
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
     * @param $key string identifier    of the dependency in the map
     * @param $object object which dependency will be store in the @DIContainer
     */
    private function addDependency($key, $object)
    {
        //create a new array if depStorage is Empty
        if($this->depStorage === NULL) $this->depStorage = (object) array();
        $this->depStorage->$key = $object;
    }

    /**
     * Gets an instance of stored dependency
     * @param $key string identifier if the dependency in the map
     * @return object dependency identified by @key
     * @throws ReflectionException
     * @throws Exception
     */
    public function get($key)
    {
        //Check if the key exist
        if(!array_key_exists($key, $this->depStorage))
        {
            throw new Exception("DIContainer: '".$key."' doesn't exist in the container.");
        }
        else
        {
            //get inform from depStorage array
            $className = $this->depStorage->$key->value;
            $args = $this->depStorage->$key->args;

            //only if class exists we can make a instance of ReflectionClass to return
            if(class_exists($className))
            {
                $reflection = new ReflectionClass($className);

                //class with args or without args
                if($args === NULL || count($args) == 0)
                {
                    $objectToReturn = new $className;
                }
                else
                {
                    if(!is_array($args)) $args = array($args);
                    $objectToReturn = $reflection->newInstanceArgs($args);
                }
            }
            else $objectToReturn = $this->depStorage->$key->value;
        }
        return $objectToReturn;
    }

    /**
     * depStorage getter
     * @return array of dependencies
     */
    public function getDepStorage()
    {
        return $this->depStorage;
    }

    /**
     * depStorage setter
     * @param array $depStorage new dependencies to replace with previous
     */
    public function setDepStorage($depStorage)
    {
        $this->depStorage = $depStorage;
    }
}