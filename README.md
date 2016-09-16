# : Router

[![Software License][ico-license]](LICENSE.md)

##### Description

Ok, folks. We have a task: Write some function or class to find optimal path between two points. Function must accept tree parameters - point1, point2, list of points and price.

![](https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Shortest_path_with_direct_weights.svg/350px-Shortest_path_with_direct_weights.svg.png)


For solution of this task I enabled [Dijkstra algorithm](https://en.wikipedia.org/wiki/Dijkstra%27s_algorithm).

##### Basic usage 
---

    $router = new \Ukolov\Router\Router();
    $route = $router->getRoute(
		"a", "g",
		[
			["a", "b", 10],
			["b", "c", 10],
			["c", "d", 10],
			["d", "e", 10],
			["e", "f", 10],
			["f", "g", 10],
			["a", "d", 30],
			["d", "g", 20]
		]
	);


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square