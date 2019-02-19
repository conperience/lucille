<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */
    
namespace Lucille;
    
use Lucille\Components\Stream\StreamName;
use Lucille\Request\RequestFactory;
use Lucille\Routing\DeleteRoutingChain;
use Lucille\Routing\GetRoutingChain;
use Lucille\Routing\PatchRoutingChain;
use Lucille\Routing\PostRoutingChain;
use Lucille\Routing\PutRoutingChain;
use Lucille\Routing\ResultRoutingChain;
use Lucille\Components\Stream\Stream;

/**
 * Class Factory
 *
 * @package Lucille
 */
class Factory {

    /**
     * @param array  $globalGet    _GET source data
     * @param array  $globalPost   _POST source data
     * @param array  $globalServer _SERVER source data
     * @param string $inputStream  Input stream (default: php://input)
     * @return RequestFactory
     */
    public function createRequestFactory(
        array $globalGet = null,
        array $globalPost = null,
        array $globalServer = null,
        string $inputStream = 'php://input'
    ): RequestFactory {
        $globalGet    = $globalGet ?? $_GET;
        $globalPost   = $globalPost ?? $_POST;
        $globalServer = $globalServer ?? $_SERVER;
        return new RequestFactory($globalGet, $globalPost, $globalServer, $inputStream);
    }
    
    /**
     * @return RequestProcessor
     */
    public function createRequestProcessor(): RequestProcessor {
        return new RequestProcessor();
    }
    
    /**
     * @param string $name stream scheme name
     * @param string $path stream target path
     * @return void
     * @throws Exceptions\DirectoryNotFoundException
     * @throws \Lucille\Components\Stream\Exceptions\CannotRegisterStreamException
     * @throws \Lucille\Components\Stream\Exceptions\StreamAlreadyRegisteredException
     */
    public function registerStream(string $name, string $path): void {
        Stream::registerStream(
            new StreamName($name),
            new Directory($path)
        );
    }
    
    /**
     * @return GetRoutingChain
     */
    public function createGetRoutingChain(): GetRoutingChain {
        return new GetRoutingChain();
    }

    /**
     * @return PostRoutingChain
     */
    public function createPostRoutingChain(): PostRoutingChain {
        return new PostRoutingChain();
    }
    
    /**
     * @return PutRoutingChain
     */
    public function createPutRoutingChain(): PutRoutingChain {
        return new PutRoutingChain();
    }

    /**
     * @return PatchRoutingChain
     */
    public function createPatchRoutingChain(): PatchRoutingChain {
        return new PatchRoutingChain();
    }
    
    /**
     * @return DeleteRoutingChain
     */
    public function createDeleteRoutingChain(): DeleteRoutingChain {
        return new DeleteRoutingChain();
    }

    /**
     * @return ResultRoutingChain
     */
    public function createResultRoutingChain(): ResultRoutingChain {
        return new ResultRoutingChain();
    }
    
}
