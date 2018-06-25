<?php

use Slim\Http\Request;
use Slim\Http\Response;

use \Firebase\JWT\JWT;

// $app->get('/password_hash',function(Request $request, Response $response, array $args) {
//     print_r(password_hash('Arjun@123',PASSWORD_BCRYPT));
// });


$app->post('/login', function (Request $request, Response $response, array $args) {

    $input = $request->getParsedBody();
    $sql = "SELECT * FROM users WHERE email= :email";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("email", $input['email']);
    $sth->execute();
    $user = $sth->fetchObject();

    // verify email address.
    if(!$user) {
        return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
    }

    // verify password.
    if (!password_verify($input['password'],$user->password)) {
        return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
    }

    $settings = $this->get('settings'); // get settings array.
    
    $token = JWT::encode(['id' => $user->id, 'email' => $user->email], $settings['jwt']['secret'], "HS256");

    return $this->response->withJson(['token' => $token]);

});


$app->group('/api', function(\Slim\App $app) {

    $app->get('/user',function(Request $request, Response $response, array $args) {
        print_r($this->get('jwt'));

        /*output 
        stdClass Object
            (
                [id] => 2
                [email] => arjunphp@gmail.com
            )
                    
        */
        
    });
   
});