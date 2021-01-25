<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use HasStatuses;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'slug', 'author_id',
    ];

    /**
     * Get the route key for the model.
     * TODO: Put this code in a trait (SlugUrl)?
     */
    public function getRouteKeyName(): string
    {
        if (request()->is('admin/*')) {
            return 'id';
        }

        return 'slug';
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    /**
     * Get the user that create the post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function getThumbnailAttribute(): ?Media
    {
        return $this->getFirstMedia('thumbnail');
    }

    /**
     * @param string|\Symfony\Component\HttpFoundation\File\UploadedFile $thumbnail
     * @return void
     */
    public function setThumbnail($thumbnail): void
    {
        $this
            ->addMedia($thumbnail)
            ->toMediaCollection('thumbnail');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('thumbnail')
            ->withResponsiveImages()
            ->singleFile();
    }
}
