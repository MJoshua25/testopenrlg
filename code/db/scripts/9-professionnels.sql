CREATE TABLE `professionnels` (
  `id` int(11) NOT NULL,
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code_user_to_update` varchar(255),
  `code_user_to_create` varchar(255) NOT NULL,
  `personnefk` int(11) DEFAULT NULL,
  `structurefk` int(11) DEFAULT NULL,
  `servicefk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `professionnels` ADD PRIMARY KEY (`id`,`personnefk`,`structurefk`);
ALTER TABLE `professionnels` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `professionnels` ADD FOREIGN KEY (structurefk) REFERENCES structures(`id`);
ALTER TABLE `professionnels` ADD FOREIGN KEY (servicefk) REFERENCES services(`id`);
ALTER TABLE `professionnels` ADD FOREIGN KEY (personnefk) REFERENCES personne(`id`);