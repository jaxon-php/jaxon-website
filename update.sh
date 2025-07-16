#!/bin/bash

git pull

# Copy the statis assets
cp -R assets/* public/assets/ > /dev/null 2>&1 || true

# Create a link for the images dir
[ -d public/images ] || (cd public && ln -s ../images images)
