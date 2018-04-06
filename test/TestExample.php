<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 06.04.18
 * Time: 23:48
 */

require_once("../src/DIContainer.php");
/**
 * Test class A
 */
class A
{
    private $val1;

    public function __construct(String $val1)
    {
        $this->val1 = $val1;
    }

    public function getVal1()
    {
        return $this->val1;
    }

    public function sayHelloA()
    {
        return "From class A";
    }
}

/**
 * Test class B
 */
class B
{
    private $classA;

    public function __construct($classA)
    {
        //injection
        $this->classA = $classA;
    }

    public function sayHelloB()
    {
        return "From class B and I have arg (" . $this->classA->sayHelloA() .")";
    }


    public function getClassA()
    {
        return $this->classA;
    }
}

/**
 * Test class C
 */
class C
{
    private $classB;
    private $val1;

    public function __construct($classB, $val1)
    {
        //injection
        $this->classB = $classB;
        $this->val1 = $val1;
    }

    public function sayHelloC()
    {
        return "From class C and i have arg (" . $this->classB->sayHelloB() . ")";
    }

    public function getValFromA()
    {
        return $this->classB->getClassA()->getVal1();
    }

    public function getVal1()
    {
        return $this->val1;
    }
}

//Define dependencies
$container = new DIContainer();
$container->register("a", "A", array("I'm value from A"));
$container->register("b", "B", array($container->get("a")));
$container->register("c", "C", array($container->get("b"), "I'm value from C"));

//Usage
$classA = $container->get("a");
print $classA->sayHelloA() . PHP_EOL . '<br />';
$classB = $container->get("b");
print $classB->sayHelloB() . PHP_EOL . '<br />';
$classC = $container->get("c");
print $classC->sayHelloC() . PHP_EOL . '<br />';
print PHP_EOL . '<br />';
print "classC->getVal1(): " . $classC->getVal1() . PHP_EOL . '<br />';
print "classC->getValFromA(): " . $classC->getValFromA() . PHP_EOL . '<br />';


