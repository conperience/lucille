<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Routing;

use Lucille\Command;
use Lucille\Exceptions\RoutingChainConfigurationException;
use Lucille\Request\DeleteRequest;

/**
 * Class DeleteRouter
 *
 * @package Lucille\Routing
 */
abstract class DeleteRouter {

    /**
     * @var DeleteRouter
     */
    private $next;

    /**
     * @param DeleteRouter $router DeleteRouter reference
     * @return void
     */
    public function setNext(DeleteRouter $router) {
        $this->next = $router;
    }

    /**
     * @return DeleteRouter
     * @throws RoutingChainConfigurationException
     */
    public function getNext(): DeleteRouter {
        if ($this->next === null) {
            throw new RoutingChainConfigurationException('Cannot invoke next router');
        }
        return $this->next;
    }

    /**
     * @param DeleteRequest $request DeleteRequest object
     * @return Command
     */
    abstract public function route(DeleteRequest $request): Command;

}
