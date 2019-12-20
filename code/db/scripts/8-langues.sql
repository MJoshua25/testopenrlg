CREATE TABLE `langues` (
  `id` int(11) NOT NULL,
  `code_user_to_create` varchar(255) NOT NULL,
  `code_user_to_update` varchar(255),
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code` varchar(50) NOT NULL,
  `libelle` varchar(255) NOT NULL,  
  `lotlanguefk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `langues` ADD PRIMARY KEY (`id`);
ALTER TABLE `langues` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `langues` ADD FOREIGN KEY (lotlanguefk) REFERENCES lotslangues(`id`);