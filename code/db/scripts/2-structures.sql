CREATE TABLE `structures` (
  `id` int(11) NOT NULL,
  `code_user_to_create` varchar(255) NOT NULL,
  `code_user_to_update` varchar(255),
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code` varchar(50) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `typeorganisme` varchar(20) NOT NULL,
  `typestructure` varchar(20) NOT NULL,
  `adresse1` varchar(255) NOT NULL,
  `adresse2` varchar(255),
  `code_postal` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `email` varchar(50),
  `telephone` varchar(50),
  `fax` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `structures` ADD PRIMARY KEY (`id`);
ALTER TABLE `structures` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `structures` (`id`, `code_user_to_create`, `code_user_to_update`, `date_crea_enr`, `date_modif_enr`, `code`, `libelle`, `typeorganisme`, `typestructure`, `adresse1`, `adresse2`, `code_postal`, `ville`, `email`, `telephone`, `fax`) VALUES
(1, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '1_RLG_35', 'CHU Rennes', 'DEMANDEUR_PAYEUR', 'HOPITAUX', 'rue du metro', 'a cote du DIM', '35000', 'RENNES', 'pacouley@gmail.com', '0299124578', '0299210080'),
(2, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '2_RLG_35', 'CHU Hôtel Dieu', 'PAYEUR', 'HOPITAUX', '', '', '44000', 'NANTES', '', '', ''),
(3, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '4_RLG_35', 'Metissage 35', 'DEMANDEUR_PAYEUR', 'ASSOCIATIONS', '', '', '', '', '', '', ''),
(4, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '5_RLG_35', 'Aide Ivoire 35', 'PAYEUR', 'ASSOCIATIONS', 'adresse 1', 'adresse 2', '22000', 'RENNES', '', '', ''),
(5, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '6_RLG_35', 'Bourgainvilliers', 'DEMANDEUR', 'ASSOCIATIONS', '', '', '', '', '', '', ''),
(6, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '7_RLG_35', 'Conseil regional Bretagne', 'DEMANDEUR_PAYEUR', 'COLLECTIVITES', '', '', '', '', '', '', ''),
(7, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '8_RLG_35', 'Conseil departemental Ill-et-vilaine', 'PAYEUR', 'COLLECTIVITES', '', '', '', '', '', '', ''),
(8, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '9_RLG_35', 'Ministere du social', 'DEMANDEUR', 'COLLECTIVITES', '', '', '', '', '', '', ''),
(9, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '10_RLG_35', 'CCAS Paton', 'DEMANDEUR', 'ASSOCIATIONS', 'adresse 1', 'adresse2', '22000', 'RENNES', 'paco@yahoo.fr', '0299741258', '0299741258'),
(10, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '11_RLG_35', 'CCAS VilleJean', 'PAYEUR', 'MEDICO_SOCIAUX', '', '', '', '', '', '', ''),
(11, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '12_RLG_35', 'CCAS Montfort', 'DEMANDEUR', 'MEDICO_SOCIAUX', '', '', '', '', '', '', ''),
(12, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '13_RLG_35', 'College Louis Guilloux', 'DEMANDEUR', 'AUTRES', '', '', '', '', '', '', ''),
(13, 'pacouley@gmail.com', '', '2019-10-18', '0000-00-00', '14_RLG_35', 'Lycee Chateau Briant', 'PAYEUR', 'AUTRES', '', '', '', '', '', '', '');
