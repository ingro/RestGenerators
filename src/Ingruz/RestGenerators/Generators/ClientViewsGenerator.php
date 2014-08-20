<?php
namespace Ingruz\RestGenerators\Generators;

use Twig_Environment;
use Twig_Loader_String;

class ClientViewsGenerator extends BaseGenerator {

    /**
     * Fetch the compiled template for a model
     *
     * @param  string $template Path to template
     * @param  string $className
     * @return string Compiled template
     */
    protected function getTemplate($template, $className)
    {
        $this->template = $this->file->get($template);

        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader);

        /*if ($this->needsScaffolding($template))
        {
            $this->template = $this->getScaffoldedModel($className);
        }*/

        return $twig->render($this->template, ['className' => $className]);

        //return str_replace('{{className}}', $className, $this->template);
    }

    protected function getBaseName($path)
    {
        return basename($path, '_views.coffee');
    }
}