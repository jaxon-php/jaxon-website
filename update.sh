#!/bin/bash

git pull

# Copy the system assets to the public dir
find system/assets \( -name "*css" -or -name "*js" -or -name "*png" -or -name "*jpg" \) \
    -and -type f | xargs -l ./publish_file.sh

# Copy the system images to the public dir
find system/images \( -name "*png" -or -name "*jpg" \) \
    -and -type f | xargs -l ./publish_file.sh

# Copy the plugins assets to the public dir
find user/plugins \( -name "*css" -or -name "*js" -or -name "*png" -or -name "*jpg" \) \
    -and -type f | xargs -l ./publish_file.sh

# Copy the user images to the public dir
find user/pages/images \( -name "*png" -or -name "*jpg" \) \
    -and -type f | xargs -l ./publish_file.sh
