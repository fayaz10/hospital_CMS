<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
  use SoftDeletes;

  protected $table = 'attachments';

  protected $fillable = [
    'label', 'path', 'mime_type', 'attachable_id', 'attachable_type',
  ];

  public function attachable()
  {
      return $this->morphTo();
  }
}
