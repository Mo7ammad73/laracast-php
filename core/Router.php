<?php

    namespace core;
    class Router {
        protected $routes = [];
        public function get($uri , $controller) {
            $this->add('GET', $uri, $controller);
        }

        public function post($uri , $controller) {
            $this->add('POST', $uri, $controller);
        }

        public function delete($uri , $controller) {
            $this->add('DELETE', $uri, $controller);
        }

        public function patch($uri , $controller) {
            $this->add('PATCH', $uri, $controller);
        }

        public function put($uri , $controller) {
            $this->add('PUT', $uri, $controller);
        }

        public function route($uri , $method) {
//            if ($method === 'POST' && isset($_POST['_method'])) {
//                $method = strtoupper($_POST['_method']); // PATCH یا DELETE یا PUT
//            }
            foreach ($this->routes as $route) {
                if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                    return require_once base_path($route['controller']);
                }
            }
            $this->abort();
        }

        public function add($methods , $uri , $controller) {
            foreach ((array)$methods as $method) {
                $this->routes[] = [
                    'uri' => $uri,
                    'controller' => $controller,
                    'method' => $method
                ];
            }

//            $this->routes[] = compact('methods', 'uri', 'controller');
        }

        protected function abort($code=404){
            http_response_code($code);
            require_once base_path("controller/{$code}.php");
            die();
        }
    }