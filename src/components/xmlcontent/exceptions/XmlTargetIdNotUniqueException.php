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
 * Class XmlTargetIdNotUniqueException
 *
 * @package Lucille\Components\Xml\Exceptions
 */
class XmlTargetIdNotUniqueException extends LucilleException {
    
    /**
     * @var string
     */
    private $targetId;
    
    /**
     * @param string $id DOMNode target id attribute
     */
    public function __construct(string $id) {
        parent::__construct("xml target node with id '$id' is not unique in content");
        $this->targetId = $id;
    }
    
    /**
     * @return string
     */
    public function getTargetId(): string {
        return $this->targetId;
    }
    
}
