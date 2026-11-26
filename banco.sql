/*
   BANCO.SQL - banco de dados do Comeketo

   COMO USAR: no phpMyAdmin ou MySQL Workbench, abra este arquivo e execute tudo.
   ATENÇÃO: o DROP DATABASE apaga o banco comeketo antigo, se ele existir!

   TABELAS (usuarios --< pedidos --< itens_pedido >-- produtos)
   - usuarios : quem usa o site. tipo = 'cliente' ou 'admin'.
     A senha é guardada criptografada (hash do password_hash).
   - produtos : o cardápio (nome, preço, categoria, descrição, nome da foto
     que fica na pasta imagens/, o usuario_id do admin que cadastrou e a
     data de cadastro).
   - pedidos : cada compra (quem comprou, total, status e data).
   - itens_pedido : o que tem em cada pedido (produto, quantidade e o preço
     na hora da compra).
   - FOREIGN KEY (chave estrangeira): liga as tabelas e impede, por exemplo,
     apagar um produto que já aparece em algum pedido.

   DADOS DE EXEMPLO
   - admin para testar: email admin@comeketo.com / senha admin123
   - 7 produtos usando as fotos da pasta imagens/.
*/

DROP DATABASE IF EXISTS comeketo;
CREATE DATABASE comeketo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE comeketo;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente'
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(30) NOT NULL,
    descricao TEXT,
    imagem VARCHAR(255) NOT NULL DEFAULT '',
    usuario_id INT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Recebido',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Administrador', 'admin@comeketo.com', '$2y$10$hK7cpkl65eXBzTRXU3X1FuXbvaiplSz7Vdb3of2CrLsWj1uFTj3Sq', 'admin');

INSERT INTO produtos (nome, preco, categoria, descricao, imagem, usuario_id) VALUES
('X-Burguer',       24.90, 'lanches',         'Pão, hambúrguer artesanal, queijo e molho da casa.', 'como-fazer-x-burguer.jpg', 1),
('Hot Dog',         15.00, 'lanches',         'Pão, salsicha, purê, batata palha e vinagrete.',     'hotdog.jpg', 1),
('Batata Frita',    12.00, 'acompanhamentos', 'Porção de batata frita crocante.',                   'batata.jpg', 1),
('Refrigerante',     6.00, 'bebidas',         'Lata 350ml bem gelada.',                             'cola.jpg', 1),
('Suco Natural',     8.00, 'bebidas',         'Suco da fruta feito na hora.',                       'suco.png', 1),
('Brownie',          9.00, 'variantes',       'Brownie de chocolate com casquinha crocante.',       'brownie.jpg', 1),
('Pudim',            8.50, 'variantes',       'Pudim de leite condensado.',                         'pudim.jpg', 1);
