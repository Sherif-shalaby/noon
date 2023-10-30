<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WageAttachments extends Model
{
    use HasFactory;
    protected $fillable = ['file_name','wage_id'];
    protected $table = 'wage_attachments';
}
