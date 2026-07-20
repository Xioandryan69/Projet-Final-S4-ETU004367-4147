<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeNumeroModel extends Model
{
    protected $table = 'PrefixeNumero';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['prefixe', 'typeOperateur_id', 'dateCreation'];
    protected $validationRules = [
        'prefixe' => 'required|max_length[20]|is_unique[PrefixeNumero.prefixe,id,{id}]',
        'typeOperateur_id' => 'required|integer',
    ];
    protected $validationMessages = [
        'prefixe' => ['required' => 'Le préfixe est obligatoire.', 'is_unique' => 'Ce préfixe existe déjà.'],
        'typeOperateur_id' => ['required' => 'Le type d’opérateur est obligatoire.', 'integer' => 'Le type d’opérateur est invalide.'],
    ];

    public function withTypeOperateur(): self
    {
        return $this->select('PrefixeNumero.*, TypeOperateur.libelle AS typeOperateur')
            ->join('TypeOperateur', 'TypeOperateur.id = PrefixeNumero.typeOperateur_id', 'left');
    }

    public function allWithTypeOperateur(): array
    {
        return $this->withTypeOperateur()->orderBy('PrefixeNumero.id', 'DESC')->findAll();
    }
}
