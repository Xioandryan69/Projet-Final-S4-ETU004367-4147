<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeTransactionModel extends Model
{
    protected $table = 'TypeTransaction';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['libelle'];
    protected $validationRules = ['libelle' => 'required|max_length[100]|is_unique[TypeTransaction.libelle,id,{id}]'];
    protected $validationMessages = [
        'libelle' => ['required' => 'Le libellé est obligatoire.', 'is_unique' => 'Ce type de transaction existe déjà.'],
    ];

    public function allOrdered(): array
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}
