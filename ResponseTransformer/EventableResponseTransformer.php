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

namespace Exeu\ApaiIOBundle\ResponseTransformer;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use ApaiIO\ResponseTransformer\ResponseTransformerInterface;
use Exeu\ApaiIOBundle\Event\TransformEvent;

/**
 * Eventable request class.
 * Simply wraps the configured request and fires events before and after the request is done.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class EventableResponseTransformer implements ResponseTransformerInterface
{
    /**
     * The pre transform event is fired before the reponsetransformer will be applied.
     *
     * @var string
     */
    const PRE_TRANSFORM = 'apaiio.events.pre_transform';

    /**
     * The post transform event is fired after the reponsetransformer is applied.
     *
     * @var string
     */
    const POST_TRANSFORM = 'apaiio.events.post_transform';

    /**
     * @var ResponseTransformerInterface
     */
    protected $responseTransformer;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param ResponseTransformerInterface $responseTransformer
     * @param EventDispatcherInterface     $eventDispatcher
     */
    public function __construct(ResponseTransformerInterface $responseTransformer, EventDispatcherInterface $eventDispatcher)
    {
        $this->responseTransformer = $responseTransformer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($response)
    {
        $this->eventDispatcher->dispatch(self::PRE_TRANSFORM, new TransformEvent($response));

        $response = $this->responseTransformer->transform($response);

        $this->eventDispatcher->dispatch(self::POST_TRANSFORM, new TransformEvent($response));
    }
}
