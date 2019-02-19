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
 * Class EmptyRequestBody
 *
 * @package Lucille\Request\Body
 */
class EmptyRequestBody implements RequestBody {
    
    /**
     * @return string
     */
    public function asString(): string {
        return '';
    }
    
}
