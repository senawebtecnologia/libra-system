<?php

namespace App\Core\Services;

use App\Core\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TenantManager
{
    private ?Tenant $tenant = null;

    public function set(Tenant $tenant): void
    {
        $this->tenant = $tenant;

        Config::set('database.connections.tenant', $tenant->connectionConfig());
        DB::purge('tenant');
    }

    public function current(): ?Tenant
    {
        return $this->tenant;
    }

    public function id(): ?int
    {
        return $this->tenant?->id;
    }

    public function check(): bool
    {
        return $this->tenant !== null;
    }

    public function idOrFail(): int
    {
        return $this->tenant?->id
            ?? throw new RuntimeException('Nenhum tenant ativo no contexto atual.');
    }
}