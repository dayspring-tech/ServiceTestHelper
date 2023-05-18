<?php
namespace Dayspring\ServiceTestHelper\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function getRootDir()
    {
        return __DIR__.'/Resources';
    }
    public function registerBundles()
    {
        return array(
        );
    }
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/Resources/config/config_test.yml');
        if (class_exists('Symfony\Component\Asset\Package')) {
            $loader->load(function (ContainerBuilder $container) {
                $container->loadFromExtension('framework', array('assets' => array()));
            });
        }
    }
}
