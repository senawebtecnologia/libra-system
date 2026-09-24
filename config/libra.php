<?php

return [
    // Banco compartilhado dos clientes no plano básico
    'shared_database' => env('LIBRA_SHARED_DATABASE', 'libra_shared'),

    // Prefixo dos bancos exclusivos (libra_cliente_23)
    'exclusive_db_prefix' => 'libra_cliente_',

    // Domínios do painel central (super admin)
    'central_domains' => array_filter(explode(',', env('LIBRA_CENTRAL_DOMAINS', 'libra-system.test,localhost'))),
];