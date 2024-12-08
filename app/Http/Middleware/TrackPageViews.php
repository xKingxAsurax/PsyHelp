<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\DataCollectionService;
use Illuminate\Support\Facades\Auth;

class TrackPageViews
{
    protected $dataCollectionService;

    public function __construct(DataCollectionService $dataCollectionService)
    {
        $this->dataCollectionService = $dataCollectionService;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && $request->isMethod('get')) {
            $this->dataCollectionService->logPageView(
                Auth::id(),
                $request->path(),
                [
                    'user_agent' => $request->userAgent(),
                    'ip' => $request->ip(),
                    'referrer' => $request->header('referer')
                ]
            );
        }

        return $response;
    }
} 