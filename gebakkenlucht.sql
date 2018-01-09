/* Drop Tables */
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `products` CASCADE
;

DROP TABLE IF EXISTS `customers` CASCADE
;

DROP TABLE IF EXISTS `orders` CASCADE
;

DROP TABLE IF EXISTS `categories` CASCADE
;

DROP TABLE IF EXISTS `order_products` CASCADE
;

/* Create Tables */

CREATE TABLE `categories`
(
	`id` INT AUTO_INCREMENT,
	`category` VARCHAR(50),
	PRIMARY KEY (`id` ASC)
)

;

CREATE TABLE `customers`
(
	`id` INT AUTO_INCREMENT,
	`firstName` VARCHAR(50),
	`lastName` VARCHAR(50),
	`address` VARCHAR(50),
	`postalCode` VARCHAR(50),
	`city` VARCHAR(50),
	`country` VARCHAR(50) NULL,
	`phoneNumber` VARCHAR(50) NULL,
	`IBAN` VARCHAR(37) NULL,
	`IBANholder` VARCHAR(50) NULL,
	PRIMARY KEY (`id` ASC)
)

;

CREATE TABLE `orders`
(
	`id` INT AUTO_INCREMENT,
	`orderedAt` TIMESTAMP,
	`status` INT DEFAULT 1,
	`totalPrice` INT,
	`customer_id` INT,
	PRIMARY KEY (`id` ASC),
	FOREIGN KEY (`customer_id`) REFERENCES customers(`id`)
)

;

CREATE TABLE `products`
(
	`id` INT AUTO_INCREMENT,
	`name` VARCHAR(50),
	`price` INT,
	`description` LONGTEXT NULL,
	`amountInStock` INT NULL,
	`category_id` INT,
	PRIMARY KEY (`id` ASC),
	FOREIGN KEY (`category_id`) REFERENCES categories(`id`)
)

;

CREATE TABLE `order_products`
(
	`id` INT AUTO_INCREMENT,
	`amount` INT DEFAULT 1,
	`order_id` INT,
	`product_id` INT,
	PRIMARY KEY (`id` ASC),
	FOREIGN KEY (`order_id`) REFERENCES orders(`id`),
	FOREIGN KEY (`product_id`) REFERENCES products(`id`)
)

;

SET FOREIGN_KEY_CHECKS=1;

/* Seed tables */


INSERT INTO `categories` (
	`category`
) VALUES (
	"luchtflessen"
);

INSERT INTO `categories` (
	`category`
) VALUES (
	"luchtkastelen"
);

INSERT INTO `products` (
	`name`, `price`, `description`, `amountInStock`, `category_id`
) VALUES (
	"Gebakken Lucht", 1500, "Zeer praktisch, gebakken lucht vers uit een fles!", 50, 1
);

INSERT INTO `products` (
	`name`, `price`, `description`, `amountInStock`, `category_id`
) VALUES (
	"XXL luchtkasteel", 15000, "Super lomp groot kasteel voor in de lucht.", 2, 2
);

INSERT INTO `customers` (
`id` ,
`firstName` ,
`lastName` ,
`address` ,
`postalCode` ,
`city` ,
`country` ,
`phoneNumber` ,
`IBAN` ,
`IBANholder`
)
VALUES (
NULL , 'Theo', 'de Vries', 'Straatweg 30', '1234AB', 'Enschede', 'Nederland', '06-12345678', 'NL12ABCD3456789012', 't. de vries'
);

INSERT INTO `customers` (
`id` ,
`firstName` ,
`lastName` ,
`address` ,
`postalCode` ,
`city` ,
`country` ,
`phoneNumber` ,
`IBAN` ,
`IBANholder`
)
VALUES (
NULL , 'Hans', 'Janssen', 'Hoofdstraat 22', '5432EZ', 'Rotterdam', 'Nederland', '06-98765432', 'NL09QWER7654321098', 'h. janssen'
);

INSERT INTO `orders` (
`id` ,
`orderedAt` ,
`status` ,
`totalPrice` ,
`customer_id`
)
VALUES (
NULL ,
CURRENT_TIMESTAMP , '1', '1500', '1'
);

INSERT INTO `order_products` (
`id` ,
`amount` ,
`order_id` ,
`product_id`
)
VALUES (
NULL , '1', '1', '1'
);

INSERT INTO `orders` (
`id` ,
`orderedAt` ,
`status` ,
`totalPrice` ,
`customer_id`
)
VALUES (
NULL ,
CURRENT_TIMESTAMP , '1', '15000', '1'
);

INSERT INTO `order_products` (
`id` ,
`amount` ,
`order_id` ,
`product_id`
)
VALUES (
NULL , '1', '2', '2'
);

INSERT INTO `orders` (
`id` ,
`orderedAt` ,
`status` ,
`totalPrice` ,
`customer_id`
)
VALUES (
NULL ,
CURRENT_TIMESTAMP , '1', '16500', '2'
);

INSERT INTO `order_products` (
`id` ,
`amount` ,
`order_id` ,
`product_id`
)
VALUES (
NULL , '1', '3', '1'
);

INSERT INTO `order_products` (
`id` ,
`amount` ,
`order_id` ,
`product_id`
)
VALUES (
NULL , '1', '3', '2'
);
