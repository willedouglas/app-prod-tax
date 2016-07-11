CREATE DATABASE IF NOT EXISTS dbProdTax;
 
USE dbProdTax;

CREATE TABLE IF NOT EXISTS Taxes (
  taxNumber INT(11) NOT NULL AUTO_INCREMENT,
  taxName VARCHAR(250) NOT NULL,
  taxDescription VARCHAR(500) NULL,
  taxPercentage DECIMAL(4,2) NOT NULL,
  PRIMARY KEY(taxNumber)
)
ENGINE=InnoDB AUTO_INCREMENT = 5;

CREATE TABLE IF NOT EXISTS Categories (
  categoryNumber INT(11) NOT NULL AUTO_INCREMENT,
  categoryName VARCHAR(250) NOT NULL,
  categoryDescription VARCHAR(500) NULL,
  categoryTaxNumber INT(11) NOT NULL,
  PRIMARY KEY(categoryNumber),
  INDEX FK_TaxCategory(categoryTaxNumber),
  FOREIGN KEY(categoryTaxNumber)
    REFERENCES Taxes(taxNumber)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
ENGINE=InnoDB AUTO_INCREMENT = 5;

CREATE TABLE IF NOT EXISTS Products (
  productNumber INT(11) NOT NULL AUTO_INCREMENT,
  productName VARCHAR(250) NOT NULL,
  productDescription VARCHAR(500) NULL,
  productPrice DECIMAL(10,2) NOT NULL,
  productCategoryNumber INT(11) NOT NULL,
  PRIMARY KEY(productNumber),
  INDEX FK_CategoryProduct(productCategoryNumber),
  FOREIGN KEY(productCategoryNumber)
    REFERENCES Categories(categoryNumber)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
ENGINE=InnoDB AUTO_INCREMENT = 5;



