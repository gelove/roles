<?php

namespace GE\Roles\Middleware;

use Closure;
use GE\Roles\Exceptions\LevelDeniedException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class VerifyLevel
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
     * @param int $level
     * @return mixed
     * @throws LevelDeniedException
     */
    public function handle(Request $request, Closure $next, int $level)
    {
        if ($this->auth->check() && $this->auth->user()->level() >= $level) {
            return $next($request);
        }

        throw new LevelDeniedException($level);
    }
}
