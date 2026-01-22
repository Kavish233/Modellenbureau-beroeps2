-- SQL script om ProfielFoto kolom toe te voegen aan USERS tabel
ALTER TABLE `USERS` 
ADD COLUMN `ProfielFoto` VARCHAR(255) DEFAULT NULL AFTER `wachtwoord`;
