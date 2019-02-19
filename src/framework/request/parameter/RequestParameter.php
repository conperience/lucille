<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request\Parameter;

/**
 * Interface RequestParameter
 *
 * @package Lucille\Request\Parameter
 */
interface RequestParameter {

    /**
     * @return RequestParameterName
     */
    public function getName(): RequestParameterName;

    /**
     * @return string
     */
    public function asString(): string;

    /**
     * @return int
     */
    public function asInt(): int;

    /**
     * @return float
     */
    public function asFloat(): float;
    
}
