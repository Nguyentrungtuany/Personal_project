<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class LinkMovie extends Model
{
    public $timestamps = false;
    use HasFactory;
   protected $table = 'linkmovie';
   protected $fillable = [
       'title',
       'description',
       'status'
   ];
}
