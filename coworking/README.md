# Coworking

## Description
Application web de gestion d’espaces de coworking permettant la réservation, la gestion des paiements et le suivi des statistiques.

## Technologies utilisées
- PHP (Laravel)
- JavaScript
- Postgres
- HTML / CSS
- framework : Bootstrap
- Docker


## Installation
1. Clone le dépôt  
```bash
git clone https://github.com/romeo2433/Coworking.git

Si Linux 
# Mettre à jour les paquets
sudo apt update
sudo apt install -y ca-certificates curl gnupg lsb-release


# Installer Docker Engine, CLI et containerd
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

docker --version


sudo groupadd docker
sudo usermod -aG docker $USER
newgrp docker


docker compose version
        Tu dois voir une version, exemple :
        Docker Compose version v2.20.0

# Lancement du projet dans local 
docker compose up -d --build
sudo chmod -R 777 storage



#  Acceder a la base de donnes 
docker exec -it laravel_postgres psql -U postgres -d coworking

Si tu es sur Windows je te souhaite de me contacter si il y a des problemes sur le fonctionnement 
