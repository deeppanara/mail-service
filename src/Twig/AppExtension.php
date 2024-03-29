<?php

namespace App\Twig;

use App\Provider\ResourceProvider;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $container;
    private $kernel;
    private $requestStack;
    private $router;
    private $resourceProvider;

    public function __construct(ContainerInterface $container, KernelInterface $kernel, RequestStack $requestStack, RouterInterface $router, ResourceProvider $resourceProvider)
    {
        $this->container = $container;
        $this->kernel = $kernel;
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->resourceProvider = $resourceProvider;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this, 'getAssetPath']),
            new TwigFunction('gitVersion', [$this, 'gitVersion']),
            new TwigFunction('groups_list', [$this, 'gitGroups']),
//            new TwigFunction('configration', [$this, 'getConfigration']),
        ];
    }
    public function getFilters()
    {
        return [
            new TwigFilter('format_time', [$this, 'FormatTime']),
            new TwigFilter('format_mail', [$this, 'formatMail']),
        ];
    }

    public function FormatTime($timestemp)
    {
        if (Carbon::createFromTimestamp($timestemp)->diffInHours(Carbon::now()) < 24) {
            return Carbon::createFromTimestamp($timestemp)->format('h:i A');
        } else {
            return Carbon::createFromTimestamp($timestemp)->format('d M');
        }
    }

    public function formatMail($mails, $saprator = ', ')
    {
        if(array_key_exists('email',$mails)) {
            $mails = [$mails];
        }

        $formated = [];
        foreach ($mails as $mail) {
            $formated[] = sprintf("%s <%s>", $mail['name'], $mail['email']);
        }

        return implode($saprator, $formated) ?? null;
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
    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function gitGroups()
    {
        return $this->resourceProvider->getGropListForSidebar();
    }
}
