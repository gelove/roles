<?php

namespace GE\Roles\Models;

use GE\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;
use GE\Roles\Traits\RoleHasRelations;
use GE\Roles\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements RoleHasRelationsContract
{
    use Slugable, RoleHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'level'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }
}
