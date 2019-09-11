<?php
namespace Yjtec\Cas;
use Closure;
class AuthCasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($request->has('ticket')){
            app('cas')->checkTicket(
                $request->ticket,
                function($data){
                    session()->put('cas_login',$data);
                    session()->save();
                }
            );
        }else{
            app('cas')->checkLogin();
        }
        return $next($request);
    }
}
