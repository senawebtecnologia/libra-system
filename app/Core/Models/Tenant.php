<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $connection = 'central';

    protected $fillable = [
        'name', 'slug', 'domain', 'plan', 'database_mode',
        'db_host', 'db_database', 'db_username', 'db_password',
        'status',
    ];

    protected $casts = [
        'db_password' => 'encrypted',
    ];

    public function isShared(): bool
    {
        return $this->database_mode === 'shared';
    }

    public function isExclusive(): bool
    {
        return $this->database_mode === 'exclusive';
    }

    public function connectionConfig(): array
    {
        $base = config('database.connections.tenant_template');

        if ($this->isShared()) {
            return array_merge($base, [
                'database' => config('libra.shared_database'),
            ]);
        }

        return array_merge($base, [
            'host'     => $this->db_host ?: $base['host'],
            'database' => $this->db_database,
            'username' => $this->db_username ?: $base['username'],
            'password' => $this->db_password ?: $base['password'],
        ]);
    }
}