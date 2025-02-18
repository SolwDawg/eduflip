<?php
namespace App\Traits;

use Bvtterfly\LaravelHashids\HasHashId;
use Bvtterfly\LaravelHashids\HashIdOptions;
use Illuminate\Contracts\Database\Eloquent\Builder;

trait WithHashId
{
    use HasHashId;

    public function getHashIdOptions(): HashIdOptions
    {
        return HashIdOptions::create()
            ->saveHashIdTo('hashid')
            ->setMinimumHashLength(10)
            ->setAlphabet('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    }

    public function scopeHashid(Builder $builder, string $hashid): Builder
    {
        return $builder->where('hashid', $hashid);
    }

    public static function getId(string $hashid)
    {
        return static::hashid($hashid)->firstOrFail()?->id;
    }

    public function getRouteKeyName()
    {
        return 'hashid';
    }
}
