#!/bin/bash

OUTPUT_FILE="source.txt"

# Réinitialiser le fichier
> "$OUTPUT_FILE"

echo "==================================================" >> "$OUTPUT_FILE"
echo "EXPORT COMPLET DU PROJET CODEIGNITER 4" >> "$OUTPUT_FILE"
echo "Date : $(date)" >> "$OUTPUT_FILE"
echo "Répertoire : $(pwd)" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "" >> "$OUTPUT_FILE"

# Exclure les dossiers inutiles
find . \
    \( -path "./vendor" -o \
       -path "./system" -o \
       -path "./writable" -o \
       -path "./.git" -o \
       -path "./tests" \) -prune \
    -o \
    \( -name "*.php" -o \
       -name "*.js" -o \
       -name "*.css" -o \
       -name "*.html" -o \
       -name "*.sql" -o \
       -name "*.json" -o \
       -name "*.xml" -o \
       -name "*.txt" -o \
       -name "*.md" -o \
       -name "*.env" -o \
       -name "*.sh" \) \
    -type f | sort | while read file
do
    echo "" >> "$OUTPUT_FILE"
    echo "==================================================" >> "$OUTPUT_FILE"
    echo "FICHIER : $file" >> "$OUTPUT_FILE"
    echo "==================================================" >> "$OUTPUT_FILE"
    cat "$file" >> "$OUTPUT_FILE"
    echo "" >> "$OUTPUT_FILE"
done

echo "Export terminé dans $OUTPUT_FILE"