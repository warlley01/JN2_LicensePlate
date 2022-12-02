#!/bin/bash

DIRECTORY=${PWD}
echo $DIRECTORY

counter=0;

echo "Updatings modules";
# shellcheck disable=SC2045
for vendor in $(ls "$DIRECTORY/app/code"); do
    for f in $(ls "$DIRECTORY/app/code/$vendor/"); do
        echo "$counter - $f";
        if [ -d "$DIRECTORY/app/code/$vendor/$f/.git" ]; then
            cd "$DIRECTORY/app/code/$vendor/$f";
            git pull
        fi
        counter=$((counter+1));
    done
done

# shellcheck disable=SC2045
echo "Updating Themes";
for area in $(ls "$DIRECTORY/app/design"); do
    for vendor in $(ls "$DIRECTORY/app/design/$area/"); do
      for f in $(ls "$DIRECTORY/app/design/$area/$vendor/"); do
          echo "$counter - $f";
          if [ -d "$DIRECTORY/app/design/$area/$vendor/$f/.git" ]; then
              cd "$DIRECTORY/app/design/$area/$vendor/$f";
              git pull
          fi
          counter=$((counter+1));
      done
    done
done

cd $DIRECTORY
