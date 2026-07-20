<?php

namespace App\Models;

use CodeIgniter\Model;

class RelationOperateurModel extends Model
{
    protected $table = 'RelationOperateur';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['libelle'];
    protected $validationRules = ['libelle' => 'required|max_length[100]|is_unique[RelationOperateur.libelle,id,{id}]'];
    protected $validationMessages = [
        'libelle' => ['required' => 'Le libellé est obligatoire.', 'is_unique' => 'Cette relation d’opérateur existe déjà.'],
    ];
}
