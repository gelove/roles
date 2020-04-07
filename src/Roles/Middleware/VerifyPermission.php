<?php

namespace GE\Roles\Middleware;

use Closure;
use GE\Roles\Exceptions\PermissionDeniedException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class VerifyPermission
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
     * @param int|string $permission
     * @return mixed
     * @throws PermissionDeniedException
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if ($this->auth->check() && $this->auth->user()->can($permission)) {
            return $next($request);
        }

        throw new PermissionDeniedException($permission);
    }
}
