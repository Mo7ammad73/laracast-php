<?php

    namespace core;
    use core\middleware\Guest;
    use core\middleware\Middleware;

    class Router {
        protected $routes = [];
        public function get($uri , $controller) {
            return $this->add('GET', $uri, $controller);
        }

        public function post($uri , $controller) {
            return $this->add('POST', $uri, $controller);
        }

        public function delete($uri , $controller) {
            return $this->add('DELETE', $uri, $controller);
        }

        public function patch($uri , $controller) {
            return $this->add('PATCH', $uri, $controller);
        }

        public function put($uri , $controller) {
            return $this->add('PUT', $uri, $controller);
        }

        public function route($uri , $method) {
            foreach ($this->routes as $route) {
                if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                    if($route['middleware']) {
                        Middleware::resolve($route['middleware']);
                    }
                    return require_once base_path("http/controller/" . $route['controller']);
                }
            }
            $this->abort();
        }

        public function add($methods , $uri , $controller) {
            foreach ((array)$methods as $method) {
                $this->routes[] = [
                    'uri' => $uri,
                    'controller' => $controller,
                    'method' => $method ,
                    'middleware' => null
                ];
            }
            return $this;
        }

        public function only($key){
            $this->routes[array_key_last($this->routes)]['middleware'] = $key;
            return $this;
//            echo "<pre>";
//                var_dump($this->routes);
//            echo "</pre>";
        }

        protected function abort($code=404){
            http_response_code($code);
            require_once base_path("controller/{$code}.php");
            die();
        }





    }