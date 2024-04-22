<?php
namespace Api\Classes;

class Router {
    protected $routes = ['GET' => [], 'POST' => [], 'DELETE' => [], 'PUT' => []];

    public function addRoute(string $verb, string $url, callable $target): void
    {
        $this->routes[$verb][$url] = $target;
    }

    public function match($method, $url): array
    {
        if(!array_key_exists($method, $this->routes)) {            
            return $this->returnRequestNotFound();
        }
        
        foreach($this->routes[$method] as $route => $target)
        {
            $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $route);
            
            if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array($target, array_values($params));
            }
        }

        return $this->returnRequestNotFound();
    }

    private function returnRequestNotFound(): array
    {
        http_response_code(404);

        return [
            'message' => 'Endpoint not found',
            'code' => 404,
            'status' => 'Not found'
        ];
    }
}
