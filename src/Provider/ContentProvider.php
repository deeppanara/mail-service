<?php

namespace App\Provider;


class ContentProvider
{
    /**
     * @var Resource
     */
    private $resource;
    /**
     * @var \Twig\Environment
     */
    private $twigEnv;

    public function __construct()
    {
        $this->twigEnv = new \Twig\Environment(new \Twig\Loader\ArrayLoader([]), [
            'debug' => false,
            'charset' => 'UTF-8',
            'strict_variables' => false,
            'autoescape' => 'html',
            'cache' => getCacheDir()."/mail/twig",
            'auto_reload' => null,
            'optimizations' => -1,
        ]);
    }

    /**
     * Get twig env.
     */
    public function getTwigEnv()
    {
        return $this->twigEnv;
    }

    /**
     * Render twig.
     *
     * @param string $text
     * @param string $vars
     *
     * @return string
     */
    public function render($text, $vars)
    {

//        dump(file_get_contents((new \ReflectionClass($template->unwrap()))->getFileName() ,FALSE));

        $template = $this->twigEnv->createTemplate($text);
        $html = $template->render($vars);

        return $html;
    }
}
