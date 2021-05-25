<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name','info','created_by'];
    protected $guarded = ['item_id'];
    protected $primaryKey = 'item_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function storage(){
        return $this->belongsTo(Storage::class);
    }
}
