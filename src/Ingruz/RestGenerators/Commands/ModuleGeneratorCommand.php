<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\ModuleGenerator;
use Symfony\Component\Console\Input\InputArgument;
//use Symfony\Component\Console\Input\InputOption;

class ModuleGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the scaffold files for a new module.';

    /**
     * Model generator instance.
     *
     * @var \Ingruz\RestGenerators\Generators\ModuleGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param ModuleGenerator $generator
     */
    public function __construct(ModuleGenerator $generator)
    {
        parent::__construct();

        $this->generator = $generator;
    }

    public function fire()
    {
        // Scaffolding should always begin with the singular
        // form of the now.
        $this->model = $this->argument('name');
//        $this->model = Pluralizer::singular($this->argument('name'));

//        $this->fields = $this->option('fields');

//        if (is_null($this->fields))
//        {
//            throw new MissingFieldsException('You must specify the fields option.');
//        }

        // We're going to need access to these values
        // within future commands. I'll save them
        // to temporary files to allow for that.
//        $this->cache->fields($this->fields);
//        $this->cache->modelName($this->model);

        $this->generator->buildCache($this->model);

//        $this->generateModel();
        $this->generateController();
        $this->generateRepository();
        $this->generateTransformer();
        $this->generateClientModel();
        $this->generateClientModule();
        $this->generateClientViews();
        $this->generateClientControllers();
        $this->generateClientTemplates();

//        if (get_called_class() === 'Way\\Generators\\Commands\\ScaffoldGeneratorCommand')
//        {
//            $this->generateTest();
//        }

        $this->generator->updateRoutesFile($this->model);
        $this->info('Updated ' . app_path() . '/routes.php');

        // We're all finished, so we
        // can delete the cache.
        $this->generator->emptyCache();
    }

    /**
     *
     */
    protected function generateModel()
    {
        $this->call(
            'restgenerators:generate:model',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     *
     */
    protected function generateController()
    {
        $this->call(
            'restgenerators:generate:controller',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     *
     */
    protected function generateRepository()
    {
        $this->call(
            'restgenerators:generate:repository',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     *
     */
    protected function generateTransformer()
    {
        $this->call(
            'restgenerators:generate:transformer',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     *
     */
    protected function generateClientModel()
    {
        $this->call(
            'restgenerators:generate:clientModel',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     *
     */
    protected function generateClientModule()
    {
        $this->call(
            'restgenerators:generate:clientModule',
            array(
                'name' => $this->model
            )
        );
    }


    /**
     *
     */
    protected function generateClientViews()
    {
        $this->call(
            'restgenerators:generate:clientViews',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     *
     */
    protected function generateClientControllers()
    {
        $this->call(
            'restgenerators:generate:clientControllers',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     *
     */
    protected function generateClientTemplates()
    {
        $this->call(
            'restgenerators:generate:clientTemplates',
            array(
                'name' => $this->model
            )
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the desired module.'),
        );
    }
}