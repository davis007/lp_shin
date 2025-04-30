<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\URL;

class LandingPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_description',
        'is_published',
        'published_at',
        'cta_microcopy',
        'cta_button_text',
        'cta_type',
        'cta_link_url',
        'cta_qr_image',
    ];

    /**
     * 公開URLを取得
     *
     * @return string|null
     */
    public function getPublicUrl()
    {
        if (!$this->slug) {
            return null;
        }

        return URL::route('landing-pages.show', ['slug' => $this->slug]);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the sections for the landing page.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(LpSection::class, 'landing_page_id');
    }
}
