CREATE TABLE `contrats` (
  `id` int(11) NOT NULL,
  `code_user_to_create` varchar(255) NOT NULL,
  `code_user_to_update` varchar(255),
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `date_contrat` timestamp,
  `nb_heures` varchar(255) NOT NULL,
  `periodicite` varchar(20) NOT NULL,
  `typecontrat` varchar(20) NOT NULL,
  `date_medecin_travail` timestamp,
  `date_entretien` timestamp,
  `entretien_stagiaire` varchar(255) NOT NULL,
  `personnefk` int(11) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `contrats` ADD PRIMARY KEY (`id`);
ALTER TABLE `contrats` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `contrats` ADD FOREIGN KEY (personnefk) REFERENCES personne(`id`);