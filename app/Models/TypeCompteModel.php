<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCompteModel extends Model
{
    protected $table = 'TypeCompte';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['libelle'];
    protected $validationRules = ['libelle' => 'required|max_length[100]|is_unique[TypeCompte.libelle,id,{id}]'];
    protected $validationMessages = [
        'libelle' => ['required' => 'Le libellé est obligatoire.', 'is_unique' => 'Ce type de compte existe déjà.'],
    ];
}
