<?php
/**
 * links 1: https://www.digitalocean.com/community/conceptual-articles/s-o-l-i-d-the-first-five-principles-of-object-oriented-design
 * links 2: https://accesto.com/blog/solid-php-solid-principles-in-php/
 * Open-closed Principle (OCP) states:
 * Objects or entities should be open for extension but closed for modification.
 * This means that a class should be extendable without modifying the class itself.
 */

 /**
  * let’s revisit the AreaCalculator class and focus on the sum method:
  */

    class AreaCalculator
    {
        protected $shapes;

        public function __construct($shapes = [])
        {
            $this->shapes = $shapes;
        }

        public function sum()
        {
            foreach ($this->shapes as $shape) {
                if (is_a($shape, 'Square')) {
                    $area[] = pow($shape->length, 2);
                } elseif (is_a($shape, 'Circle')) {
                    $area[] = pi() * pow($shape->radius, 2);
                }
            }

            return array_sum($area);
        }
    }

    /**
     * Consider a scenario where the user would like the sum of additional shapes like triangles,
     *  pentagons, hexagons, etc. 
     *  You would have to constantly edit this file and add more if/else blocks.
     *  That would violate the open-closed principle.
     */
    /**
     * A way you can make this sum method better is to remove the logic to calculate the area of
     * each shape out of the AreaCalculator class method and attach it to each shape’s class.
     */
    class Square
    {
        public $length;
    
        public function __construct($length)
        {
            $this->length = $length;
        }
    
        public function area()
        {
            return pow($this->length, 2);
        }
    }

    class Circle
    {
        public $radius;

        public function construct($radius)
        {
            $this->radius = $radius;
        }

        public function area()
        {
            return pi() * pow($shape->radius, 2);
        }

    }
class AreaCalculator
{
    // ...

    public function sum()
    {
        foreach ($this->shapes as $shape) {
            $area[] = $shape->area();
        }

        return array_sum($area);
    }
}
//Now, you can create another shape class and pass it in when calculating the sum without breaking the code.

/**
 * However, another problem arises.
 *  How do you know that the object passed into the AreaCalculator is actually 
 * a shape or if the shape has a method named area?
 * Coding to an interface is an integral part of SOLID.
 */

//Create a ShapeInterface that supports area:
interface ShapeInterface
{
    public function area();
}

//Modify your shape classes to implement the ShapeInterface.
class Square implements ShapeInterface
{
    // ...
}
class Circle implements ShapeInterface
{
    // ...
}
/**
 * In the sum method for AreaCalculator, you can check
 * if the shapes provided are actually instances of the ShapeInterface; otherwise, throw an exception:
 */

class AreaCalculator
{
    // ...

    public function sum()
    {
        foreach ($this->shapes as $shape) {
            if (is_a($shape, 'ShapeInterface')) {
                $area[] = $shape->area();
                continue;
            }

            throw new AreaCalculatorInvalidShapeException();
        }

        return array_sum($area);
    }
}
//That satisfies the open-closed principle.
?>