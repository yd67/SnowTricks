<?php 

namespace App\Services ;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadFile
{
    public function __construct( SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file,$dirDestinantion)
    {
        $originalFilename = $file->getClientOriginalName() ;
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
      
        try {
            $file->move($dirDestinantion, $fileName);
        } catch (FileException $e) {
         
        }
        return $fileName ;
    }
}