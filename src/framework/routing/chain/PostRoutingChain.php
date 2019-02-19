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
use Lucille\Request\PostRequest;

/**
 * Class PostRoutingChain
 *
 * @package Lucille\Routing
 */
class PostRoutingChain implements RoutingChain {
    
    /**
     * @var PostRouter
     */
    protected $start;

    /**
     * @var PostRouter
     */
    protected $previous;

    /**
     * @param PostRouter $router PostRouter instance
     * @return void
     */
    public function addRouter(PostRouter $router): void {
        if ($this->start === null) {
            $this->start = $router;
        }
        
        if ($this->previous !== null) {
            $this->previous->setNext($router);
        }
        $this->previous = $router;
    }
    
    /**
     * @param PostRequest $request PostRequest instance
     * @return Command
     * @throws RoutingChainConfigurationException
     */
    public function route(PostRequest $request): Command {
        if ($this->start === null) {
            throw new RoutingChainConfigurationException('No routing target found');
        }
        return $this->start->route($request);
    }
    
}
