<?php namespace Epoch2\Ez;

trait Setters
{
    /**
    * Map a call to set a property to its corresponding mutator if it exists.
    * Otherwise, set the property directly.
    *
    * Ignore any properties that begin with an underscore so not all of our
    * protected properties are exposed.
    *
    * @param  string $name
    * @param  mixed  $value
    * @return void
    * @throws \LogicException If no mutator/property exists by that name
    */
   public function __set($name, $value)
    {
        if ($name[0] != '_') {
            $mutator = 'set'. ucfirst($name);
            if (method_exists($this, $mutator)) {
                $this->$mutator($value);
                return;
            }

            if (property_exists($this, $name)) {
                $this->$name = $value;
                return;
            }
        }

        throw new \LogicException(sprintf(
            'No property named `%s` exists',
            $name
        ));
    }

    /**
     * Map a call to a non-existent mutator or accessor directly to its
     * corresponding property
     *
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     * @throws \BadMethodCallException If no mutator/accessor can be found
     */
    public function __call($name, $arguments)
    {
        if (strlen($name) > 3) {
            if (strpos($name, 'set') === 0) {
                $property = lcfirst(substr($name, 3));

                $this->$property = array_shift($arguments);
                return $this;
            }

            if (0 === strpos($name, 'get')) {
                $property = lcfirst(substr($name, 3));

                return $this->$property;
            }
        }

        throw new \BadMethodCallException(sprintf(
            'No method named `%s` exists',
            $name
        ));
    }
}

