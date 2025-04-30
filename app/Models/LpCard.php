<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LpCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'section_id',
        'title',
        'content',
        'image_path',
        'order',
    ];

    /**
     * Get the section that owns the card.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(LpSection::class, 'section_id');
    }
}
