#!/bin/bash

git pull

# Copy the system assets to the public dir
find system/assets -regex ".*\.\(css\|js\|png\|jpg\)$" \
    -type f | xargs -l ./publish_file.sh

# Copy the system images to the public dir
find system/images -regex ".*\.\(png\|jpg\)$" \
    -type f | xargs -l ./publish_file.sh

# Copy the plugins assets to the public dir
find user/plugins -regex ".*\.\(css\|js\|png\|jpg\|ttf\|woff[2]?$\)" \
    -type f | xargs -l ./publish_file.sh

# Copy the user images to the public dir
find user/pages/images -regex ".*\.\(png\|jpg\)$" \
    -type f | xargs -l ./publish_file.sh
