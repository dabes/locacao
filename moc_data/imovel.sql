INSERT INTO
    imovel (
        titulo,
        valor,
        condominio,
        iptu,
        area,
        quartos,
        salas,
        banheiro,
        descricao,
        endereco,
        numero,
        complemento,
        bairro,
        cidade,
        estado,
        cep,
        usuario_id
    )
values
    (
        'PRIMEIRO IMOVEL CADASTRADO',
        1123.12,
        132.53,
        110.87,
        37.34,
        1,
        1,
        1,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec bibendum maximus felis. Nulla nec varius lacus. Sed elementum facilisis velit et commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla facilisi. Sed consequat nibh diam, in scelerisque libero pharetra in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean vulputate, nisi quis malesuada lacinia, nulla augue tincidunt ipsum, varius luctus nibh enim at erat. Curabitur eu lacus elementum, pretium libero at, elementum nisi. Donec ornare aliquet dui a sagittis. Donec sed libero sit amet tellus vulputate vehicula. Aenean finibus ligula at dui euismod, nec porttitor elit cursus. Integer leo erat, eleifend non volutpat id, sagittis nec mauris. Donec fringilla at turpis eget porttitor. Vivamus placerat, lorem eu euismod tristique, nunc sapien bibendum felis, egestas gravida turpis sapien ac eros. Cras molestie volutpat ornare. Fusce a sem sed odio mattis luctus et non nulla. Proin eu lorem nec sem tincidunt consequat sit amet et dui. Aliquam eu risus semper, rutrum massa sit amet, molestie sem. Nulla tincidunt ligula sed elit tristique ullamcorper. Maecenas nec mi egestas, sollicitudin velit ut, cursus augue. Curabitur malesuada rutrum leo, quis pretium tellus bibendum dictum. Vivamus sit amet velit vestibulum elit condimentum consequat at ut arcu. Praesent vel velit eget dui lobortis posuere. Maecenas facilisis suscipit venenatis. Nulla venenatis neque quis mi suscipit mollis. Vivamus egestas, mauris in dignissim elementum, massa mi molestie ex, in lacinia nisl odio nec metus. Vivamus ultricies vestibulum neque ut hendrerit. Maecenas vel accumsan mauris, sit amet tristique sapien. Praesent porta libero nec leo placerat ullamcorper. Pellentesque sollicitudin interdum massa, et ullamcorper metus laoreet a. Integer porttitor posuere ullamcorper. Aenean ac scelerisque diam, a porttitor sapien. Donec tellus ipsum, elementum quis lacus quis, consequat interdum libero. Nam vel nisl nibh. Curabitur blandit, velit sed viverra placerat, lacus leo pulvinar velit, at pretium nulla erat eu arcu. Vivamus ac eros sed justo interdum varius. In hac habitasse platea dictumst. Curabitur eu velit diam. In maximus est ac nunc sodales, vitae pharetra augue lacinia. Proin viverra id nisi id sodales. In aliquet, nulla volutpat dignissim fermentum, libero sapien tempus orci, a posuere felis quam a velit. Proin non vestibulum mauris. Aenean ut posuere massa. Sed quis condimentum purus. Morbi consectetur ante sed convallis bibendum. Aliquam egestas ut est ac ultricies. Vivamus tincidunt libero ligula, vitae viverra tellus tempus porttitor. Etiam et lacinia lorem. Integer a semper magna. Etiam et ultricies diam, vel volutpat urna. Quisque a est sed dui ultrices varius eu non nisi. Fusce sed volutpat augue. Suspendisse mollis augue et mattis ullamcorper. Cras placerat risus ac tortor porta, eu ultricies urna aliquet. Phasellus ac sapien vel felis mattis pretium non vitae ipsum. Donec sit amet lorem ut risus euismod congue at et lorem. Morbi euismod suscipit purus, in feugiat magna auctor lacinia. In id ligula et massa ornare rutrum. Sed nec blandit ante. Aliquam vel tempus massa. Pellentesque ut pretium nunc, vel dapibus libero. Nulla viverra, dolor dictum mollis porta, felis libero iaculis.',
        'Av. Afonso Pena',
        726,
        null,
        'Centro',
        'Belo Horizonte',
        'MG',
        '30130-003',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel'
        )
    );

