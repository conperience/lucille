<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xml\Exceptions;

use Lucille\Exceptions\LucilleException;

/**
 * Class XmlNodeNotFoundException
 *
 * @package Lucille\Components\Xml\Exceptions
 */
class XmlNodeNotFoundException extends LucilleException {
    
    /**
     * XmlNodeNotFoundException constructor.
     */
    public function __construct() {
        parent::__construct("xpath query failed: no matching nodes found");
    }
    
}
