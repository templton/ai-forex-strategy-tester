<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'description',
        'parameters',
        'version',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'parameters' => 'array',
            'version' => 'integer',
        ];
    }
}
