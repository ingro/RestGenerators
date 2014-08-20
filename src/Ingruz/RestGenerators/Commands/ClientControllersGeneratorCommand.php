<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\ClientControllersGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ClientControllersGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:clientControllers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate client controllers file.';

    /**
     * Model generator instance.
     *
     * @var \Ingruz\RestGenerators\Generators\ClientControllersGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param ClientControllersGenerator $generator
     */
    public function __construct(ClientControllersGenerator $generator)
    {
        parent::__construct();

        $this->generator = $generator;
    }

    /**
     *
     */
    public function fire()
    {
        $path = $this->getPath();
        $template = $this->option('template');

        $this->printResult($this->generator->makeWithName($path, $template, $this->argument('name')), $path);
    }

    /**
     * Provide user feedback, based on success or not.
     *
     * @param  boolean $successful
     * @param  string $path
     * @return void
     */
    protected function printResult($successful, $path)
    {
        if ($successful)
        {
            return $this->info("Controllers created");
        }

        $this->error("Could not create Controllers");
    }

    /**
     * Get the path to the file that should be generated.
     *
     * @return string
     */
    protected function getPath()
    {
        $optionPath = $this->option('path');
        $path = (! empty($optionPath)) ? $this->option('path') : $this->laravel['config']->get('rest-generators::paths.clientControllers');

        return [
            'list' => $path . '/' . $this->argument('name') . '/list/' . 'list_controller.coffee',
            'edit' => $path . '/' . $this->argument('name') . '/edit/' . 'edit_controller.coffee',
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            array('name', InputArgument::REQUIRED, 'Name of the client module controllers to generate.'),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to the client module views directory.', ''),
            array('template', null, InputOption::VALUE_OPTIONAL, 'Path to templates.', $this->getTemplates())
        ];
    }

    protected function getTemplates()
    {
        return [
            'list' => __DIR__.'/../Generators/templates/frontend/moduleListController.twig',
            'edit' => __DIR__.'/../Generators/templates/frontend/moduleEditController.twig',
        ];
    }
}