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
 * Class XmlMultipleNodesFoundException
 *
 * @package Lucille\Components\Xml\Exceptions
 */
class XmlMultipleNodesFoundException extends LucilleException {
    
    /**
     * XmlMultipleNodesFoundException constructor.
     */
    public function __construct() {
        parent::__construct("queryOne() failed: multiple xml nodes were found by given xpath query");
    }
    
}
