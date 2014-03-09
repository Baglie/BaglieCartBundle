<?php

namespace Baglie\CartBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BaglieCartExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('baglie_cart.jcartPath', $config['jcartPath']);
        $container->setParameter('baglie_cart.checkoutPath', $config['checkoutPath']);
        $container->setParameter('baglie_cart.item', $config['item']);
        $container->setParameter('baglie_cart.paypal', $config['paypal']);
        $container->setParameter('baglie_cart.currencyCode', $config['currencyCode']);
        $container->setParameter('baglie_cart.csrfToken', $config['csrfToken']);
        $container->setParameter('baglie_cart.text', $config['text']);
        $container->setParameter('baglie_cart.button', $config['button']);
        $container->setParameter('baglie_cart.tooltip', $config['tooltip']);
        $container->setParameter('baglie_cart.decimalQtys', $config['decimalQtys']);
        $container->setParameter('baglie_cart.decimalPlaces', $config['decimalPlaces']);
        $container->setParameter('baglie_cart.priceFormat', $config['priceFormat']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
