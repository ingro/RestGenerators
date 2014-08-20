<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\ModelGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModelGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a model file.';

    /**
     * Model generator instance.
     *
     * @var Ingruz\RestGenerators\Generators\ModelGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param ModelGenerator $generator
     */
    public function __construct(ModelGenerator $generator)
    {
        parent::__construct();

        $this->generator = $generator;
    }

    /**
     * Get the path to the file that should be generated.
     *
     * @return string
     */
    protected function getPath()
    {
        return $this->option('path') . '/' . ucwords($this->argument('name')) . '.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the model to generate.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to the models directory.', app_path() . '/models'),
            array('template', null, InputOption::VALUE_OPTIONAL, 'Path to template.', __DIR__.'/../Generators/templates/backend/model.twig')
        );
    }
}