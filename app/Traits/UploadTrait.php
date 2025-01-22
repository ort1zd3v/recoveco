<?php
    namespace App\Traits;

    use Illuminate\Http\Request;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Storage;
    
    trait UploadTrait
    {
        public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
        {
            $name = !is_null($filename) ? $filename : str_random(25);
    
            $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
            
            return $file;
        }

        public function uploadJson($data, $filePath, $disk = 'public')
        {
            $file = Storage::disk($disk)->put("$filePath.json", json_encode($data, JSON_PRETTY_PRINT));

            return $file;
        }

        /**
         * Sube la imagen del request y devuelve el path donde se guardó
         * la imagen.
         *
         * @param      Request | $request        | Request con la imagen.
         * @param      string  | $fieldName      | Nombre del campo del request  
         *                     |                 | que tiene la imagen.
         * @param      string  | $folderName     | Ubicación donde guardar la img.
         * @param      string  | $oldPicturePath | Anterior ubicación de la imagen.
         *
         * @return     string 
         */
        public function uploadUserPicture(Request $request, $fieldName, $folderName, $oldPicturePath = null)
        {
            // Toma el archivo.
            $image = $request->file($fieldName);
            // Si indica la ruta anterior de la imagen.
            if(isset($oldPicturePath))
            {
                // Borra la imagen anterior.
                File::delete($oldPicturePath);
            }
            // Forma el nombre del archivo.
            $name = 'user'.'_'.time();
            
            // Genera la ruta donde se guardará
            $filePath = $folderName . $name. '.' . $image->getClientOriginalExtension();
            // Sube la imagen.
            $this->uploadOne($image, $folderName, 'public', $name);

            return $filePath;
        }

		public function uploadFile($file, $path = null, $name = null, $disk = 'public')
		{
			$name = (!is_null($name) ? $name : Str::random(25).'.'.$file->getClientOriginalExtension());
			$result = $file->store($path, $disk);
			return $result;
		}
 
    }
?>