<?php namespace Empari\Laravel\Support\Annotations\Mapping;

/**
 * Class Action
 *
 * @Annotation
 * @Target("METHOD")
 * @package Empari\Laravel\Support\Annotations\Mapping
 */
class Action
{
    public $name;
    public $description;
}