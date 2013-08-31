<?php
/*
 * Copyright 2013 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Exeu\ApaiIOBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('exeu_apai_io');
        $rootNode
            ->children()
                ->scalarNode('accesskey')
                    ->isRequired()
                ->end()
                ->scalarNode('secretkey')
                    ->isRequired()
                ->end()
                ->scalarNode('country')
                    ->isRequired()
                ->end()
                ->scalarNode('associatetag')
                    ->isRequired()
                ->end()
                ->scalarNode('request')
                ->end()
                ->scalarNode('response')
                ->end()
             ->end()
        ->end();

        return $treeBuilder;
    }
}
