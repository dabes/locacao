insert into
    imovel_caracteristica(imovel_id, descricao, usuario_id)
values
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'PRIMEIRO IMOVEL CADASTRADO'
        ),
        '2 unidades por andar',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'PRIMEIRO IMOVEL CADASTRADO'
        ),
        '4 quartos',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'PRIMEIRO IMOVEL CADASTRADO'
        ),
        '1 suíte',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'PRIMEIRO IMOVEL CADASTRADO'
        ),
        '3 banhos',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'PRIMEIRO IMOVEL CADASTRADO'
        ),
        '1 varanda',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'PRIMEIRO IMOVEL CADASTRADO'
        ),
        '1 sala',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'PRIMEIRO IMOVEL CADASTRADO'
        ),
        'Textura',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    );

insert into
    imovel_caracteristica(imovel_id, descricao, usuario_id)
values
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        '3 vagas',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        'Churrasqueira',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        'Hall social',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        'Jardim',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        'Gás canalizado',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        'Academia',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        'Elevador codificado',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    ),
    (
        (
            select
                id
            from
                imovel
            where
                titulo = 'SEGUNDO IMOVEL CADASTRADO'
        ),
        'Elevador social',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    );