<?php
namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = "Role";

    protected $primaryKey = 'id';

    protected $allowedFields = ['name'];

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[5]|is_unique[Role.name,id,{id}]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Le champ {field} est obligatoire.',
            'min_length' => 'Le {field} doit contenir au moins {param} caractères.',
            'max_length' => 'Le {field} ne peut pas dépasser {param} caractères.',
            'is_unique' => 'Ce nom de rôle existe déjà.'
        ]
    ];
    protected $skipValidation = false;


}
