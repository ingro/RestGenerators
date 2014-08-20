<?php
namespace Ingruz\RestGenerators\Generators;

use Config;

class TransformerGenerator extends BaseGenerator {

    /**
     * Fetch the compiled template for a transformer
     *
     * @param  string $template Path to template
     * @param  string $className
     * @return string Compiled template
     */
    protected function getTemplate($template, $className)
    {
        $this->template = $this->file->get($template);

        $loader = new \Twig_Loader_String();

        $twig = new \Twig_Environment($loader);

        $namespace = Config::get('rest::namespace');

        /*if ($this->needsScaffolding($template))
        {
            $this->template = $this->getScaffoldedModel($className);
        }*/

        $fields = $this->cache->getFields();

        return $twig->render($this->template, [
            'className' => $className,
            'fields' => $fields,
            'namespace' => $namespace
        ]);

        //return str_replace('{{className}}', $className, $this->template);
    }

    protected function getBaseName($path)
    {
        return basename($path, 'Transformer.php');
    }
}