<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\ClientTemplatesGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ClientTemplatesGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:clientTemplates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate client templates file.';

    /**
     * Model generator instance.
     *
     * @var Ingruz\RestGenerators\Generators\ClientTemplatesGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param ClientTemplatesGenerator $generator
     */
    public function __construct(ClientTemplatesGenerator $generator)
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
            return $this->info("Templates created");
        }

        $this->error("Could not create Templates");
    }

    /**
     * Get the path to the file that should be generated.
     *
     * @return string
     */
    protected function getPath()
    {
        $optionPath = $this->option('path');
        $path = (! empty($optionPath)) ? $this->option('path') : $this->laravel['config']->get('rest-generators::paths.clientTemplates');

        return [
            'listLayout' => $path . '/' . $this->argument('name') . '/templates/' . 'list_layout.html',
            'grid' => $path . '/' . $this->argument('name') . '/templates/' . 'grid.html',
            'row' => $path . '/' . $this->argument('name') . '/templates/' . '_row.html',
            'editLayout' => $path . '/' . $this->argument('name') . '/templates/' . 'edit_layout.html',
            'title' => $path . '/' . $this->argument('name') . '/templates/' . '_title.html',
            'edit' => $path . '/' . $this->argument('name') . '/templates/' . 'edit.html',
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
            'listLayout' => __DIR__.'/../Generators/templates/frontend/viewTemplates/listLayout.twig',
            'grid' => __DIR__.'/../Generators/templates/frontend/viewTemplates/grid.twig',
            'row' => __DIR__.'/../Generators/templates/frontend/viewTemplates/row.twig',
            'editLayout' => __DIR__.'/../Generators/templates/frontend/viewTemplates/editLayout.twig',
            'title' => __DIR__.'/../Generators/templates/frontend/viewTemplates/title.twig',
            'edit' => __DIR__.'/../Generators/templates/frontend/viewTemplates/edit.twig',
        ];
    }
}