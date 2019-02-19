<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Response;

/**
 * Interface Response
 *
 * @package Lucille\Response
 */
interface Response {
    
    /**
     * @return void
     */
    public function send(): void;
    
}
