<?php

namespace App\QueryFilters;

use Closure;

class Recipient
{
    public function handle($request, Closure $next)
    {
        if( ! request()->has('recipient'))
            return $next($request);

        $builder = $next($request);

        return $builder->where('recipient', request('recipient'));
    }
}
