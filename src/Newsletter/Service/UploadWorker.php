<?php namespace designpond\newsletter\Newsletter\Service;

use designpond\newsletter\Newsletter\Service\UploadInterface;;

class UploadWorker implements UploadInterface {

	/*
	 * upload selected file 
	 * @return array
	*/	
	public function upload( $file , $destination , $type = null){

        $name = $file->getClientOriginalName();
        $ext  = $file->getClientOriginalExtension();

        // Get the name first because after moving, the file doesn't exist anymore
        $new  = $file->move($destination,$name);
        $size = $new->getSize();
        $mime = $new->getMimeType();
        $path = $new->getRealPath();

        $image_name = basename($name,'.'.$ext);

        //resize
        if($type)
        {
            // resize if we have to
            $sizes = config('size.'.$type);
            $this->resize( $path, $image_name, $sizes['width'], $sizes['height']);
        }

        return array('name' => $name ,'ext' => $ext ,'size' => $size ,'mime' => $mime ,'path' => $path  );

	}
	
	/*
	 * rename file 
	 * @return instance
	*/	
	public function rename($file , $name , $path )
    {
		$new = $path.'/'.$name;
		
		return \Image::make( $file )->save($new);
	}
	
	/*
	 * resize file 
	 * @return instance
	*/	
	public function resize( $path, $name , $width = null , $height = null)
    {

        $img = \Image::make($path);

        // prevent possible upsizing
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save($path);
	}
}