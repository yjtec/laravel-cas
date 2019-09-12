<?php 
namespace Yjtec\Cas;
use Illuminate\Auth\TokenGuard;
class CasGuard extends TokenGuard{
    public function __construct($provider,$request){
        $this->request = $request;
        $this->provider = $provider;
        $this->inputKey = 'ticket';
        $this->storageKey = 'ticket';
    }
    public function user(){
        if (! is_null($this->user)) {
            return $this->user;
        }
        $user = null;

        $token = $this->getTokenForRequest();
        if (! empty($token)) {
            if($data = app('cas')->check($token)){
                $id = $data['login_data']['id'];
                $user = $this->provider->retrieveByCredentials(
                    ['id' => $id]
                );
            }
            
        }
        return $this->user = $user;
    }

    public function getTokenForRequest()
    {
        $token = $this->request->query($this->inputKey);

        if (empty($token)) {
            $token = $this->request->input($this->inputKey);
        }

        if (empty($token)) {
            $token = $this->request->header($this->inputKey);
        }

        return $token;
    }    

    public function validate(array $credentials = []){
        return false;
    }
}
?>