#!/bin/bash

dest_file_dir=$(dirname $1)
# dest_file_name=$(basename $1)

mkdir -p public/$dest_file_dir/
cp $1 public/$1
