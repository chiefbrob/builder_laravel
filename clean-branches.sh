#!/bin/bash

# Get the list of all local branches except master and store them in an array
branches=( $(git branch | grep -v "master" | awk '{print $1}') )

# Loop through the array and delete each local branch
for branch in "${branches[@]}"
do
    git branch -D "$branch"
done

echo "All local branches except master have been deleted."
