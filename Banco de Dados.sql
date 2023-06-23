create database saep;

use saep;

create table usuarios(
    idUsuario integer primary key auto_increment,
    nome varchar(255),
    email varchar (255),
    cpf varchar (11),
    senha varchar (255)
);

create table produtos(
    idProduto integer primary key auto_increment,
    nome varchar(255),
    imagem varchar(255)
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idProduto INT NOT NULL,
    idUsuario INT NOT NULL,
    tipo ENUM('like', 'dislike') NOT NULL,
    FOREIGN KEY (idProduto) REFERENCES produtos (idProduto),
    FOREIGN KEY (idUsuario) REFERENCES usuarios (idUsuario)
);

create table favorite(
    idFavorite integer primary key auto_increment,
    idUsuario integer,
    idProduto integer,
    foreign key(idUsuario) references usuarios(idUsuario),
    foreign key(idProduto) references produtos(idProduto)
);

select * from produtos;
select * from usuarios;
select * from likes;
select * from favorite;