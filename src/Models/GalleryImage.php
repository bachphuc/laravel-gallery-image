<?php

namespace bachphuc\LaravelGalleryImage\Models;

class GalleryImage extends GalleryBase
{
    protected $table = 'gallery_images';
    protected $itemType = 'gallery_image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'item_type',
        'item_id',
        'title',
        'description',
        'image',
        'thumbnail_120',
        'thumbnail_300',
        'thumbnail_500',
        'thumbnail_720',
        'image_width',
        'image_height',
        'image_ratio',
    ];

    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }

    public static function getImagesOf($item = null){
        if(!$item) return [];
        $images = GalleryImage::where('item_type', $item->getType())
        ->where('item_id', $item->getId())
        ->get();

        return $images;
    }

    public static function addTo($item = null, $params = []){
        if(!$item) return null;
        
        $insert = [
            'user_id' => auth()->check() ? auth()->user()->id : 0,
            'item_type' => $item->getType(),
            'item_id' => $item->getId()
        ];

        if(isset($params['title'])){
            $insert['title'] = $params['title'];
        }

        if(isset($params['description'])){
            $insert['description'] = $params['description'];
        }

        $image = GalleryImage::create($insert);

        return $image;
    }
}