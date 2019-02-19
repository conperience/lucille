<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request\Body;

/**
 * Interface RequestBody
 *
 * @package Lucille\Request\Body
 */
interface RequestBody {
    
    /**
     * Returns the original (unmodified) request body as string
     *
     * @return string
     */
    public function asString(): string;
    
}
