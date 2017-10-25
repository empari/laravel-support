<?php namespace Empari\Laravel\Support\Http\Routing;

abstract class RouteFile
{
    /**
     * @var array
     */
    protected $options = [];


    /**
     * @var \Illuminate\Routing\Router
     */Laravel
    protected $router;

    /**
     * RouteFile constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $options;
        $this->router  = app('router');
    }

    /**
     * Register Routes
     */
    public function register()
    {
        $this->router->group($this->options, function() {
            $this->routes();
        });
    }

    /**
     * Define Routes
     */
    abstract protected function routes();
}