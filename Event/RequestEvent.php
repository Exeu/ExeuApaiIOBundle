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

namespace Exeu\ApaiIOBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ApaiIO\Operations\OperationInterface;

/**
 * A base request which is fired before each request is done by apai-io
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class RequestEvent extends Event
{
    /**
     * @var OperationInterface
     */
    private $operation = null;

    /**
     * Constructor
     *
     * @param OperationInterface $operation
     */
    public function __construct(OperationInterface $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Gets the current operation.
     *
     * @return OperationInterface
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
