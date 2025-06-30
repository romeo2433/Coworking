CREATE TABLE option(
   id_option INTEGER,
   code VARCHAR(50)  NOT NULL,
   option VARCHAR(100)  NOT NULL,
   prix NUMERIC(15,2)   CHECK(prix >= 0),
   PRIMARY KEY(id_option),
   UNIQUE(code)
);

CREATE TABLE espace(
   id_espace INTEGER,
   nom VARCHAR(100)  NOT NULL,
   prix_heure NUMERIC(15,2)   CHECK(prix_heure >= 0),
   PRIMARY KEY(id_espace),
   UNIQUE(nom)
);

CREATE TABLE profil(
   id_profil INTEGER,
   profil VARCHAR(50) ,
   PRIMARY KEY(id_profil),
   UNIQUE(profil)
);

   CREATE TABLE status(
      id_status INTEGER,
      status VARCHAR(100)  NOT NULL,
      PRIMARY KEY(id_status),
      UNIQUE(status)
   );

CREATE TABLE configuration_horaire(
   id_conf INTEGER,
   heure_debut INTEGER NOT NULL,
   heure_fin INTEGER NOT NULL,
   PRIMARY KEY(id_conf)
);

CREATE TABLE utilisateur(
   id_utilisateur INTEGER,
   numero VARCHAR(100) ,
   mdp VARCHAR(255) ,
   email VARCHAR(50) ,
   id_profil INTEGER NOT NULL,
   PRIMARY KEY(id_utilisateur),
   UNIQUE(numero),
   UNIQUE(email),
   FOREIGN KEY(id_profil) REFERENCES profil(id_profil)
);

CREATE TABLE reservation(
   id_reservation INTEGER,
   reference VARCHAR(50)  NOT NULL,
   date_reservation DATE NOT NULL,
   heure_debut TIME NOT NULL,
   duree INTEGER NOT NULL,
   total NUMERIC(15,2)  ,
   id_espace INTEGER NOT NULL,
   id_utilisateur INTEGER NOT NULL,
   PRIMARY KEY(id_reservation),
   FOREIGN KEY(id_espace) REFERENCES espace(id_espace),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE paiement(
   id_paiement INTEGER,
   reference VARCHAR(100)  NOT NULL,
   date_paiement DATE,
   id_reservation INTEGER NOT NULL,
   PRIMARY KEY(id_paiement),
   UNIQUE(reference),
   FOREIGN KEY(id_reservation) REFERENCES reservation(id_reservation)
);

CREATE TABLE option_reservation(
   id_option INTEGER,
   id_reservation INTEGER,
   PRIMARY KEY(id_option, id_reservation),
   FOREIGN KEY(id_option) REFERENCES option(id_option),
   FOREIGN KEY(id_reservation) REFERENCES reservation(id_reservation)
);

CREATE TABLE status_reservation(
   id_reservation INTEGER,
   id_status INTEGER,
   date_status TIMESTAMP NOT NULL,
   PRIMARY KEY(id_reservation, id_status),
   FOREIGN KEY(id_reservation) REFERENCES reservation(id_reservation),
   FOREIGN KEY(id_status) REFERENCES status(id_status)
);

INSERT INTO profils (id_profil, profil) VALUES(1, 'Admin'),(2, 'Client');

INSERT INTO statuses (id_status, status) VALUES
(1, 'Fait'),
(2, 'A payer'),
(3, 'En attente'),
(4, 'Payé');

INSERT INTO utilisateurs (email, mdp, id_profil) 
VALUES ('romeomahefaromeo@gmail.com', 'abcd', 1);

ALTER TABLE espaces ALTER COLUMN id_espace SET DEFAULT nextval('espaces_id_espace_seq');
ALTER TABLE status_reservation
ADD CONSTRAINT unique_id_reservation UNIQUE (id_reservation);



php artisan migrate:fresh --seed

SELECT
    r.date_reservation,
    SUM(r.total) AS chiffre_affaires
FROM
    reservations r
JOIN (
    SELECT DISTINCT ON (sr.id_reservation)
        sr.id_reservation,
        sr.id_status,
        sr.date_status
    FROM status_reservation sr
    ORDER BY sr.id_reservation, sr.date_status DESC
) latest_status ON r.id_reservation = latest_status.id_reservation
WHERE
    latest_status.id_status = 4 -- "Payé"
GROUP BY
    r.date_reservation
ORDER BY
    r.date_reservation;
