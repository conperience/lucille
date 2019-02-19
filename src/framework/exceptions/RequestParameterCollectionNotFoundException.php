<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Exceptions;

/**
 * Class RequestParameterCollectionNotFoundException
 *
 * @package Lucille\Exceptions
 */
class RequestParameterCollectionNotFoundException extends LucilleException {

    /**
     * @var string
     */
    private $parameterCollectionName;
    
    /**
     * @param string $name Request parameter collection name
     */
    public function __construct(string $name) {
        parent::__construct('Request parameter collection with name '.$name.' was not found');
        $this->parameterCollectionName = $name;
    }
    
    /**
     * @return string
     */
    public function getParameterCollectionName(): string {
        return $this->parameterCollectionName;
    }
    
}
