-- MySQL Script generated by MySQL Workbench
-- Sun Nov  3 19:51:02 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sumzone` DEFAULT CHARACTER SET utf8 ;
USE `sumzone` ;

-- -----------------------------------------------------
-- Table `mydb`.`ROL`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sumzone`.`ROL` (
  `ID` INT NOT NULL DEFAULT 1,
  `descripcion_rol` VARCHAR(45) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`USUARIO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sumzone`.`USUARIO` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Email` VARCHAR(50) NOT NULL,
  `Contraseña` VARCHAR(50) NOT NULL,
  `ROL_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_USUARIO_ROL1_idx` (`ROL_ID` ASC),
  CONSTRAINT `fk_USUARIO_ROL1`
    FOREIGN KEY (`ROL_ID`)
    REFERENCES `sumzone`.`ROL` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`EVENTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sumzone`.`EVENTO` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `frecuencia` VARCHAR(15) NOT NULL,
  `horario` DATETIME NOT NULL,
  `Descripcion` VARCHAR(300) NULL,
  `tipo_evento` BINARY NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`USUARIO_EVENTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sumzone`.`INSCRIPCION` (
  `ID_usuario` INT NOT NULL,
  `ID_evento` INT NOT NULL,
  PRIMARY KEY (`ID_usuario`, `ID_evento`),
  INDEX `fk_USUARIO_has_EVENTO_EVENTO1_idx` (`ID_evento` ASC),
  INDEX `fk_USUARIO_has_EVENTO_USUARIO1_idx` (`ID_usuario` ASC),
  CONSTRAINT `fk_USUARIO_has_EVENTO_USUARIO1`
    FOREIGN KEY (`ID_usuario`)
    REFERENCES `sumzone`.`USUARIO` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_USUARIO_has_EVENTO_EVENTO1`
    FOREIGN KEY (`ID_eventos`)
    REFERENCES `sumzone`.`EVENTO` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
