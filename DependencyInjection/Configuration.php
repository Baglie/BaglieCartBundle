<?php

namespace Baglie\CartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('baglie_cart');

        $rootNode
            ->children()
                ->scalarNode('jcartPath')->end()
                ->scalarNode('checkoutPath')->end()
                ->scalarNode('item')
                    ->scalarNode('id')->end()
                    ->scalarNode('name')->end()
                    ->scalarNode('price')->end()
                    ->scalarNode('qty')->end()
                    ->scalarNode('url')->end()
                    ->scalarNode('add')->end()
                ->end()
                ->scalarNode('paypal')
                    ->scalarNode('id')->end()
                    ->scalarNode('https')->end()
                    ->scalarNode('sandbox')->end()
                    ->scalarNode('returnUrl')->end()
                    ->scalarNode('notifyUrl')->end()
                ->end()
                ->scalarNode('currencyCode')->end()
                ->scalarNode('csrfToken')->end()
                ->scalarNode('text')
                    ->scalarNode('cartTitle')->end()
                    ->scalarNode('singleItem')->end()
                    ->scalarNode('multipleItems')->end()
                    ->scalarNode('subtotal')->end()
                    ->scalarNode('update')->end()
                    ->scalarNode('checkout')->end()
                    ->scalarNode('checkoutPaypal')->end()
                    ->scalarNode('removeLink')->end()
                    ->scalarNode('emptyButton')->end()
                    ->scalarNode('emptyMessage')->end()
                    ->scalarNode('itemAdded')->end()
                    ->scalarNode('priceError')->end()
                    ->scalarNode('quantityError')->end()
                    ->scalarNode('checkoutError')->end()
                ->end()
                ->scalarNode('button')
                    ->scalarNode('checkout')->end()
                    ->scalarNode('paypal')->end()
                    ->scalarNode('update')->end()
                    ->scalarNode('empty')->end()
                ->end()
                ->scalarNode('tooltip')->end()
                ->scalarNode('decimalQtys')->end()
                ->scalarNode('decimalPlaces')->end()
                ->scalarNode('priceFormat')
                    ->scalarNode('decimals')->end()
                    ->scalarNode('dec_point')->end()
                    ->scalarNode('thousands_sep')->end()
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
