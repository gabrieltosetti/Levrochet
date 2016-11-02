-- MySQL Script generated by MySQL Workbench
-- 11/02/16 07:57:46
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sistemahx
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sistemahx
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sistemahx` DEFAULT CHARACTER SET utf8 ;
USE `sistemahx` ;

-- -----------------------------------------------------
-- Table `sistemahx`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sistemahx`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `salt` VARCHAR(128) NOT NULL,
  `status` INT NOT NULL DEFAULT 1,
  `role_id` INT(1) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `users_role_id_idx` (`role_id` ASC),
  CONSTRAINT `users_role_id`
    FOREIGN KEY (`role_id`)
    REFERENCES `sistemahx`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sistemahx`.`login_attempts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`login_attempts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `login_attemps_user_id_idx` (`user_id` ASC),
  CONSTRAINT `login_attemps_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `sistemahx`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sistemahx`.`recoveries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`recoveries` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `status` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `passwords_user_id_idx` (`user_id` ASC),
  CONSTRAINT `passwords_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `sistemahx`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
