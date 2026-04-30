<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActionLog whereUserId($value)
 * @mixin \Eloquent
 */
class ActionLog extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id','post_id','action'];
}
