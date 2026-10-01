<?php

namespace App\Core\Scopes;

use App\Core\Services\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $id = app(TenantManager::class)->idOrFail();

        $builder->where($model->qualifyColumn('tenant_id'), $id);
    }
}