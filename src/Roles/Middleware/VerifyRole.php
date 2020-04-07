<?php

namespace GE\Roles\Middleware;

use Closure;
use GE\Roles\Exceptions\RoleDeniedException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class VerifyRole
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param int|string $role
     * @return mixed
     * @throws RoleDeniedException
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($this->auth->check() && $this->auth->user()->isRole($role)) {
            return $next($request);
        }

        throw new RoleDeniedException($role);
    }
}
