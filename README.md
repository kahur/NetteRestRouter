Nette Rest Router
=====================

Flags
------------

* RestRoute::METHOD_GET
* RestRoute::METHOD_PUT
* RestRoute::METHOD_DELETE
* RestRoute::METHOD_POST

Dependencies
------------
* Nette 2.1.0 +

Installation
------------
```PHP

$route = new RouteList();

$route[] = new \library\KH\RestRoute("<module>/<presenter>");

```


Usage
---------

#### 1) Simple rest route with module

```PHP
 $route[] = new \library\KH\RestRoute("myModule","MyModule:MyPresenter");
```



#### 2) Rest route with custom presenter methods

```PHP
$myRestRoute = new \library\KH\RestRoute("myModule","MyModule:MyPresenter");
//set presenter method for create  in presenter route will call renderCreate()
$myRestRoute->setCreateMethod('create');
//set presenter method for update, in presenter route will call renderUpdate();
$myRestRoute->setUpdateMethod('update');

//set default presenter method, router will call it if request method is get
$myRestRoute->setDefaultMethod('index');

$route[] = $myRestRoute;
```

#### 3) Rest route with manualy induced request method

```PHP
$route[] = new \library\KH\RestRoute("myModule","MyModule;MyPresenter",\library\KH\RestRoute::METHOD_PUT);

```

#### 4) Example

```PHP

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter,
	library\RestRoute;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
		$router[] = new RestRoute('API','API:API:default');

		//other routes
		
		return $router;
	}

}

```

