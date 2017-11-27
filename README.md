mysql -uuser -p 
drop database if exists supbot;
create database supbot character set=utf8; 
use supbot;
CREATE TABLE clients (
client_id int(11) NOT NULL, 
first_name varchar(50) DEFAULT NULL, 
last_name varchar(50) DEFAULT NULL, 
avatar varchar(20) DEFAULT NULL, 
favorite tinyint DEFAULT 0 NOT NULL, 
PRIMARY KEY (client_id));
CREATE TABLE messages (
id int(11) NOT NULL AUTO_INCREMENT, 
text text DEFAULT NULL, 
chat_id int(11) NOT NULL, 
time varchar(20) NOT NULL, 
favorite tinyint DEFAULT 0 NOT NULL,
message_id int(11) NOT NULL, 
edited tinyint default 0 NOT NULL, 
PRIMARY KEY (id)
);
3.Создать в mysql нового пользователя "supbot" c паролем "pass" и дать права на БД supbot. 
CREATE USER 'supbot'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON supbot.* TO 'supbot'@'localhost';
