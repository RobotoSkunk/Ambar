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

CREATE TABLE parent_category (
	id INT AUTO_INCREMENT,
	c_name VARCHAR(30) NOT NULL,
	
	PRIMARY KEY (id)
);

CREATE TABLE categories (
	id INT AUTO_INCREMENT,
	c_name VARCHAR(60) NOT NULL,
	parent INT,
	
	PRIMARY KEY (id),
	FOREIGN KEY (parent) REFERENCES parent_category (id)
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

CREATE TABLE shopping (
	id INT AUTO_INCREMENT,
	uuid INT NOT NULL,
	proid INT NOT NULL,
	quantity INT NOT NULL,
	bought BOOLEAN,
	
	PRIMARY KEY (id),
	FOREIGN KEY (uuid) REFERENCES users (id),
	FOREIGN KEY (proid) REFERENCES products (id)
);

CREATE TABLE tokens (
	id INT AUTO_INCREMENT,
	uuid INT NOT NULL,
	selector VARCHAR(60) NOT NULL UNIQUE,
	token TINYTEXT NOT NULL,
	created_at DATETIME NOT NULL,
	last_usage DATETIME NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (uuid) REFERENCES users (id)
);

------------------------------------------------------------------------

INSERT INTO parent_category (c_name) VALUES
	("Cafés de origen"),
	("De cacao"),
	("Miel de abeja"),
	("Artesania")
;

INSERT INTO categories (c_name, parent) VALUES
	("Café orgánico tostado y molido", 1),
	("Café orgánico soluble", 1),
	("Café orgánico gourmet tostado y molido", 1),
	("Café orgánico en grano tostado", 1),
	("Café liofilizado", 1),

	("Chocolate miel con cacao untable", 2),
	("Nibs de cacao", 2),
	("Barra de licor de cacao", 2),
	("Barra de chocolate oscuro", 2),
	("Barra de chocolate de mesa", 2),

	("Miel diferenciada por floración", 3),
	("Miel multiflora orgánica", 3),
	("Miel multiflora mantequilla", 3),
	("Miel de abeja melipona", 3),

	("De madera", 4),
	("De hoja de pino", 4),

	("Cuidado de la piel", NULL),
	("Herbolaria", NULL)
;

