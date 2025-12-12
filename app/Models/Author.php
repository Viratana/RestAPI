<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Author extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'author_name',
        'author_contact_no',
        'author_country',
        'created_at',
        'updated_at',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
