@if(isset($item))
<div class="row">
    <div class="col-md-12">
        <div class="form-group gallery-panel">
            <label class="control-label">{{isset($title) ? $title : ''}}</label>

            <div id="gallary-images-panel" class="gallary-images-panel">
                @foreach(\bachphuc\LaravelGalleryImage\Models\GalleryImage::getImagesOf($item) as $image)
                <div id="gallery-item-{{$image->id}}" class="gallery-item" style="background-image:url({{$image->getThumbnailImage(120)}});">
                    <span data-id="{{$image->id}}" onclick="removeImage(this)"><i class="material-icons">close</i></span>
                </div>
                @endforeach
    
                <div class="bnt-select-file" id="bnt-select-file">
                    <input type="file" id="gallary-input" name="tmp_image" onchange="onImageChange(this)" />
                    <i class="material-icons">add</i>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var btnSelectFile = document.getElementById('bnt-select-file');

    function onImageChange(input) {
		if (input.files && input.files[0]) {
			let reader = new FileReader();

			reader.onload = function (e) {
                btnSelectFile.style.backgroundImage = "url(" + e.target.result + ")";
                let fd = new FormData();
                fd.append('image', input.files[0]);
                fd.append('item_type', '{{$item->getType()}}');
                fd.append('item_id', {{$item->getId()}});
                fd.append('_token', document.querySelector(`meta[name="csrf-token"]`).content);
                post('{{route('admin.gallery.upload-item-image')}}', fd, (percent) => console.log(percent), (err, res) => {
                    if(res.status){
                        let newItem = document.createElement('div');
                        newItem.id = `gallery-item-${res.image.id}`;
                        newItem.className = "gallery-item";
                        newItem.style.backgroundImage = `url(${window.location.origin
 + '/' + res.image.thumbnail_120})`;
                        newItem.innerHTML = `<span data-id="${res.image.id}" onclick="removeImage(this)"><i class="material-icons">close</i></span>`;
                        btnSelectFile.style.backgroundImage = '';
                        btnSelectFile.parentNode.insertBefore(newItem, btnSelectFile);
                    }
                    else{
                        if(res.message) alert(res.message)
                    }
                }, (err) => console.log(err));
			}

			reader.readAsDataURL(input.files[0]);
		}
    }
    
    function removeImage(ele){
        let photoId = ele.dataset['id'];
        let fd = new FormData();
        fd.append('image_id', photoId);
        fd.append('item_type', '{{$item->getType()}}');
        fd.append('item_id', {{$item->getId()}});
        fd.append('_token', document.querySelector(`meta[name="csrf-token"]`).content);
        post('{{route('admin.gallery.delete-item-image')}}', fd, (percent) => console.log(percent), (err, res) => {
            if(res.status){
                let img = document.getElementById('gallery-item-' + photoId);
                if(img){
                    img.parentNode.removeChild(img);
                }
            }
        }, (err) => console.log(err));
    }

    function post(u, fd, p, c, ec){
        
        var r = new XMLHttpRequest();r.upload.onprogress=(e)=>{
            let percen=e.lengthComputable?(Math.floor(e.loaded*100/e.total)):0;p && p(percen);
        };
        r.onload=(e)=>{
            if(r.readyState == 4){
                if(r.status==200){
                    var d = JSON.parse(r.responseText);
                    if(c) c(false, d);
                }
                else ec && ec(r.statusText);
            }
        };
        r.onerror = (e) => ec && ec(e);
        r.open('POST',u);
        
        r.send(fd);
    }
</script>
@endif
