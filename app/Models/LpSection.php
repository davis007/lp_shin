<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LpSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'landing_page_id',
        'title',
        'type',
        'image_path',
        'order',
    ];

    /**
     * Get the landing page that owns the section.
     */
    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class, 'landing_page_id');
    }

    /**
     * Get the cards for the section.
     */
    public function cards(): HasMany
    {
        return $this->hasMany(LpCard::class, 'section_id');
    }
}
