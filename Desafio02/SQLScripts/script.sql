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

UPDATE products set status = 1 WHERE product_id = 1;

INSERT INTO products (title,price,description,category,image) VALUES
	 ('Solid Gold Petite Micropave ',168.00,'Satisfaction Guaranteed. Return or exchange any order within 30 days.Designed and sold by Hafeez Center in the United States. Satisfaction Guaranteed. Return or exchange any order within 30 days.','jewelery','https://fakestoreapi.com/img/61sbMiUnoGL._AC_UL640_QL65_ML3_.jpg'),
	 ('White Gold Plated Princess',9.99,'Classic Created Wedding Engagement Solitaire Diamond Promise Ring for Her. Gifts to spoil your love more for Engagement, Wedding, Anniversary, Valentine''s Day...','jewelery','https://fakestoreapi.com/img/71YAIFU48IL._AC_UL640_QL65_ML3_.jpg'),
	 ('MBJ Women''s Solid Short Sleeve Boat Neck V ',9.85,'95% RAYON 5% SPANDEX, Made in USA or Imported, Do Not Bleach, Lightweight fabric with great stretch for comfort, Ribbed on sleeves and neckline / Double stitching on bottom hem','women''s clothing','https://fakestoreapi.com/img/71z3kpMAYsL._AC_UY879_.jpg');
INSERT INTO ratings (rate,count,product_id) VALUES
	 (4.50,100,1),
	 (4.50,100,2),
	 (4.50,100,3);
SELECT * FROM products;
SELECT * FROM ratings;
