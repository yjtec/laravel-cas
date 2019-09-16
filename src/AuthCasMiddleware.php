<?php
namespace Yjtec\Cas;
use Closure;
use Auth;
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

        return Auth::guard('cas')->check() ?
        $next($request) :
        response()->json([
            'errcode' => 'APP_TICKET_FAIL',
            'errmsg'  => config('code.APP_TICKET_FAIL')[1],
        ], 433);
    }
}
