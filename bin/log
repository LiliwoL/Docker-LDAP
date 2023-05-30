#!/usr/bin/env bash

# Nettoyage de l'écran
clear

# Lecture du fichier .env
if [ -f .env ]; then
  set -a
  . .env
  set +a

  # Echo with figlet if exists
  if type "figlet" > /dev/null; then
    figlet $MAIN_CONTAINER_NAME
  else
    echo "Docker $MAIN_CONTAINER_NAME"
  fi

  echo "------------------------------"
  echo "Pour quitter: Ctrl + C"
  echo "------------------------------"
  echo ""
fi

# Ouverture du log du container donné en paramètre, ou le principal défini dans le fichier .env
if [ -z "$1" ]
  then
    echo "Ouverture du log du container $MAIN_CONTAINER_NAME"
    echo "------------------------------"
    echo "------------------------------"
    docker logs --follow $MAIN_CONTAINER_NAME
else
    echo "Ouverture du log du container $@"
    echo "------------------------------"
    echo "------------------------------"
    docker logs --follow $@
fi