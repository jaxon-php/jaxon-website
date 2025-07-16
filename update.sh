#!/bin/bash

git pull

# Copy the statis assets
cp -R assets/* public/assets/ > /dev/null 2>&1 || true

# Create a link for the images dir
[ -d public/images ] || (cd public && ln -s ../images images)

# Copy the plugins assets to the public dir
find user/plugins \( -name "*css" -or -name "*js" -or -name "*png" -or -name "*jpg" \) \
    -and -type f | xargs -l ./publish_file.sh
