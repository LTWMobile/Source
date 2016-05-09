<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo
 * @package App\Models
 * @property string src
 * @property int id
 */
class Photo extends Model
{
    protected $table = 'Photo';
    protected $hidden = ['id'];
    public $timestamps = false;

    /**
     * @param string $stream
     * @param string $mime
     * @return Photo|\Exception
     */
    public static function upload($stream, $mime)
    {
        /** @var \App\Models\Photo $photo */
        $photo = new Photo();

        try {
            /** @var \Illuminate\Contracts\Filesystem\Filesystem $s3 */
            $s3 = \Storage::disk('s3');
            $id = Photo::all()->count() + 1;
            $s3->put("$id.$mime", $stream);

            $photo->src = "https://s3-ap-southeast-1.amazonaws.com/takecoffee/$id.$mime";
            $photo->save();
            return $photo;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
