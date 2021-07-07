-- MySQL
CREATE DATABASE obio;

-- ProID = Productor ID
-- PID = Producto ID
-- UUID = Usuario ID
-- CID = Categoría ID

CREATE TABLE users (
	id INT AUTO_INCREMENT,
	u_name VARCHAR(60) NOT NULL,
	u_lastname VARCHAR(60) NOT NULL,
	email VARCHAR(60) NOT NULL,
	pwrd TINYTEXT NOT NULL,
	direction TINYTEXT NOT NULL,
	cp INT NOT NULL,
	telephone VARCHAR(10) NOT NULL,
	birthdate DATE NOT NULL,
	
	PRIMARY KEY (id)
);

CREATE TABLE cards (
	id INT AUTO_INCREMENT,
	uuid INT NOT NULL,
	card_number VARCHAR(30) NOT NULL,
	end_date DATE NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (uuid) REFERENCES users (id)
);

CREATE TABLE producers (
	id INT AUTO_INCREMENT,
	p_name varchar(60) NOT NULL,
	p_desc LONGTEXT NOT NULL,
	city varchar(30) NOT NULL,
	
	PRIMARY KEY (id)
);

CREATE TABLE categories (
	id INT AUTO_INCREMENT,
	c_name VARCHAR(30) NOT NULL,
	
	PRIMARY KEY (id)
);

CREATE TABLE products (
	id INT AUTO_INCREMENT,
	cid INT NOT NULL,
	proid INT NOT NULL,
	p_name VARCHAR(30) NOT NULL,
	price INT NOT NULL,
	p_desc LONGTEXT NOT NULL,
	stock INT NOT NULL,
	
	PRIMARY KEY (id),
	FOREIGN KEY (cid) REFERENCES categories (id),
	FOREIGN KEY (proid) REFERENCES producers (id)
);

CREATE TABLE presentation (
	id INT AUTO_INCREMENT,
	pid INT NOT NULL,
	p_name VARCHAR(30) NOT NULL,
	picture VARCHAR(120),

	PRIMARY KEY (id),
	FOREIGN KEY (pid) REFERENCES products (id) 
);

CREATE TABLE features (
	id INT AUTO_INCREMENT,
	pid INT NOT NULL,
	f_name VARCHAR(30) NOT NULL,
	f_data TINYTEXT NOT NULL,
	
	PRIMARY KEY (id),
	FOREIGN KEY (pid) REFERENCES products (id)
);

CREATE TABLE producers_pref (
	id INT AUTO_INCREMENT,
	uuid INT NOT NULL,
	proid INT NOT NULL,
	
	PRIMARY KEY (id),
	FOREIGN KEY (proid) REFERENCES products (id),
	FOREIGN KEY (uuid) REFERENCES users (id)
);

CREATE TABLE categories_pref (
	id INT AUTO_INCREMENT,
	uuid INT NOT NULL,
	cid INT NOT NULL,
	
	PRIMARY KEY (id),
	FOREIGN KEY (uuid) REFERENCES users (id),
	FOREIGN KEY (cid) REFERENCES categories (id)
);

CREATE TABLE shopping(
	id INT AUTO_INCREMENT,
	uuid INT NOT NULL,
	proid INT NOT NULL,
	quantity INT NOT NULL,
	bought BOOLEAN,
	
	PRIMARY KEY (id),
	FOREIGN KEY (uuid) REFERENCES users (id),
	FOREIGN KEY (proid) REFERENCES products (id)
);
--REGISTROS 
--producers
INSERT INTO producers (id,p_name,p_desc, city)
VALUES ('123','cafe organico MAJOMUT','En su sabor se aprecian notas a chocolate y avellana, de suave acidez, esto como
resultado de la presencia de granos arábigos le confieren atributos en taza','Altos de Chiapas')
INSERT INTO producers (id,p_name,p_desc, city)
VALUES ('124','Alcoholatura de Ajo','Antiséptico, expectorante, reduce niveles de colesterol, antihistamínico natural ')
--categories
INSERT INTO categories (id,c_name)
values('1','CAFE MOLIDO')
INSERT INTO categories (id,c_name)
values('2','HERBOLARIA')
--products
INSERT INTO  products (id,cid,porid,p_name,price,p_desc,stock)
VALUES ('10','1','cafe organico MAJOMUT','$200','En su sabor se aprecian notas a chocolate y avellana, de suave acidez, esto como
resultado de la presencia de granos arábigos le confieren atributos en taza','200')
INSERT INTO  products (id,cid,porid,p_name,price,p_desc,stock)
VALUES ('11','2','Alcoholatura de Ajo','$100','Antiséptico, expectorante, reduce niveles de colesterol, antihistamínico natural.','200')