#!/bin/bash

if [ -z "$1" ]
  then
    echo "No scaffold name provided"
    exit 1
fi

controllers=("Create" "Update" "Get" "Delete")
requests=("Create" "Update" "Get" "Delete")
tests=("Create" "Update" "Get" "Delete")
components=("Form" "Create" "Update" "Single" "Delete" "")
router=""

# Create controller files
for controller in "${controllers[@]}"
do
  php artisan make:controller "${1}/${controller}${1}Controller" --invokable
done

for request in "${requests[@]}"
do
  php artisan make:request "${1}/${request}${1}Request"
done

php artisan make:model "${1}" -mf


mkdir -p tests/Feature/"${1}"
for test in "${tests[@]}"
do
  php artisan make:test "${1}/${test}${1}ControllerTest"
done

mkdir -p resources/js/components/"${1}"
for component in "${components[@]}"
do
  touch "resources/js/components/${1}/${component}${1}.vue"
done

mkdir -p resources/js/tests/components/"${1}"
for component in "${components[@]}"
do
  touch "resources/js/tests/components/${1}/${component}${1}.test.js"
done

touch "resources/js/router/${1}.js"
