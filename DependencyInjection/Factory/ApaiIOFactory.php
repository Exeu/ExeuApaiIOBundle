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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Exeu\ApaiIOBundle\Request\EventableRequest;
use Exeu\ApaiIOBundle\ResponseTransformer\EventableResponseTransformer;

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
     * @param array                    $config          The configuration
     * @param EventDispatcherInterface $eventDispatcher The Symfony-Eventdispatcher
     *
     * @return \ApaiIO\ApaiIO
     */
    public static function get(array $config, EventDispatcherInterface $eventDispatcher)
    {
        $configuration = new GenericConfiguration();
        $configuration
            ->setAccessKey($config['accesskey'])
            ->setSecretKey($config['secretkey'])
            ->setAssociateTag($config['associatetag'])
            ->setCountry($config['country']);

        // Setting the default request-type if it has been setted up
        if (true === isset($config['request'])) {
            $configuration->setRequest($config['request']);
        }

        // Setting the default responsetransformer if it has been setted up
        if (true === isset($config['response'])) {
            $configuration->setResponseTransformer($config['response']);
        }

        // Wrapping the configured request
        $configuration->setRequestFactory(
            function ($request) use ($eventDispatcher) {
                return new EventableRequest($request, $eventDispatcher);
            }
        );

        // Wrapping the configured responsetransformer
        $configuration->setResponseTransformerFactory(
            function ($responseTransformer) use ($eventDispatcher) {
                return new EventableResponseTransformer($responseTransformer, $eventDispatcher);
            }
        );

        return new ApaiIO($configuration);
    }
}
