<?php namespace Epoch2\Ez;

/**
 * Created by Johan Vester
 * johan@jvester.se
 *
 * Date: 21/03/16
 */

trait Accessors
{
    // Avoid colliding __call method
    use Getters, Setters {
        Getters::__call insteadof Setters;
    }
}
