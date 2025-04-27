<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class AssignUser extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles';

    public $timestamps = false;

    protected $fillable = ['role_id', 'model_type', 'model_id'];

    public $incrementing = false; // Karena tidak ada kolom id

    protected function setKeysForSaveQuery($query)
    {
        return $query
            ->where('role_id', $this->getAttribute('role_id'))
            ->where('model_type', $this->getAttribute('model_type'))
            ->where('model_id', $this->getAttribute('model_id'));
    }
    public static function booted()
    {
        static::creating(function ($assignUser) {
            $assignUser->model_type = \App\Models\User::class; // Atur model_type otomatis
        });
    }

    public function getKeyName()
    {
        return 'model_id'; // Kita paksa pakai 1 field aja
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'model_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
