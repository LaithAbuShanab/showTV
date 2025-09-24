<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Episode extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'season_id',
        'episode_number',
        'title',
        'description',
        'duration',
        'airing_time',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('episode_cover')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumbnail')->format('webp')->nonQueued();
            });

        $this->addMediaCollection('episode_video')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('video')->format('webp')->nonQueued();
            });
    }
}
