CREATE TABLE usuario(
    id SERIAL NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    data_insert DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_update DATETIME on update CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE(usuario),
    UNIQUE(email)
);