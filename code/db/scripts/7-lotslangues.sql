CREATE TABLE `lotslangues` (
  `id` int(11) NOT NULL,
  `code_user_to_create` varchar(255) NOT NULL,
  `code_user_to_update` varchar(255),
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code` varchar(50) NOT NULL,
  `libelle` varchar(255) NOT NULL,  
  `marchefk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `lotslangues` ADD PRIMARY KEY (`id`);
ALTER TABLE `lotslangues` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `lotslangues` ADD FOREIGN KEY (marchefk) REFERENCES marches(`id`);

