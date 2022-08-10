<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Phone;
use App\Models\Social;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function socials(): BelongsToMany
    {
        return $this->belongsToMany(Social::class)->withPivot('link');
    }


}
