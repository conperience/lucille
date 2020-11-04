<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Header\HeaderCollection;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Request;
use Lucille\Request\Uri;

class TestRequest extends Request {
    public function __construct(Uri $uri, HeaderCollection $headerCollection, RequestParameterCollection $parameterCollection) {
        parent::__construct($uri, $headerCollection, $parameterCollection);
    }
}
