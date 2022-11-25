<?php
/**
 * Liskov Substitution Principle:
 * Liskov Substitution Principle states:
 * Let q(x) be a property provable about objects of x of type T.
 * Then q(y) should be provable for objects y of type S where S is a subtype of T.
 * This means that every subclass or derived class should be substitutable for their base or parent class.
 * Building off the example AreaCalculator class, 
 * consider a new VolumeCalculator class that extends the AreaCalculator class
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

class VolumeCalculator extends AreaCalculator
{
    public function construct($shapes = [])
    {
        parent::construct($shapes);
    }

    public function sum()
    {
        // logic to calculate the volumes and then return an array of output
        return [$summedData];
    }
}

class SumCalculatorOutputter {
    protected $calculator;

    public function __constructor(AreaCalculator $calculator) {
        $this->calculator = $calculator;
    }

    public function JSON() {
        $data = array(
            'sum' => $this->calculator->sum();
        );

        return json_encode($data);
    }

    public function HTML() {
        return implode('', array(
            '',
                'Sum of the areas of provided shapes: ',
                $this->calculator->sum(),
            ''
        ));
    }
}

$areas = new AreaCalculator($shapes);
$volumes = new VolumeCalculator($solidShapes);

$output = new SumCalculatorOutputter($areas);
$output2 = new SumCalculatorOutputter($volumes);
/** 
 * When you call the HTML method on the $output2 object,
 * you will get an E_NOTICE error informing you of an array to string conversion.
*/
/**
 * To fix this, 
 * instead of returning an array from the VolumeCalculator class sum method,
 * return $summedData:
 */

class VolumeCalculator extends AreaCalculator
{
    public function construct($shapes = [])
    {
        parent::construct($shapes);
    }

    public function sum()
    {
        // logic to calculate the volumes and then return a value of output
        return $summedData;
    }
}
/**
 * The $summedData can be a float, double or integer.
 * That satisfies the Liskov substitution principle.
 */
?>