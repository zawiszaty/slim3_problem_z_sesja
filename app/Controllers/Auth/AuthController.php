<?php


namespace App\Controllers\Auth;


use App\Controllers\Controller;
use App\Models\User;

use Respect\Validation\Validator as v;
class AuthController extends Controller {



    public function getSignOut($request, $response){

$this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));

    }

    public function getSignIn($request , $response){

        return $this->view->render($response, 'auth/signin.twig');
    }


    public function postSignIn($request ,$response ){

        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')


        );


        if(!$auth){
            $this->flash->addMessage('error','Wrong !!!!');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        $this->flash->addMessage('info','Log IN');
        return $response->withRedirect($this->router->pathFor('home'));

    }

public function getSignUp($request , $response){

    return $this->view->render($response, 'auth/signup.twig');
}


    public function postSignUp($request , $response)
    {
        $validation = $this->validator->validate($request,[
            'email' => v::noWhiteSpace()->notEmpty()->EmailAvailable(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::noWhiteSpace()->notEmpty(),
        ]);


        if($validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }
               User::create([
                   'email' => $request->getParam('email'),
                   'name' => $request->getParam('name'),
                   'password' => password_hash( $request->getParam('password'), PASSWORD_DEFAULT),
               ]);
        $this->flash->addMessage('info','You have been signed up!');

        $this->auth->attempt($request->getParam('email'),$request->getParam('password'));
               return $response->withRedirect($this->router->pathFor('home'));
    }



}