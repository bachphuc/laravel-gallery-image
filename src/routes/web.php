<?php

Route::post('gallery/upload-item-image', 'GalleryController@uploadItemImage')->name('gallery.upload-item-image');
Route::post('gallery/delete-item-image', 'GalleryController@deleteItemImage')->name('gallery.delete-item-image');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function(){
    Route::post('gallery/upload-item-image', 'GalleryController@uploadItemImage')->name('gallery.upload-item-image');
    Route::post('gallery/delete-item-image', 'GalleryController@deleteItemImage')->name('gallery.delete-item-image');
});