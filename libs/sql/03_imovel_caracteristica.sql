CREATE TABLE imovel_caracteristica (
    id SERIAL NOT NULL,
    imovel_id INT NOT NULL,
    descricao VARCHAR(250) NOT NULL,
    usuario_id INT NOT NULL,
    data_insert DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_update DATETIME on update CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX (imovel_id),
    FOREIGN KEY (imovel_id) REFERENCES imovel(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);