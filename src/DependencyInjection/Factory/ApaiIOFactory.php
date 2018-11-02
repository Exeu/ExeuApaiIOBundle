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

namespace Exeu\ApaiIOBundle\DependencyInjection\Factory;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use Psr\Container\ContainerInterface;

/**
 * A base factoryservice for creating new ApaiIO-Core instances
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ApaiIOFactory
{
    /**
     * Builds a new ApaiIO instance
     *
     * @param array $config The configuration
     *
     * @return \ApaiIO\ApaiIO
     */
    public static function get($config, ContainerInterface $container)
    {
        $configuration = new GenericConfiguration();
        $configuration
            ->setAccessKey($config['accesskey'])
            ->setSecretKey($config['secretkey'])
            ->setAssociateTag($config['associatetag'])
            ->setCountry($config['country']);

        // Setting the default request-type if it has been set up
        if (true === isset($config['request'])) {
            $configuration->setRequest($config['request']);
        } else {
            $client = new \GuzzleHttp\Client();
            $request = new \ApaiIO\Request\GuzzleRequest($client);
            $configuration->setRequest($request);
        }

        // Setting the default ResponseTransformer if it has been set up
        if (true === isset($config['response'])) {
            $configuration->setResponseTransformer($container->get($config['response']));
        }

        return new ApaiIO($configuration);
    }
}