<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commission';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['pourcentage'];
    protected $validationRules = [
        'pourcentage' => 'required|decimal|greater_than_equal_to[0]',
    ];
    protected $validationMessages = [
        'pourcentage' => [
            'required' => 'Le pourcentage est obligatoire.',
            'decimal' => 'Le pourcentage doit être un nombre valide.',
            'greater_than_equal_to' => 'Le pourcentage ne peut pas être négatif.',
        ],
    ];
}
