<?php 

namespace App\Services ;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class TriksFileUpload
{
    public function __construct($triksUploadDestination,SluggerInterface $slugger)
    {
        $this->destination = $triksUploadDestination ;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = $file->getClientOriginalName() ;
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
      
        try {
            $file->move($this->destination, $fileName);
        } catch (FileException $e) {
         
        }
        return $fileName ;
    }

    public function remove($filename)
    {
        $file = $this->destination."/".$filename ;
        if (is_file($file)) {
            unlink($file);
        }
    }
}