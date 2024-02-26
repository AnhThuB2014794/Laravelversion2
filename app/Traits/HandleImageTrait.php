<?php 

namespace App\Traits;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait HandleImageTrait 
{
    protected $path = 'upload/';

    public function veryfy ($request)
    {
        return $request->has('image');
    }

    public function saveImage($request)
    {
        if($this->veryfy($request))
        {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            
            $name = time() . '.' . $image->getClientOriginalExtension();
            $img =  $manager->read($image);
            $img_s = $img->resize(300,300)->save($this->path . $name);
            return $name;
        }
    }

    public function updateImage($request, $currentImage)
    {
        if($this->veryfy($request))
        {
            $this->deleteImage($currentImage);

            return $this->saveImage($request);
        }

        return $currentImage;
    }

    public function deleteImage($imageName)
    {
        if($imageName && file_exists($this->path .$imageName))
        {
            unlink($this->path . $imageName);
        }
    }
}