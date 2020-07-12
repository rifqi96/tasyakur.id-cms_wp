#!/bin/bash

bold=$(tput bold)
normal=$(tput sgr0)

# Declare args array
dockerUpCmd="docker-compose"
dockerArgs=()
dockerServices=()
isSudo=false

echo "${bold}Running${normal}"
dockerServices=(nginx redis beanstalkd mysql phpmyadmin php)
# Copy the env file if doesn't exist
cp -n example.env .env

# FORCE_COMPOSER_INSTALL setter fallback
grep -qF 'FORCE_COMPOSER_INSTALL' .env || echo 'FORCE_COMPOSER_INSTALL=false' >> .env

# re-build everything if changes detected
if [[ $1 = "build" ]]; then
  dockerArgs+=('--build')
fi

# Check for additional parameters
for arg in "$@"
do
  # Force set FORCE_COMPOSER_INSTALL to true
  if [[ "$arg" = "--force-i" ]]; then
    grep -qF 'FORCE_COMPOSER_INSTALL' .env || echo 'FORCE_COMPOSER_INSTALL=true' >> .env
  elif [[ "$arg" = "--sudo" ]]; then
    isSudo=true
  fi
done

# docker-compose detach: run containers in background
dockerArgs+=('-d')

# add 'up' to docker-compose command
dockerUpCmd+=" up"

# Run the main docker-compose command

command="${dockerUpCmd} ${dockerArgs[@]} ${dockerServices[@]}"
# Apply sudo
if [[ "$isSudo" = true ]]; then
    command="sudo ${command}"
fi
echo "${bold}Command: ${command}${normal}"
eval "$command"