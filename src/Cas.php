<?php
namespace Yjtec\Cas;

use Yjtec\Support\Curl;
use Yjtec\Support\URL;
use Cache;
class Cas
{
    protected $host; //cas服务器的地址
    protected $client; //cas服务的客户端地址

    public function __construct($config)
    {
        $this->host   = $config['host'];
        $this->client = $config['client'];
    }
    public function check($ticket){
        $re = Curl::post(
            $this->host . '/api/check',
            [
                'ticket' => $ticket,
            ]
        );
        $re = json_decode($re, true);
        if (isset($re['errcode']) && $re['errcode'] == 0) {
            return $re['data'];
        } else {
            return false;
        }
    }
    public function checkLogin()
    {
        if (!session()->exists('cas_login')) {
            $redirect = url()->full();
            header('Location:' . $this->host . '/login/' . $this->client . '?redirect=' . $redirect);exit;
        }
    }

    public function checkTicket($ticket, $callback = null)
    {
        $re = Curl::post(
            $this->host . '/api/check',
            [
                'ticket' => $ticket,
            ]
        );
        $re = json_decode($re, true);
        if (isset($re['errcode']) && $re['errcode'] == 0) {
            $callback($re['data']);
        } else {
            $this->redirectLogin();
        }
    }

    public function redirectLogin()
    {
        $currentUrl = url()->full();
        $params     = URL::params($currentUrl);
        if (isset($params['ticket'])) {
            unset($params['ticket']);
        }
        $redirect = URL::build($params, url()->current());
        header('Location:' . $this->host . '/login/' . $this->client . '?redirect=' . $redirect);exit;
    }

    public function logout(){
        return $this->host.'/logout/'.$this->client;
    }
}
