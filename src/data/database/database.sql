# database CPT Meeting Room Scheduler
CREATE DATABASE cptmrs;

# tipo_utente table
CREATE TABLE `cptmrs`.`tipo_utente` (
`nome` VARCHAR(50) NOT NULL,
`creazione_utenti` BIT NOT NULL DEFAULT 0,
`eliminazione_utenti` BIT NOT NULL DEFAULT 0,
`promozione_utenti` BIT NOT NULL DEFAULT 0,
`visione_prenotazioni` BIT NOT NULL DEFAULT 0,
`inserimento_prenotazioni` BIT NOT NULL DEFAULT 0,
`cancellazione_prenotazioni_personali` BIT NOT NULL DEFAULT 0,
`cancellazione_prenotazioni_altri_utenti` BIT NOT NULL DEFAULT 0,
PRIMARY KEY (`nome`));

# utente table
CREATE TABLE `cptmrs`.`utente` (
  `email` VARCHAR(255) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `cognome` VARCHAR(100) NOT NULL,
  `tipo_utente` VARCHAR(50) NOT NULL,
  `default_password_changed` BIT NOT NULL DEFAULT 0,
  PRIMARY KEY (`email`),
  INDEX `fk_utente_tipo:utente_idx` (`tipo_utente` ASC),
  CONSTRAINT `fk_utente_tipoutente`
  FOREIGN KEY (`tipo_utente`)
  REFERENCES `cptmrs`.`tipo_utente` (`nome`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

# riservazione table
CREATE TABLE `cptmrs`.`riservazione` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `data` DATE NOT NULL,
  `ora_inizio` TIME NOT NULL,
  `ora_fine` TIME NOT NULL,
  `osservazioni` VARCHAR(512) NULL,
  `utente` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_riservazione_utente_idx` (`utente` ASC),
  CONSTRAINT `fk_riservazione_utente`
  FOREIGN KEY (`utente`)
  REFERENCES `cptmrs`.`utente` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

# tipo_mail table
CREATE TABLE `cptmrs`.`tipo_mail` (
  `nome` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`nome`));

# email table
CREATE TABLE `cptmrs`.`email` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `url_conferma` VARCHAR(512) NOT NULL,
  `sent_at_datetime` DATETIME NOT NULL,
  `expiration_datetime` DATETIME NOT NULL,
  `utente` VARCHAR(255) NOT NULL,
  `riservazione` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_email_utente_idx` (`utente` ASC),
  INDEX `fk_email_riservazione_idx` (`riservazione` ASC),
  CONSTRAINT `fk_email_utente`
  FOREIGN KEY (`utente`)
  REFERENCES `cptmrs`.`utente` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_email_riservazione`
  FOREIGN KEY (`riservazione`)
  REFERENCES `cptmrs`.`riservazione` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
