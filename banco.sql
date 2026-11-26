-- =========================================================
-- COMEKETO - banco de dados
-- Como usar: abra o phpMyAdmin (ou MySQL Workbench),
-- vá na aba SQL, cole tudo isso aqui e clique em Executar.
-- ATENÇÃO: o DROP DATABASE apaga o banco antigo se ele existir!
-- =========================================================

DROP DATABASE IF EXISTS comeketo;
CREATE DATABASE comeketo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE comeketo;

-- usuários do site (cliente ou admin)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,             -- guarda o hash do password_hash()
    tipo ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente'
);

-- produtos do cardápio
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(30) NOT NULL,          -- lanches, bebidas, acompanhamentos, variantes
    descricao TEXT,
    imagem VARCHAR(255) NOT NULL DEFAULT ''  -- nome do arquivo dentro da pasta imagens/
);

-- pedidos feitos pelos usuários
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Recebido',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- itens de cada pedido
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)  -- não deixa apagar produto que já foi pedido
);

-- =========================================================
-- dados de exemplo
-- =========================================================

-- admin para testar: email admin@comeketo.com / senha admin123
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Administrador', 'admin@comeketo.com', '$2y$10$hK7cpkl65eXBzTRXU3X1FuXbvaiplSz7Vdb3of2CrLsWj1uFTj3Sq', 'admin');

INSERT INTO produtos (nome, preco, categoria, descricao, imagem) VALUES
('X-Burguer',       24.90, 'lanches',         'Pão, hambúrguer artesanal, queijo e molho da casa.', 'como-fazer-x-burguer.jpg'),
('Hot Dog',         15.00, 'lanches',         'Pão, salsicha, purê, batata palha e vinagrete.',     'hotdog.jpg'),
('Batata Frita',    12.00, 'acompanhamentos', 'Porção de batata frita crocante.',                   'batata.jpg'),
('Refrigerante',     6.00, 'bebidas',         'Lata 350ml bem gelada.',                             'cola.jpg'),
('Suco Natural',     8.00, 'bebidas',         'Suco da fruta feito na hora.',                       'suco.png'),
('Brownie',          9.00, 'variantes',       'Brownie de chocolate com casquinha crocante.',       'brownie.jpg'),
('Pudim',            8.50, 'variantes',       'Pudim de leite condensado.',                         'pudim.jpg');
