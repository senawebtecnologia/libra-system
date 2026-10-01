<?php

namespace App\Core\Http\Middleware;

use App\Core\Models\Tenant;
use App\Core\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        if (in_array($host, config('libra.central_domains'), true)) {
            return $next($request); // painel central, sem tenant
        }

        $tenant = Tenant::where('domain', $host)->first();

        if (! $tenant) {
            abort(404, 'Tenant não encontrado.');
        }

        if ($tenant->status !== 'active') {
            abort(503, 'Este ambiente está indisponível no momento.');
        }

        app(TenantManager::class)->set($tenant);

        return $next($request);
    }
}