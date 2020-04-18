<?php

namespace App\Twig\Admin;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $container;
    private $kernel;
    private $requestStack;
    private $router;

    public function __construct(ContainerInterface $container, KernelInterface $kernel, RequestStack $requestStack, RouterInterface $router)
    {
        $this->container = $container;
        $this->kernel = $kernel;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this, 'getAssetPath']),
            new TwigFunction('gitVersion', [$this, 'gitVersion']),
//            new TwigFunction('configration', [$this, 'getConfigration']),
        ];
    }

    public function getAssetPath(string $path): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $uri = $request->getSchemeAndHttpHost();
        return $uri.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.trim(trim($path), '/');
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function gitVersion()
    {
        return exec('git log -n1 --pretty=format:"%h (updated %ar)"');
    }
}
