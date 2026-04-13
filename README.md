# Guide d'installation détaillé - Cabinet Médical

Ce document explique étape par étape comment installer et configurer l'application **Cabinet Médical** sur votre machine.

---

##  Prérequis

Avant de commencer, assurez-vous d'avoir installé :

| Logiciel | Version minimale | Lien de téléchargement |
|----------|------------------|------------------------|
| PHP | 8.1 ou 8.2 | https://www.php.net/downloads |
| Composer | 2.x | https://getcomposer.org/download/ |
| MySQL | 8.0 | https://dev.mysql.com/downloads/ |
| Node.js | 18.x | https://nodejs.org/ |
| XAMPP/WAMP | (pour Windows) | https://www.apachefriends.org/ |

---

##  Installation étape par étape

### 1. Installer XAMPP (Windows)

1. Téléchargez XAMPP depuis https://www.apachefriends.org/
2. Lancez l'installateur
3. Cliquez **"Suivant"** jusqu'à la fin
4. Lancez **XAMPP Control Panel**
5. Démarrez **Apache** et **MySQL** (bouton Start)

### 2. Installer Composer

1. Téléchargez Composer depuis https://getcomposer.org/download/
2. Lancez l'installateur
3. Sélectionnez `C:\xampp\php\php.exe` comme chemin PHP
4. Terminez l'installation

### 3. Installer Node.js$user = User::create

1. Téléchargez Node.js depuis https://nodejs.org/
2. Choisissez la version **LTS**
3. Lancez l'installateur (tout accepter par défaut)
4. Redémarrez votre ordinateur

---

##  Récupérer le projet

### Option 1 : Cloner depuis GitHub

```bash
git clone git clone https://github.com/SalmaAasem/cabinet-medical-laravel
cd cabinet-medical