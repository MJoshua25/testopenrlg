CREATE TABLE `interpretes` (
  `id` int(11) NOT NULL,
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code_user_to_update` varchar(255),
  `code_user_to_create` varchar(255) NOT NULL,  
  `nom_marital` varchar(255) NOT NULL,
  `date_naissance` timestamp NOT NULL,
  `date_debut` timestamp NOT NULL,
  `date_fin` timestamp,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `code_postal` varchar(255) NOT NULL,  
  `is_actif` int(2) NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `num_sec_sociale` varchar(255) NOT NULL,
  `permis_vehicule` int(2),
  `ch_fisc_vehicule` int(2),
  `tel_perso` varchar(255) NOT NULL,
  `tel_pro` varchar(255) NOT NULL,
  `personnefk` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `interpretes` ADD PRIMARY KEY (`id`,`personnefk`);
ALTER TABLE `interpretes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `interpretes` ADD FOREIGN KEY (personnefk) REFERENCES personne(`id`);

-- lien documents_interpretes
CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code_user_to_update` varchar(255),
  `code_user_to_create` varchar(255) NOT NULL,  
  `nom` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `typedocument` varchar(20) NOT NULL,
  `taille` varchar(255) NOT NULL,
  `document` BLOB NOT NULL ,
  `personnefk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `documents` ADD PRIMARY KEY (`id`);
ALTER TABLE `documents` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `documents` ADD FOREIGN KEY (personnefk) REFERENCES personne(`id`);

-- liste de langues
CREATE TABLE `langues_interprete` (
  `id` int(11) NOT NULL,
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code_user_to_update` varchar(255),
  `code_user_to_create` varchar(255) NOT NULL,
  `personnefk` int(11) NOT NULL ,  
  `languefk` int(11) DEFAULT NULL,
  `langue_orale` int(2) DEFAULT NULL,
  `langue_ecrite` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `langues_interprete` ADD PRIMARY KEY (`id`,`personnefk`,`languefk`);
ALTER TABLE `langues_interprete` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `langues_interprete` ADD FOREIGN KEY (personnefk) REFERENCES personne(`id`);
ALTER TABLE `langues_interprete` ADD FOREIGN KEY (languefk) REFERENCES langues(`id`);