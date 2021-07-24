<?php

namespace bachphuc\LaravelGalleryImage\Models;

use Illuminate\Database\Eloquent\Model;

use bachphuc\PhpLaravelHelpers\WithModelBase;
use bachphuc\PhpLaravelHelpers\WithImage;

class GalleryBase extends Model
{
    use WithModelBase, WithImage;
}