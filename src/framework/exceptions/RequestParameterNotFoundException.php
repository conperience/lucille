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
 * Class RequestParameterNotFoundException
 *
 * @package Lucille\Exceptions
 */
class RequestParameterNotFoundException extends LucilleException {

    /**
     * @var string
     */
    private $parameterName;
    
    /**
     * @param string $name Request parameter name
     */
    public function __construct(string $name) {
        parent::__construct('Request parameter with name '.$name.' was not found');
        $this->parameterName = $name;
    }

    /**
     * @return string
     */
    public function getParameterName(): string {
        return $this->parameterName;
    }
    
}
