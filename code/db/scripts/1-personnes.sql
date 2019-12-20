CREATE TABLE `personne` (
  `id` int(11) NOT NULL,
  `date_crea_enr` timestamp NOT NULL,
  `date_modif_enr` timestamp,
  `code_user_to_update` varchar(255),
  `code_user_to_create` varchar(255) NOT NULL,
  `code_civilite` varchar(10),
  `code_sexe` varchar(5) NOT NULL,
  `date_naissance` timestamp NOT NULL,
  `date_token_activation` timestamp,
  `date_token_mdp` timestamp,
  `email` varchar(30) NOT NULL,
  `motdepasse` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `role` varchar(15) NOT NULL,
  `token_activation` varchar(50),
  `token_mdp` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `personne` ADD PRIMARY KEY (`id`);
ALTER TABLE `personne` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `personne` (`id`, `date_crea_enr`, `date_modif_enr`, `code_user_to_update`, `code_user_to_create`, `code_civilite`, `code_sexe`, `date_naissance`, `date_token_activation`, `date_token_mdp`, `email`, `motdepasse`, `nom`, `prenom`, `role`, `token_activation`, `token_mdp`) VALUES
(1, '2019-12-17 15:13:08', '2019-12-17 15:13:08', 'pacouley@gmail.com', '', 'M.', '1', '2000-10-18 22:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'pacouley@gmail.com', '74b87337454200d4d33f80c4663dc5e5', 'Nomtest1', 'PrenomTest1', 'ADMIN', '1', '1'),
(2, '2019-11-29 04:46:11', '2019-11-29 04:38:08', 'pacouley@gmail.com', '', '', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'zeze@sylvain.fr', '74b87337454200d4d33f80c4663dc5e5', 'NomTest2', 'PrenomTest2', 'RPINT', '1', '1');
