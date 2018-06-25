<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$settings = $app->getContainer()->get('settings');

$app->add(new \Slim\Middleware\JwtAuthentication([
    "path" => "/api", /* or ["/api", "/admin"] */
    "secret" => $settings['jwt']['secret'],
    "algorithm" => ["HS256"],
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    },
    "error" => function ($request, $response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));