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
 * Class PostRouter
 *
 * @package Lucille\Routing
 */
abstract class PostRouter {
    
    /**
     * @var PostRouter
     */
    private $next;
    
    /**
     * @param PostRouter $router PostRouter reference
     * @return void
     */
    public function setNext(PostRouter $router) {
        $this->next = $router;
    }
    
    /**
     * @return PostRouter
     * @throws RoutingChainConfigurationException
     */
    public function getNext(): PostRouter {
        if ($this->next === null) {
            throw new RoutingChainConfigurationException('Cannot invoke next router');
        }
        return $this->next;
    }
    
    /**
     * @param PostRequest $request PostRequest object
     * @return Command
     */
    abstract public function route(PostRequest $request): Command;
    
}
