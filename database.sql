CREATE DATABASE camagru;
CREATE TABLE user 
                (id INT PRIMARY KEY AUTO_INCREMENT,
                login VARCHAR(50) NOT NULL,
                nom VARCHAR(50) NOT NULL,
                prenom VARCHAR(50) NOT NULL,
                date_de_creation DATE NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                admin TINYINT(1) DEFAULT 0 NOT NULL);
USE camagru;
INSERT INTO user (login, nom, prenom, date_de_creation, email, password, admin)
                VALUES ("El che", "Mineau", "Antoine", "2016-04-19", "amineau@student.42.fr",
                "2bk0leVxHgmy88jBwCptFkYtTHNvT2fCXDubcZbFyaF6g7VLox32c/tvipoBxgaaB29ocnWyOTaCe73KnFtN3g==",
                1);