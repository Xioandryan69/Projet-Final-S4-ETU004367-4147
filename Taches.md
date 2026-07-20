
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



V2



## Version 2

### Coté opérateur

* Configuration des préfixes valable pour les autres opérateurs (ex: 032 et 031, …)
* Configuration % en plus de commissions pour les transferts vers les autres opérateurs
* Sur la page “Situation gain via les différents frais” , séparer opérateur et autres opérateurs
* Situation des montants à envoyer à chaque opérateur

### Coté client

* Option inclure frais de retrait lors de l’envoi
  * il n’y a pas de frais de retrait pour les autres opérateurs
* Envoi multiple vers plusieurs numéros ( divisé le montant pour chaque numéro)
  * même opérateur uniquement


+ [ ] table commision
  + [ ] id
  + [ ] valeur pourcentage
+ [ ] table MouvementAutreOperateur
  + [ ] id
  + [ ] date
  + [ ] numero
  + [ ] montant
  + [ ] date
  + [ ] statut
+ [ ] cas 1000 Ar -> personne
+ [ ] si 100 ar frais
+ [ ] si 10 % commission

```
en posant que Operateur vers un autre operateur 

yas -> orage 
100 ar -> yas 
1000 ar +10 % 1000 ar -> orange 

personne pas enconre dans le sujet 
	ty kosa ramose grave be 
```

cree models

cree controller


ajout logique dans TransactionController 

cree views adaoter
