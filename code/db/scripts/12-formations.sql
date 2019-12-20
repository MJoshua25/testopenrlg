CREATE TABLE `formations` (
  `id` int(11) NOT NULL,
  `code_user_to_create` varchar(255) NOT NULL,
  `code_user_to_update` varchar(255),
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `date_formation` timestamp,
  `sujet` varchar(20) NOT NULL, 
  `type_formation` varchar(20) NOT NULL, 
  `analyse_formation` varchar(255) NOT NULL, 
  `personnefk` int(11) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `formations` ADD PRIMARY KEY (`id`);
ALTER TABLE `formations` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `formations` ADD FOREIGN KEY (personnefk) REFERENCES personne(`id`);