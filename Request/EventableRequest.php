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

namespace Exeu\ApaiIOBundle\Request;

use ApaiIO\Request\RequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use ApaiIO\Configuration\ConfigurationInterface;
use ApaiIO\Operations\OperationInterface;
use Exeu\ApaiIOBundle\Event\ResponseEvent;
use Exeu\ApaiIOBundle\Event\RequestEvent;

/**
 * Eventable request class.
 * Simply wraps the configured request and fires events before and after the request is done.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class EventableRequest implements RequestInterface
{
    /**
     * The pre request event is fired before the request.
     *
     * @var string
     */
    const PRE_REQUEST = 'apaiio.events.pre_request';

    /**
     * The post request event is fired after the request.
     *
     * @var string
     */
    const POST_REQUEST = 'apaiio.events.post_request';

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param RequestInterface         $request
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(RequestInterface $request, EventDispatcherInterface $eventDispatcher)
    {
        $this->request = $request;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->request->setConfiguration($configuration);
    }

    /**
     * {@inheritdoc}
     */
    public function perform(OperationInterface $operation)
    {
        $this->eventDispatcher->dispatch(self::PRE_REQUEST, new RequestEvent($operation));

        $result = $this->request->perform($operation);

        $event = new ResponseEvent($operation, $result);
        $this->eventDispatcher->dispatch(self::POST_REQUEST, $event);

        return $event->getResponse();
    }
}
