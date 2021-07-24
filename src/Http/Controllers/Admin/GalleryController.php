<?php

namespace bachphuc\LaravelGalleryImage\Http\Controllers\Admin;

use Illuminate\Http\Request;

use bachphuc\LaravelGalleryImage\Models\GalleryImage;

class GalleryController extends Controller
{
    public function uploadItemImage(Request $request){
        $this->validate($request, [
            'item_type',
            'item_id',
            'image'
        ]);


        $item = model_item($request->input('item_type'), $request->input('item_id'));
        if(!$item){
            return [
                'status' => false,
                'message' => 'Item is not found'
            ];
        }

        $image = GalleryImage::addTo($item);
        if(!$image){
            return [
                'status' => false,
                'message' => 'Item is not found'
            ];
        }

        $image->uploadPhoto();

        return [
            'status' => true,
            'image' => $image
        ];
    }

    public function deleteItemImage(Request $request){
        $this->validate($request, [
            'item_type',
            'item_id',
            'image_id'
        ]);


        $item = model_item($request->input('item_type'), $request->input('item_id'));
        if(!$item){
            abort(404);
        }

        $image = GalleryImage::find($request->input('image_id'));
        if(!$image){
            abort(404);
        }

        $image->remove();

        return [
            'status' => true,
        ];
    }    
}