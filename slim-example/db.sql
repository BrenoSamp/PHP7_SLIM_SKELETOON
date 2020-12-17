CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR (100) NOT NULL,
    firstname VARCHAR (100) NOT NULL,
    lastname VARCHAR (100) NOT NULL
);

INSERT INTO usuarios (
    id,
    username,
    firstname,
    lastname
)VALUES(10,'brenim','breno','sampaio'),
(20,'marciao','marcio','dias'),
(30,'tandy','tandy','palomo'),
(40,'fernando','fernando','freitas'),
(50,'billyns','billy','willy');


