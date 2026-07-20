<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeOperateurModel extends Model
{
    protected $table = 'TypeOperateur';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['libelle'];
    protected $validationRules = ['libelle' => 'required|max_length[100]|is_unique[TypeOperateur.libelle,id,{id}]'];
    protected $validationMessages = [
        'libelle' => ['required' => 'Le libellé est obligatoire.', 'is_unique' => 'Ce type d’opérateur existe déjà.'],
    ];

    public function allOrdered(): array
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}
