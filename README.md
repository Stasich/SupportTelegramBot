Создаём БД
1. mysql -uroot -p
2. drop database if exists supbot;
3. create database supbot character set=utf8mb4; 
4. use supbot;
5. CREATE TABLE clients (
client_id int(11) NOT NULL, 
first_name varchar(50) DEFAULT NULL, 
last_name varchar(50) DEFAULT NULL, 
avatar varchar(20) DEFAULT NULL, 
favorite tinyint DEFAULT 0 NOT NULL, 
PRIMARY KEY (client_id));
6. CREATE TABLE owners (
id int not null auto_increment,
type varchar(10) not null,
PRIMARY KEY (id)
);
7. insert into owners (type) values ('client'), ('support');
8. CREATE TABLE messages (
id int(11) NOT NULL AUTO_INCREMENT, 
text text DEFAULT NULL, 
chat_id int(11) NOT NULL, 
time int(11) NOT NULL, 
checked tinyint DEFAULT 0 NOT NULL,
message_id int(11) NOT NULL, 
edited tinyint default 0 NOT NULL,
owner int(11) NOT NULL DEFAULT 1, 
PRIMARY KEY (id),
FOREIGN KEY (chat_id) REFERENCES clients (client_id),
FOREIGN KEY (owner) REFERENCES owners (id)
);
9. Создать в mysql нового пользователя "supbot" c паролем "pass" и дать права на БД supbot. 
CREATE USER 'supbot'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON supbot.* TO 'supbot'@'localhost';
