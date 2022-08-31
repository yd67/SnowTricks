<?php 

namespace App\Services ;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UserFileUpload
{
    public function __construct($userUploadDestination,SluggerInterface $slugger)
    {
        $this->destination = $userUploadDestination ;
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
}