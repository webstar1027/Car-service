<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $table = 'files';
    protected $fillable = [
      'user_id', 'file_type', 'file_name'
    ];

    public static function insert($data) {
    	$file = new File;
    	$file->user_id = $data['user_id'];
    	$file->file_type = $data['file_type'];
    	$file->file_name = $data['filename'];
        $file->document_id = $data['document_id'];
    	$file->save();
    }
}
