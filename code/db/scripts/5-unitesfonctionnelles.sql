CREATE TABLE `unitefonctionnelles` (
  `id` int(11) NOT NULL,
  `code_user_to_create` varchar(255) NOT NULL,
  `code_user_to_update` varchar(255),
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code` varchar(50) NOT NULL,
  `libelle` varchar(255) NOT NULL,  
  `servicefk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `unitefonctionnelles` ADD PRIMARY KEY (`id`);
ALTER TABLE `unitefonctionnelles` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `unitefonctionnelles` ADD FOREIGN KEY (servicefk) REFERENCES services(`id`);