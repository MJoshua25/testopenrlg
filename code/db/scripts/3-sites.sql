CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `code_user_to_create` varchar(255) NOT NULL,
  `code_user_to_update` varchar(255),
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code` varchar(50) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `typesite` varchar(20) NOT NULL,
  `adresse1` varchar(255) NOT NULL,
  `adresse2` varchar(255),
  `code_postal` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `email` varchar(50),
  `telephone` varchar(50),
  `fax` varchar(50),
  `structurefk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `sites` ADD PRIMARY KEY (`id`);
ALTER TABLE `sites` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sites` ADD FOREIGN KEY (structurefk) REFERENCES structures(`id`);