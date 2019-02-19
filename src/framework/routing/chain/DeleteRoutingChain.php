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
 * Class DeleteRoutingChain
 *
 * @package Lucille\Routing
 */
class DeleteRoutingChain implements RoutingChain {
    
    /**
     * @var DeleteRouter
     */
    protected $start;

    /**
     * @var DeleteRouter
     */
    protected $previous;

    /**
     * @param DeleteRouter $router DeleteRouter instance
     * @return void
     */
    public function addRouter(DeleteRouter $router): void {
        if ($this->start === null) {
            $this->start = $router;
        }
        
        if ($this->previous !== null) {
            $this->previous->setNext($router);
        }
        $this->previous = $router;
    }
    
    /**
     * @param DeleteRequest $request DeleteRequest instance
     * @return Command
     * @throws RoutingChainConfigurationException
     */
    public function route(DeleteRequest $request): Command {
        if ($this->start === null) {
            throw new RoutingChainConfigurationException('No routing target found');
        }
        return $this->start->route($request);
    }
    
}
