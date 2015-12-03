<?php

namespace Moodle\BehatExtension;

use Symfony\Component\Config\FileLocator,
    Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

use Behat\Behat\Extension\ExtensionInterface;


/**
 * Behat extension for moodle
 *
 * Provides multiple features directory loading (Gherkin\Loader\MoodleFeaturesSuiteLoader
 */
class Extension implements ExtensionInterface
{

    /**
     * Loads moodle specific configuration.
     *
     * @param array            $config    Extension configuration hash (from behat.yml)
     * @param ContainerBuilder $container ContainerBuilder instance
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/services'));
        $loader->load('core.xml');

        // Getting the extension parameters.
        $container->setParameter('behat.moodle.parameters', $config);

        // Adding moodle formatters to the list of supported formatted.
        if (isset($config['formatters'])) {
            $container->setParameter('behat.formatter.classes', $config['formatters']);
        }
    }

    /**
     * Setups configuration for current extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function getConfig(ArrayNodeDefinition $builder)
    {
        $builder->
            children()->
                arrayNode('capabilities')->
                    useAttributeAsKey('key')->
                    prototype('variable')->end()->
                end()->
                arrayNode('features')->
                    useAttributeAsKey('key')->
                    prototype('variable')->end()->
                end()->
                arrayNode('steps_definitions')->
                    useAttributeAsKey('key')->
                    prototype('variable')->end()->
                end()->
                arrayNode('formatters')->
                    useAttributeAsKey('key')->
                    prototype('variable')->end()->
                end()->

            end()->
        end();
    }

    /**
     * Returns compiler passes used by this extension.
     *
     * @return array
     */
    public function getCompilerPasses()
    {
        return array();
    }

}
