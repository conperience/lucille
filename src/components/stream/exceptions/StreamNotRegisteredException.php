<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Stream\Exceptions;

use Lucille\Components\Stream\StreamName;
use Lucille\Exceptions\LucilleException;

/**
 * Class StreamNotRegisteredException
 *
 * @package Lucille\Components\Stream\Exceptions
 */
class StreamNotRegisteredException extends LucilleException {

    /**
     * @var StreamName
     */
    private $protocolName;

    /**
     * @param StreamName $protocolName Stream Name
     */
    public function __construct(StreamName $protocolName) {
        parent::__construct('Stream for protocol '.$protocolName->asString().' is not defined');
        $this->protocolName = $protocolName;
    }

    /**
     * @return StreamName
     */
    public function getProtocolName(): StreamName {
        return $this->protocolName;
    }
    
}
