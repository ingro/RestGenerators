<?php namespace Ingruz\RestGenerators;

use Illuminate\Support\ServiceProvider;

class RestGeneratorsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('ingruz/rest-generators');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerModuleGenerator();
       	// $this->registerModelGenerator();
        $this->registerControllerGenerator();
        $this->registerRepositoryGenerator();
        $this->registerTransformerGenerator();
        $this->registerClientModelGenerator();
        $this->registerClientModuleGenerator();
        $this->registerClientViewsGenerator();
        $this->registerClientControllersGenerator();
        $this->registerClientTemplatesGenerator();

        $this->commands(
            'restgenerators.generate.module',
            // 'restgenerators.generate.model',
            'restgenerators.generate.controller',
            'restgenerators.generate.repository',
            'restgenerators.generate.transformer',
            'restgenerators.generate.clientModel',
            'restgenerators.generate.clientModule',
            'restgenerators.generate.clientViews',
            'restgenerators.generate.clientControllers',
            'restgenerators.generate.clientTemplates'
        );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
     * Register restgenerators:generate:module
     *
     * @return Commands\ModuleGeneratorCommand
     */
    protected function registerModuleGenerator()
    {
        $this->app['restgenerators.generate.module'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ModuleGenerator($app['files'], $cache);

            return new Commands\ModuleGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:model
     *
     * @return Commands\ModelGeneratorCommand
     */
    /*protected function registerModelGenerator()
    {
        $this->app['restgenerators.generate.model'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ModelGenerator($app['files'], $cache);

            return new Commands\ModelGeneratorCommand($generator);
        });
    }*/

    /**
     * Register restgenerators:generate:controller
     *
     * @return Commands\ControllerGeneratorCommand
     */
    protected function registerControllerGenerator()
    {
        $this->app['restgenerators.generate.controller'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ControllerGenerator($app['files'], $cache);

            return new Commands\ControllerGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:controller
     *
     * @return Commands\RepositoryGeneratorCommand
     */
    protected function registerRepositoryGenerator()
    {
        $this->app['restgenerators.generate.repository'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\RepositoryGenerator($app['files'], $cache);

            return new Commands\RepositoryGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:transformer
     *
     * @return Commands\TransformerGeneratorCommand
     */
    protected function registerTransformerGenerator()
    {
        $this->app['restgenerators.generate.transformer'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\TransformerGenerator($app['files'], $cache);

            return new Commands\TransformerGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:clientModel
     *
     * @return Commands\ClientModelGeneratorCommand
     */
    protected function registerClientModelGenerator()
    {
        $this->app['restgenerators.generate.clientModel'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ClientModelGenerator($app['files'], $cache);

            return new Commands\ClientModelGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:clientModule
     *
     * @return Commands\ClientModuleGeneratorCommand
     */
    protected function registerClientModuleGenerator()
    {
        $this->app['restgenerators.generate.clientModule'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ClientModuleGenerator($app['files'], $cache);

            return new Commands\ClientModuleGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:clientViews
     *
     * @return Commands\ClientViewsGeneratorCommand
     */
    protected function registerClientViewsGenerator()
    {
        $this->app['restgenerators.generate.clientViews'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ClientViewsGenerator($app['files'], $cache);

            return new Commands\ClientViewsGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:clientControllers
     *
     * @return Commands\ClientControllersGeneratorCommand
     */
    protected function registerClientControllersGenerator()
    {
        $this->app['restgenerators.generate.clientControllers'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ClientControllersGenerator($app['files'], $cache);

            return new Commands\ClientControllersGeneratorCommand($generator);
        });
    }

    /**
     * Register restgenerators:generate:clientTemplates
     *
     * @return Commands\ClientTemplatesGeneratorCommand
     */
    protected function registerClientTemplatesGenerator()
    {
        $this->app['restgenerators.generate.clientTemplates'] = $this->app->share(function($app)
        {
            $cache = new Cache($app['files']);
            $generator = new Generators\ClientTemplatesGenerator($app['files'], $cache);

            return new Commands\ClientTemplatesGeneratorCommand($generator);
        });
    }


}
