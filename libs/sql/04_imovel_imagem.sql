create table imovel_imagem(
    id SERIAL NOT NULL,
    imovel_id INT NOT NULL,
    imagem LONGBLOB NOT NULL,
    mimetype VARCHAR(50) NOT NULL,
    usuario_id INT NOT NULL,
    principal BOOLEAN DEFAULT FALSE,
    data_insert DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_update DATETIME on update CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX (imovel_id),
    FOREIGN KEY (imovel_id) REFERENCES imovel(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);