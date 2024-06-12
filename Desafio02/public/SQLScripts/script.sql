CREATE DATABASE MyFakeStore;
USE MyFakeStore;
CREATE TABLE products(
	product_id INT(11) NOT NULL AUTO_INCREMENT,
	title VARCHAR(50),
	price DECIMAL(10,2),
	description VARCHAR(200),
	category VARCHAR(100),
	image VARCHAR(150),
    status ENUM('inactive','active'),
	PRIMARY KEY (product_id)
);

CREATE TABLE ratings(
	review_id INT(11) NOT NULL AUTO_INCREMENT,
	rate DECIMAL(10,2),
	count INT(11),
	review_product_id INT(11),
	PRIMARY KEY (review_id),
	FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE users(
	user_id INT(11) NOT NULL AUTO_INCREMENT,
    login VARCHAR(30),
    password VARCHAR(255),
    access ENUM('admin','client'),
    PRIMARY KEY (user_id)
);

CREATE TABLE orders(
	order_id INT(11) NOT NULL AUTO_INCREMENT,
    order_user_id INT (11),
    order_date DATE,
    status ENUM('On Going','Canceled','Finished');
    PRIMARY KEY (order_id),
    FOREIGN KEY (order_user_id) REFERENCES users(user_id)
);

CREATE TABLE items(
	item_id INT(11) NOT NULL AUTO_INCREMENT,
	item_order_id INT(11),
    item_product_id INT(11),
    quantity INT(11),
    PRIMARY KEY (item_id),
    FOREIGN KEY (item_order_id) REFERENCES pedidos(order_id),
    FOREIGN KEY (item_product_id) REFERENCES products(product_id)
);

INSERT INTO products (title,price,description,category,image) VALUES
	 ('Solid Gold Petite Micropave ',168.00,'Satisfaction Guaranteed. Return or exchange any order within 30 days.Designed and sold by Hafeez Center in the United States. Satisfaction Guaranteed. Return or exchange any order within 30 days.','jewelery','https://fakestoreapi.com/img/61sbMiUnoGL._AC_UL640_QL65_ML3_.jpg'),
	 ('White Gold Plated Princess',9.99,'Classic Created Wedding Engagement Solitaire Diamond Promise Ring for Her. Gifts to spoil your love more for Engagement, Wedding, Anniversary, Valentine''s Day...','jewelery','https://fakestoreapi.com/img/71YAIFU48IL._AC_UL640_QL65_ML3_.jpg'),
	 ('MBJ Women''s Solid Short Sleeve Boat Neck V ',9.85,'95% RAYON 5% SPANDEX, Made in USA or Imported, Do Not Bleach, Lightweight fabric with great stretch for comfort, Ribbed on sleeves and neckline / Double stitching on bottom hem','women''s clothing','https://fakestoreapi.com/img/71z3kpMAYsL._AC_UY879_.jpg');
INSERT INTO ratings (rate,count,product_id) VALUES
	 (4.50,100,1),
	 (4.50,100,2),
	 (4.50,100,3);
INSERT INTO users (login, password, access) VALUES
	('admin','$2y$10$HeHm4O2QEWGE5ZE9sWZGLuIe/Bv6Cn3GnmlgphBh0Of21gwJ6kJrK',1),
    ('cliente','$2y$10$Ktc9C9GqYimlX9EC6x9cyO0fiK9zIm2vjtfEOZPWoWKZ4TBXNGysO',2);

SELECT * FROM products;
SELECT * FROM ratings;
