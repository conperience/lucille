## Components

### XHTML and XML Content
The optional XHTML and XML Component helps to handle XML content.
It extends the PHP DOM functionality with some usefull helper methods.

Besides that you can of course build your own _Result_ and _Response_ to completely fityour projects needs.

The Component consists of the following parts:

| Object | Description |
| --- | --- |
| XhtmlContent (Result object) | Xhtml Content Container; based on DOMDocument |
| XmlContent (Result object) | Xml Content Container; based on DOMDocument |

The main difference between _XhtmlContent_ and _XmlContent_ is that XmlContent handles content as plain XML data,
while XhtmlContent registers the HTML namespace. 

### Usage Examples

#### Loading XHTML parts
```php
$page = new XhtmlContent(new Filename('xhtml://design.xhtml'));
```

#### Finding xml nodes
Finding xml nodes within the XML/XHTML content is done by a XPath query.
You can either query by using the helper functions directly or by using the _Xpath_ object returned by _getContentXp()_

```php
// finding a node by its ID attribute
$page->findById('footer');                                          //returns DOMElement

// finding exactly one DOMElement using xpath query
$page->queryOne(new XPathQuery("//html:div[@id = 'footer']"));      //returns DOMElement

// finding nodes using xpath queries
$page->query(new XPathQuery("//html:div"));                         //returns DOMNodeList

// finding by using the XPath object
$xp = $page->getContentXp();
$xp->query("//html:div");

// using own implementation
$xp = new \DOMXPath($page->getContentDom());
$xp->query("//html:div");

```

#### Append
Load a XHTML part and append it to the xml node with the id attribute 'content'

```php
// load main page
$page = new XhtmlContent(new Filename('xhtml://page.xhtml'));

// appending the part
$menu = new XhtmlContent(new Filename('xhtml://menu.xhtml'));
$page->append('menu_content', $menu);
```

#### InsertBefore
```php
// load main page
$page = new XhtmlContent(new Filename('xhtml://page.xhtml'));

// inserting the part before an other xml node
$error = new XhtmlContent(new Filename('xhtml://errorpart.xhtml'));
$page->insertBefore('myformular', $error);
```

#### Removing content
Removes a xml node specified by its ID attribute
```php
$page->remove('infonote');
```

#### Replacing content
```php
// load new website menu
$newMenu = new XhtmlContent(new Filename('xhtml://fancy_new_menu.xhtml'));

// replace website menu
$page = new XhtmlContent(new Filename('xhtml://page.xhtml'));
$page->replace('menu', $newMenu);
```




