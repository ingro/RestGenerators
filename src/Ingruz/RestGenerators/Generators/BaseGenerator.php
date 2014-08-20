<?php
namespace Ingruz\RestGenerators\Generators;

use Illuminate\Filesystem\Filesystem as File;
use Ingruz\RestGenerators\Cache;

abstract class BaseGenerator {

    /**
     * File path to generate
     *
     * @var string
     */
    public $path;

    /**
     * File system instance
     * @var File
     */
    protected $file;

    /**
     * Cache istance
     * @var \Ingruz\Generators\Cache
     */
    protected $cache;


    /**
     * Constructor
     *
     * @param File $file
     * @param Cache $cache
     */
    public function __construct(File $file, Cache $cache)
    {
        $this->file = $file;
        $this->cache = $cache;
    }

    /**
     * Compile template and generate file/s
     *
     * @param  string $path
     * @param  string $template Path to template
     * @return boolean
     */
    public function make($path, $template)
    {
        $this->name = $this->getBaseName($path);
        $this->path = $this->getPath($path);
        $template = $this->getTemplate($template, $this->name);

        if (! $this->file->exists($this->path))
        {
            if (! $this->file->isWritable($this->path))
            {
                if (! $this->file->isDirectory(dirname($this->path)))
                {
                    $this->file->makeDirectory(dirname($this->path));
                }
            }

            return $this->file->put($this->path, $template) !== false;
        }

        return false;
    }

    /**
     * Get the path to the file
     * that should be generated
     *
     * @param  string $path
     * @return string
     */
    protected function getPath($path)
    {
        // By default, we won't do anything, but
        // it can be overridden from a child class
        return $path;
    }

    /**
     * Determines whether the specified template
     * points to the scaffolds directory
     *
     * @param  string $template
     * @return boolean
     */
    protected function needsScaffolding($template)
    {
        return str_contains($template, 'scaffold');
    }

    /**
     * Get compiled template
     *
     * @param  string $template
     * @param  $name Name of file
     * @return string
     */
    abstract protected function getTemplate($template, $name);

    /**
     * @param $path
     * @return string
     */
    protected function getBaseName($path)
    {
        return basename($path, '.php');
    }
}