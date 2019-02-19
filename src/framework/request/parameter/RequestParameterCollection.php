<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request\Parameter;

use Lucille\Exceptions\RequestParameterCollectionNotFoundException;
use Lucille\Exceptions\RequestParameterNotFoundException;

/**
 * Class RequestParameterCollection
 *
 * @package Lucille\Request\Parameter
 */
class RequestParameterCollection implements \Countable,\IteratorAggregate {
    
    /**
     * @var array
     */
    private $parameters = array();

    /**
     * @var array of RequestParameterCollection objects
     */
    private $parameterCollection = array();
    
    /**
     * @param RequestParameter $parameter Parameter object
     * @return void
     */
    public function addParam(RequestParameter $parameter): void {
        switch (get_class($parameter->getName())) {
            case 'Lucille\Request\Parameter\StringRequestParameterName': {
                $this->parameters[$parameter->getName()->asString()] = $parameter;
                break;
            }
            case 'Lucille\Request\Parameter\NumericRequestParameterName': {
                $this->parameters[$parameter->getName()->asInt()] = $parameter;
                break;
            }
        }
    }
    
    /**
     * @param string                     $name                Parameter Collection Name
     * @param RequestParameterCollection $parameterCollection Parameter Collection object
     * @return void
     */
    public function addParameterCollection(string $name, RequestParameterCollection $parameterCollection) {
        $this->parameterCollection[$name] = $parameterCollection;
    }

    /**
     * @param string $name Request parameter collection list
     * @return RequestParameterCollection
     * @throws RequestParameterCollectionNotFoundException
     */
    public function getParameterCollection(string $name): RequestParameterCollection {
        if (!isset($this->parameterCollection[$name])) {
            throw new RequestParameterCollectionNotFoundException($name);
        }
        return $this->parameterCollection[$name];
    }
    
    /**
     * Checks if a parameter is in the Collection
     *
     * @param mixed $name Request parameter name
     * @return bool
     */
    public function hasParam($name): bool {
        if ($this->count() === 0) {
            return false;
        }
        if (!array_key_exists($name, $this->parameters)) {
            return false;
        }
        return true;
    }

    /**
     * @param mixed $name Request parameter name
     * @return RequestParameter
     * @throws RequestParameterNotFoundException
     */
    public function getParam($name): RequestParameter {
        if (!isset($this->parameters[$name])) {
            throw new RequestParameterNotFoundException($name);
        }
        return $this->parameters[$name];
    }
    
    /**
     * @param array $source Source parameter data
     * @return RequestParameterCollection
     */
    public static function fromArray(array $source): RequestParameterCollection {
        $collection = new RequestParameterCollection();
        
        if (count($source) > 0) {
            foreach ($source as $name => $value) {
                switch (42) {
                    case (is_array($value)): {
                        $subCollection = RequestParameterCollection::fromArray($value);
                        $collection->addParameterCollection($name, $subCollection);
                        break;
                    }
                    case (is_numeric($name)): {
                        $collection->addParam(
                            new StringRequestParameter(new NumericRequestParameterName($name), (string)$value)
                        );
                        break;
                    }
                    default: {
                        $collection->addParam(
                            new StringRequestParameter(new StringRequestParameterName($name), (string)$value)
                        );
                        break;
                    }
                }
            }
        }
        
        return $collection;
    }
    
    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator {
        return new \ArrayIterator(array_values($this->parameters));
    }
    
    /**
     * @return int
     */
    public function count(): int {
        return count($this->parameters);
    }
    
}
