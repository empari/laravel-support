<?php namespace Empari\Laravel\Support\Providers;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\FilesystemCache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\AliasLoader;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Module Name
     * @var string
     */
    protected $moduleName = 'empari-support';
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->publishMigrationsAndSeeders();
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAnnotations();
        $this->registerAliases();
    }
    protected function registerAliases()
    {
        // Packages
        // AliasLoader::getInstance()->alias('NavBarAuth', \Empari\Support\Facade\NavBarAuthorizationFacade::class);
    }
    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path($this->moduleName .'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', $this->moduleName
        );
    }
    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/vendor/empari/'. $this->moduleName);
        $sourcePath = __DIR__.'/../../resources/views';
        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/vendor/empari/'. $this->moduleName;
        }, \Config::get('view.paths')), [$sourcePath]), $this->moduleName);
    }
    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/vendor/empari/'. $this->moduleName);
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleName);
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../../resources/lang', $this->moduleName);
        }
    }
    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/database/factories');
        }
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
    /**
     * Register Annotations
     */
    public function registerAnnotations()
    {
        $loader = require base_path() .'/vendor/autoload.php';
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);
        $this->registerAnnotationReader();
    }
    /**
     * Register Annotations Reader
     */
    public function registerAnnotationReader()
    {
        $this->app->bind(Reader::class, function () {
            return new CachedReader(
                new AnnotationReader(),
                new FilesystemCache(storage_path('framework/cache/doctrine-annotations')),
                $debug = config('app.debug')
            );
        });
    }
    /**
     * Register all migrations and seeders
     *
     */
    public function publishMigrationsAndSeeders()
    {
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            __DIR__.'/../../database/seeders' => database_path('seeds')
        ], 'seeders');
    }
}