INSERT INTO
    imovel (
        titulo,
        valor,
        condominio,
        iptu,
        area,
        quartos,
        salas,
        banheiro,
        descricao,
        endereco,
        numero,
        complemento,
        bairro,
        cidade,
        estado,
        cep,
        usuario_id
    )
values
    (
        'SEGUNDO IMOVEL CADASTRADO',
        1001.00,
        101.00,
        110.00,
        37.34,
        1,
        1,
        1,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec bibendum maximus felis. Nulla nec varius lacus. Sed elementum facilisis velit et commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla facilisi. Sed consequat nibh diam, in scelerisque libero pharetra in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean vulputate, nisi quis malesuada lacinia, nulla augue tincidunt ipsum, varius luctus nibh enim at erat. Curabitur eu lacus elementum, pretium libero at, elementum nisi. Donec ornare aliquet dui a sagittis. Donec sed libero sit amet tellus vulputate vehicula. Aenean finibus ligula at dui euismod, nec porttitor elit cursus. Integer leo erat, eleifend non volutpat id, sagittis nec mauris. Donec fringilla at turpis eget porttitor. Vivamus placerat, lorem eu euismod tristique, nunc sapien bibendum felis, egestas gravida turpis sapien ac eros. Cras molestie volutpat ornare. Fusce a sem sed odio mattis luctus et non nulla. Proin eu lorem nec sem tincidunt consequat sit amet et dui. Aliquam eu risus semper, rutrum massa sit amet, molestie sem. Nulla tincidunt ligula sed elit tristique ullamcorper. Maecenas nec mi egestas, sollicitudin velit ut, cursus augue. Curabitur malesuada rutrum leo, quis pretium tellus bibendum dictum. Vivamus sit amet velit vestibulum elit condimentum consequat at ut arcu. Praesent vel velit eget dui lobortis posuere. Maecenas facilisis suscipit venenatis. Nulla venenatis neque quis mi suscipit mollis. Vivamus egestas, mauris in dignissim elementum, massa mi molestie ex, in lacinia nisl odio nec metus. Vivamus ultricies vestibulum neque ut hendrerit. Maecenas vel accumsan mauris, sit amet tristique sapien. Praesent porta libero nec leo placerat ullamcorper. Pellentesque sollicitudin interdum massa, et ullamcorper metus laoreet a. Integer porttitor posuere ullamcorper. Aenean ac scelerisque diam, a porttitor sapien. Donec tellus ipsum, elementum quis lacus quis, consequat interdum libero. Nam vel nisl nibh. Curabitur blandit, velit sed viverra placerat, lacus leo pulvinar velit, at pretium nulla erat eu arcu. Vivamus ac eros sed justo interdum varius. In hac habitasse platea dictumst. Curabitur eu velit diam. In maximus est ac nunc sodales, vitae pharetra augue lacinia. Proin viverra id nisi id sodales. In aliquet, nulla volutpat dignissim fermentum, libero sapien tempus orci, a posuere felis quam a velit. Proin non vestibulum mauris. Aenean ut posuere massa. Sed quis condimentum purus. Morbi consectetur ante sed convallis bibendum. Aliquam egestas ut est ac ultricies. Vivamus tincidunt libero ligula, vitae viverra tellus tempus porttitor. Etiam et lacinia lorem. Integer a semper magna. Etiam et ultricies diam, vel volutpat urna. Quisque a est sed dui ultrices varius eu non nisi. Fusce sed volutpat augue. Suspendisse mollis augue et mattis ullamcorper. Cras placerat risus ac tortor porta, eu ultricies urna aliquet. Phasellus ac sapien vel felis mattis pretium non vitae ipsum. Donec sit amet lorem ut risus euismod congue at et lorem. Morbi euismod suscipit purus, in feugiat magna auctor lacinia. In id ligula et massa ornare rutrum. Sed nec blandit ante. Aliquam vel tempus massa. Pellentesque ut pretium nunc, vel dapibus libero. Nulla viverra, dolor dictum mollis porta, felis libero iaculis.',
        'Av. Afonso Pena',
        726,
        null,
        'Centro',
        'Belo Horizonte',
        'MG',
        '30130-003',
        (
            select
                id
            from
                usuario
            where
                usuario = 'daniel2'
        )
    );