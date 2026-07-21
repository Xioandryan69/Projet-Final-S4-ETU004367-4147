-- Active: 1784529725872@@127.0.0.1@3306
PRAGMA foreign_keys = ON;

CREATE TABLE TypeOperateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL UNIQUE
);

CREATE TABLE Administrateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    motDePasse TEXT NOT NULL,
    typeOperateur_id INTEGER NOT NULL,
    FOREIGN KEY (typeOperateur_id) REFERENCES TypeOperateur (id)
);

CREATE TABLE TypeCompte (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL UNIQUE
);

CREATE TABLE Utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    cin TEXT NOT NULL UNIQUE,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE StatusCompte (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL UNIQUE
);

CREATE TABLE Compte (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero TEXT NOT NULL UNIQUE,
    motDePasse TEXT NOT NULL,
    solde REAL NOT NULL DEFAULT 0,
    utilisateur_id INTEGER NOT NULL,
    typeOperateur_id INTEGER NOT NULL,
    typeCompte_id INTEGER NOT NULL,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    idStatusCompte INTEGER,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur (id),
    FOREIGN KEY (typeOperateur_id) REFERENCES TypeOperateur (id),
    FOREIGN KEY (typeCompte_id) REFERENCES TypeCompte (id),
    FOREIGN KEY (idStatusCompte) REFERENCES StatusCompte (id)
);

CREATE TABLE TypeTransaction (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL UNIQUE
);

CREATE TABLE RelationOperateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL UNIQUE
);

CREATE TABLE Frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    typeTransaction_id INTEGER NOT NULL,
    relationOperateur_id INTEGER NOT NULL,
    montantMin REAL NOT NULL,
    montantMax REAL NOT NULL,
    montantFrais REAL NOT NULL,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (typeTransaction_id) REFERENCES TypeTransaction (id),
    FOREIGN KEY (relationOperateur_id) REFERENCES RelationOperateur (id)
);

CREATE TABLE PrefixeNumero (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL UNIQUE,
    typeOperateur_id INTEGER NOT NULL,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (typeOperateur_id) REFERENCES TypeOperateur (id)
);

CREATE TABLE StatusTransaction (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE TransactionMobile (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    typeTransaction_id INTEGER NOT NULL,
    dateTransaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    montant REAL NOT NULL,
    frais REAL NOT NULL DEFAULT 0,
    montantFinal REAL NOT NULL,
    compteSource_id INTEGER,
    compteDestination_id INTEGER,
    raison TEXT,
    statutTransaction INTEGER,
    FOREIGN KEY (statutTransaction) REFERENCES StatusTransaction (id),
    FOREIGN KEY (typeTransaction_id) REFERENCES TypeTransaction (id),
    FOREIGN KEY (compteSource_id) REFERENCES Compte (id),
    FOREIGN KEY (compteDestination_id) REFERENCES Compte (id)
);

INSERT INTO
    TypeTransaction (libelle)
VALUES ('Depot'),
    ('Retrait'),
    ('Transfert');

INSERT INTO TypeOperateur (libelle) VALUES ('033'), ('037');

INSERT INTO
    RelationOperateur (libelle)
VALUES ('Meme operateur'),
    ('Operateur different');

-- Grilles de frais de transfert : même opérateur / opérateur différent.
INSERT INTO
    Frais (
        typeTransaction_id,
        relationOperateur_id,
        montantMin,
        montantMax,
        montantFrais
    )
VALUES (3, 1, 0, 1000, 100),
    (3, 2, 0, 1000, 200);

INSERT INTO
    StatusCompte (libelle)
VALUES ('Actif'),
    ('Suspendu');

INSERT INTO
    StatusTransaction (libelle)
VALUES ('Réussi'),
    ('Échoué'),
    ('En attente');

INSERT INTO
    TypeCompte (libelle)
VALUES ('Standard'),
    ('Marchand');

CREATE TABLE commission (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pourcentage DECIMAL NOT NULL
);

CREATE TABLE mouvementAutreOperateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    typeOperateur_id INTEGER NOT NULL,
    numero VARCHAR(50) NOT NULL UNIQUE,
    commission DECIMAL(10, 2) NOT NULL,
    montantTotal DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'En attente',
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (typeOperateur_id) REFERENCES typeOperateur (id)
);

CREATE TABLE IF NOT EXISTS prom (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pourcentage DECIMAL(5, 2) NOT NULL CHECK (
        pourcentage >= 0
        AND pourcentage <= 100
    ),
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO
    prom (pourcentage, dateCreation)
VALUES (10.00, CURRENT_TIMESTAMP);

CREATE TABLE IF NOT EXISTS eparne (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pourcentage DECIMAL(5, 2) NOT NULL CHECK (
        pourcentage >= 0
        AND pourcentage <= 100
    ),
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO
    eparne (pourcentage, dateCreation)
VALUES (10.00, CURRENT_TIMESTAMP);

CREATE TABLE IF NOT EXISTS eparneCompte (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    compte_id INTEGER,
    pourcentage DECIMAL(5, 2) NOT NULL CHECK (
        pourcentage >= 0
        AND pourcentage <= 100
    ),
    FOREIGN KEY (compte_id) REFERENCES Compte (id)
);