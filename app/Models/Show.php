<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Show extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['title', 'description', 'airing_time', 'category_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_show');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('show_cover')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumbnail')->format('webp')->nonQueued();
            });
    }
}
