# TODO v1 -- Système de Mobile Money (CodeIgniter 4)

## 1. Initialisation du projet

- [ok] Créer un projet CodeIgniter 4
- [ok] Configurer la connexion à la base de données
- [ok] Créer le dépôt Git (Tag : `v1`)

---

# 2. Base de données

## Tables principales

### TypeOperateur

```text
id
libelle
```

### Administrateur

```text
id
nom
prenom
email
motDePasse
typeOperateur_id (FK)
```

### TypeCompte

```text
id
libelle
```

Exemple : - Standard - Marchand - Agent

### Utilisateur

```text
id
nom
prenom
cin(unique)
dateCreation
```

### Compte

```text
id
numero (UNIQUE)
motDePasse
solde
utilisateur_id (FK)
typeOperateur_id (FK)
typeCompte_id (FK)
dateCreation
```

### TypeTransaction

```text
id
libelle
```

Exemple : - Dépôt - Retrait - Transfert

### Transaction

```text
id
typeTransaction_id (FK)
dateTransaction
montant
frais
montantFinal
compteSource_id (FK)
compteDestination_id (FK)
raison
statut
```

### RelationOperateur

```text
id
libelle
```

Exemple : - Même opérateur - Opérateur différent

### Frais

```text
id
typeTransaction_id (FK)
relationOperateur_id (FK)
montantMin
montantMax
montantFrais
dateCreation
```

### PrefixeNumero

```text
id
prefixe
typeOperateur_id (FK)
dateCreation
```

---

# 3. Fonctionnalités Administrateur

- [ ] Gestion des opérateurs
- [ ] Gestion des préfixes
- [ ] Gestion des types de transactions
- [ ] Gestion des frais (CRUD)
- [ ] Situation des gains
- [ ] Situation des comptes clients
- [ ] Historique des transactions

---

# 4. Fonctionnalités Client

## Authentification

- [ ] Connexion automatique via le numéro de téléphone
- [ ] Création automatique du compte à la première connexion

## Opérations

- [ ] Voir le solde
- [ ] Dépôt (automatique)
- [ ] Retrait
- [ ] Transfert
- [ ] Historique des transactions

---

# 5. Règles de gestion

- Le numéro de téléphone est unique.
- Le préfixe identifie automatiquement l'opérateur.
- Les frais dépendent :
  - du type de transaction ;
  - de la tranche de montant ;
  - de la relation entre opérateurs.
- Le dépôt est sans frais.
- Le retrait et le transfert appliquent les frais configurés.
- Chaque transaction est enregistrée avec son statut.
- Le solde est mis à jour automatiquement.

---

# Livrable v1

- Initialisation CodeIgniter 4
- Migrations et base de données
- Authentification
- Gestion des opérateurs
- Gestion des préfixes
- Gestion des frais
- Dépôt
- Retrait
- Transfert
- Consultation du solde
- Historique
- Situation des gains
- Situation des comptes clients
- Tag Git : **v1**
