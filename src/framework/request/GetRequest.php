<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request;

use Lucille\Header\HeaderCollection;
use Lucille\Request\Parameter\RequestParameterCollection;

/**
 * Class GetRequest
 *
 * @package Lucille\Request
 */
class GetRequest extends Request {

    /**
     * @param Uri                        $uri                 Request Uir object
     * @param HeaderCollection           $headerCollection    Header Collection
     * @param RequestParameterCollection $parameterCollection GET parameter
     */
    public function __construct(
        Uri $uri,
        HeaderCollection $headerCollection,
        RequestParameterCollection $parameterCollection
    ) {
        parent::__construct($uri, $headerCollection, $parameterCollection);
    }
    
}
