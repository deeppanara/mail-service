<?php
if (! function_exists('app')) {
    function app($service = null)
    {
        if (is_null($service)) {
            return \App\Kernel::getContainerStatic();
        }

        return \App\Kernel::getContainerStatic()->get($service);
    }
}

if (! function_exists('request')) {
    function request()
    {
        return \App\Kernel::getContainerStatic()->get('request_stack')->getCurrentRequest();
    }
}
if (! function_exists('getCacheDir')) {
    function getCacheDir()
    {
        return \App\Kernel::getContainerStatic()->get( 'kernel' )->getCacheDir();
    }
}
if (! function_exists('getMailCacheDir')) {
    function getMailCacheDir()
    {
        return \App\Kernel::getContainerStatic()->get( 'kernel' )->getMailCacheDir();
    }
}
if (! function_exists('getLogDir')) {
    function getLogDir()
    {
        return \App\Kernel::getContainerStatic()->get( 'kernel' )->getLogDir();
    }
}
if (! function_exists('getProjectDir')) {
    function getProjectDir()
    {
        return \App\Kernel::getContainerStatic()->get( 'kernel' )->getProjectDir();
    }
}