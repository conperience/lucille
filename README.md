## Lucille HTTP Abstraction

Lucille is a lightweight HTTP abstraction layer based on the principles of CQRS.
It is designed to quickly create restful services and web services/websites that require dynamic request handling.

## Requirements
* PHP 7.0+
  * ext/dom *(when using the XML/XHTML component)*
  * ext/xsl *(when using the XSL component)*

## Basic Concepts

### Request processing workflow
The Lucille HTTP Abstraction Framework follows in general the principles of CQRS.
The regular processing of a request is done in six steps:

1. The Request, separated by its HTTP request method (GET, POST, ...) is routed through an explicit RoutingChain to ensure separation from other request types
2. Each router in the chain must decide to either be responsible to handle the request or have to decline it by forwarding it to the next router in the chain
3. The matching router in the chain (the router that decides to be responsible to handle the current request) always returns a valid _Command_ or _Query_ object
3. The Query or Command is executed
4. The result of the execution is always a _Result_ object
4. The _Result_ object is finally routed through a _ResultRouterChain_, which composes the final _Response_ object which is sent to the client

The processing in short, for example for a GetRequest:
1. GetRequest
2. GetRoutingChain returns Query
3. Query is executed and returns a QueryResult object
4. The _result routing chain_ is invoked and builds the final Response object

### Supported HTTP Request Types
Currently the following http request methods are supported
- GET
- POST
- PUT
- PATCH
- DELETE


## Usage

### Full Example using the internal RequestProcessor
The easiest way is to use the provided RequestProcessor.
When creating HTTP services you probably want to implement your own request processing mechanism to properly implement your own Logging and Exception handling.

```php
namespace Website;

use Lucille\Factory;

require_once '/lucille/autoload.php';

// create the factory, which helps getting the core features
$factory = new Factory();

// register stream wrapper
$factory->registerStream('xhtml', __DIR__.'/parts');
$factory->registerStream('xsl',   __DIR__.'/xsl');

// create the GET routing chain add a GET router
$chainGet = $factory->createGetRoutingChain();
$chainGet->addRouter(new IndexRouter());

// create the POST routing chain and add a POST router
$chainPost = $factory->createPostRoutingChain();
$chainPost->addRouter(new FormVerifyRouter());

// create an instance of the default request processor
$processor = $factory->createRequestProcessor();

// enable verbose error output for debugging purposes
//$processor->enableVerboseErrors();

// add routing chains to the processor
$processor->addRoutingChain($chainGet);
$processor->addRoutingChain($chainPost);

// create request (based on the request method, headers and parameters)
$request = $factory->createRequestFactory()->createRequest();

// build a response by running the processor with the created request
$response = $processor->run($request);


// dump/send the response to the client
$response->send();

```

### Implementing Routers, Commands and Queries
#### Example Router (GET Request)
```php
namespace Website;

use Lucille\Query;
use Lucille\Request\GetRequest;
use Lucille\Request\Uri;
use Lucille\Routing\GetRouter;

class IndexRouter extends GetRouter {
    
    public function route(GetRequest $request): Query {
        if (!$request->getUri()->isEqual(new Uri('/'))) {
            return $this->getNext()->route($request);
        }
        
        return new IndexQuery();
    }
    
}
```

#### Example Query
```php
namespace Website;
    
use Lucille\Components\Xml\XhtmlContent;
use Lucille\Filename;
use Lucille\Query;
use Lucille\Result\Result;

class IndexQuery implements Query {
    
    public function execute(): Result {
        // load main page
        $page = new XhtmlContent(new Filename('xhtml://design.xhtml'));
        
        // load a part and append it to the html <body> tag (which has the id attribute 'content')
        $part1 = new XhtmlContent(new Filename('xhtml://part1.xhtml'));
        $page->append('content', $part1);
        
        return $page;
    }
    
}
```

### URI Matching and Usage Examples
```php

// request URI equals another URI
if ($request->getUri()->isEqual( new Uri('/contact') ) {
    ...
}

// check if request URI matches a specified regular expression
// - example request uri: /articles/my-first-article/view.xml
if ($request->getUri()->beginsWith( new Uri('/articles/') ) {
    ...
}

// check if request URI matches a specified regular expression
// - example request uri: /articles/2020/demo-article/
if ($request->getUri()->matchesRegEx( new UriRegEx('#^/articles/[0-9]{4}/.*#') )) {
    ...
}

// check for a specific URI segment
// - example request uri: /articles/2020/demo-article/
$request->getUri()->getPart(0);    // returns 'articles'
$request->getUri()->getPart(1);    // returns '2020'
$request->getUri()->getPart(2);    // returns 'demo-article'

```

### Request Parameter Examples

#### URI parameter by name
example request uri: /article?id=123
```php
// cast to string
echo $request->getParam('id')->asString();

// cast to int
echo $request->getParam('id')->asInt();

// cast to float
echo $request->getParam('id')->asFloat();
```

#### Working with Parameter Collections
```php
// example request uri: /article?id=123&limit=20
$collection = $request->getParameterCollection();
if (count($collection) > 0) {
    foreach ($collection as $param) {
        echo $param->getName()->asString();     // parameter name
        echo $param->asString();                // parameter value
    }
}

// example request uri: /article?list[]=foo&list[]=bar
$collection = $request->getParameterCollection('list');
if (count($collection) > 0) {
    foreach ($collection as $value) {
        echo $value->asString();
    }
}
```

### Components and Helper

Lucille comes with some handy ready-to-use components to solve some daily problems. Most of these components are simply a lightweight wrapper for standard functionality.
So when building complex websites or API projects these components may not fit your extended needs and should be implemented based on your current project scope. 

- [XML and XHTML Content](./docs/components.md)
































