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
 * Class RequestBodyFactory
 *
 * @package Lucille\Request\Body
 */
abstract class RequestBodyFactory {

    /**
     * @param string $inStream Input stream (default to php://input);
     * @return RequestBody
     */
    public static function fromStream(string $inStream): RequestBody {
        $payload = file_get_contents($inStream);
        if (empty($payload)) {
            return new EmptyRequestBody();
        }

        return new RawRequestBody($payload);
    }

}
