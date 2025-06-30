CREATE TABLE option (
   id_option SERIAL PRIMARY KEY,
   code VARCHAR(50) NOT NULL UNIQUE,
   option VARCHAR(100) NOT NULL,
   prix NUMERIC(15,2) CHECK(prix >= 0)
);

CREATE TABLE espace (
   id_espace SERIAL PRIMARY KEY,
   nom VARCHAR(100) NOT NULL UNIQUE,
   prix_heure NUMERIC(15,2) CHECK(prix_heure >= 0)
);

CREATE TABLE profil (
   id_profil SERIAL PRIMARY KEY,
   profil VARCHAR(50) UNIQUE
);

CREATE TABLE status (
   id_status SERIAL PRIMARY KEY,
   status VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE configuration_horaire (
   id_conf SERIAL PRIMARY KEY,
   heure_debut INTEGER NOT NULL,
   heure_fin INTEGER NOT NULL
);

CREATE TABLE utilisateur (
   id_utilisateur SERIAL PRIMARY KEY,
   numero VARCHAR(100) UNIQUE,
   mdp VARCHAR(255),
   email VARCHAR(50) UNIQUE,
   id_profil INTEGER NOT NULL,
   FOREIGN KEY(id_profil) REFERENCES profil(id_profil)
);

CREATE TABLE reservation (
   id_reservation SERIAL PRIMARY KEY,
   reference VARCHAR(50) NOT NULL,
   date_reservation DATE NOT NULL,
   heure_debut TIME NOT NULL,
   duree INTEGER NOT NULL,
   total NUMERIC(15,2),
   id_espace INTEGER NOT NULL,
   id_utilisateur INTEGER NOT NULL,
   FOREIGN KEY(id_espace) REFERENCES espace(id_espace),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE paiement (
   id_paiement SERIAL PRIMARY KEY,
   reference VARCHAR(100) NOT NULL UNIQUE,
   date_paiement DATE,
   id_reservation INTEGER NOT NULL,
   FOREIGN KEY(id_reservation) REFERENCES reservation(id_reservation)
);

CREATE TABLE option_reservation (
   id_option INTEGER,
   id_reservation INTEGER,
   PRIMARY KEY(id_option, id_reservation),
   FOREIGN KEY(id_option) REFERENCES option(id_option),
   FOREIGN KEY(id_reservation) REFERENCES reservation(id_reservation)
);

CREATE TABLE status_reservation (
   id_reservation INTEGER,
   id_status INTEGER,
   date_status TIMESTAMP NOT NULL,
   PRIMARY KEY(id_reservation, id_status),
   FOREIGN KEY(id_reservation) REFERENCES reservation(id_reservation),
   FOREIGN KEY(id_status) REFERENCES status(id_status)
);

-- Insertion des données

INSERT INTO profil (id_profil, profil) VALUES
(1, 'Admin'),
(2, 'Client');

INSERT INTO status (id_status, status) VALUES
(1, 'Fait'),
(2, 'A payer'),
(3, 'En attente'),
(4, 'Payé');

INSERT INTO utilisateur (email, mdp, id_profil) 
VALUES ('romeomahefaromeo@gmail.com', 'abcd', 1);

ALTER TABLE status_reservation
ADD CONSTRAINT unique_id_reservation UNIQUE (id_reservation);
