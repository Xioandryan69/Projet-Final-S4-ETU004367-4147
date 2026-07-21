#!/bin/bash

OUTPUT_FILE="source.txt"

# Réinitialiser le fichier
> "$OUTPUT_FILE"

echo "==================================================" >> "$OUTPUT_FILE"
echo "EXPORT SELECTIF DU PROJET CODEIGNITER 4" >> "$OUTPUT_FILE"
echo "Date : $(date)" >> "$OUTPUT_FILE"
echo "Répertoire : $(pwd)" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "" >> "$OUTPUT_FILE"
echo "Fichiers inclus :" >> "$OUTPUT_FILE"
echo "  - app/Config/Database.php" >> "$OUTPUT_FILE"
echo "  - app/Config/App.php" >> "$OUTPUT_FILE"
echo "  - app/Controllers/**/*.php" >> "$OUTPUT_FILE"
echo "  - app/Filters/**/*.php" >> "$OUTPUT_FILE"
echo "  - app/Models/**/*.php" >> "$OUTPUT_FILE"
echo "  - app/Views/**/*.php, *.js, *.css" >> "$OUTPUT_FILE"
echo "  - public/assets/**/*.js, *.css" >> "$OUTPUT_FILE"
echo "  - database.sql" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "" >> "$OUTPUT_FILE"

# Fonction pour ajouter un fichier
add_file() {
    local file="$1"
    if [ -f "$file" ]; then
        echo "" >> "$OUTPUT_FILE"
        echo "==================================================" >> "$OUTPUT_FILE"
        echo "FICHIER : $file" >> "$OUTPUT_FILE"
        echo "==================================================" >> "$OUTPUT_FILE"
        cat "$file" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        echo "--------------------------------------------------" >> "$OUTPUT_FILE"
        echo "FIN DU FICHIER : $file" >> "$OUTPUT_FILE"
        echo "==================================================" >> "$OUTPUT_FILE"
        return 0
    else
        echo "Fichier non trouvé : $file" >> "$OUTPUT_FILE"
        return 1
    fi
}

# Compter les fichiers ajoutés
count=0

echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "1. FICHIERS DE CONFIGURATION" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

# Ajouter app/Config/Database.php
if add_file "app/Config/Database.php"; then
    count=$((count + 1))
fi

# Ajouter app/Config/App.php
if add_file "app/Config/App.php"; then
    count=$((count + 1))
fi

echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "2. FICHIERS CONTROLLERS" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

# Ajouter tous les fichiers PHP dans app/Controllers/ et ses sous-dossiers
find app/Controllers -name "*.php" -type f | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "3. FICHIERS FILTERS" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

# Ajouter tous les fichiers PHP dans app/Filters/ et ses sous-dossiers
find app/Filters -name "*.php" -type f | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "4. FICHIERS MODELS" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

# Ajouter tous les fichiers PHP dans app/Models/ et ses sous-dossiers
find app/Models -name "*.php" -type f | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "5. FICHIERS VIEWS (PHP, JS, CSS)" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

# Ajouter tous les fichiers PHP dans app/Views/ et ses sous-dossiers
find app/Views -name "*.php" -type f | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

# Ajouter tous les fichiers JS dans app/Views/ et ses sous-dossiers
find app/Views -name "*.js" -type f | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

# Ajouter tous les fichiers CSS dans app/Views/ et ses sous-dossiers
find app/Views -name "*.css" -type f | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "6. FICHIERS PUBLIC ASSETS (JS, CSS)" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

# Ajouter tous les fichiers JS dans public/assets/ et ses sous-dossiers
find public/assets -name "*.js" -type f 2>/dev/null | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

# Ajouter tous les fichiers CSS dans public/assets/ et ses sous-dossiers
find public/assets -name "*.css" -type f 2>/dev/null | sort | while read file; do
    if add_file "$file"; then
        count=$((count + 1))
    fi
done

echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "7. FICHIER DATABASE.SQL" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

# Ajouter database.sql
if add_file "database.sql"; then
    count=$((count + 1))
fi

# Ajouter les statistiques
echo "" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "STATISTIQUES DE L'EXPORT" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"
echo "Nombre total de fichiers exportés : $count" >> "$OUTPUT_FILE"
echo "Taille du fichier source.txt : $(du -h "$OUTPUT_FILE" | cut -f1)" >> "$OUTPUT_FILE"
echo "==================================================" >> "$OUTPUT_FILE"

echo ""
echo "=================================================="
echo "EXPORT TERMINÉ AVEC SUCCÈS !"
echo "=================================================="
echo "Fichier généré : $OUTPUT_FILE"
echo "Nombre de fichiers inclus : $count"
echo "Taille : $(du -h "$OUTPUT_FILE" | cut -f1)"
echo "=================================================="