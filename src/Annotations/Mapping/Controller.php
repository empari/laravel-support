<?php namespace Empari\Laravel\Support\Annotations\Mapping;

/**
 * Class Controller
 *
 * @Annotation
 * @Target("CLASS")
 * @package Empari\Laravel\Support\Annotations\Mapping
 */
class Controller
{
    public $name;
    public $description;
}