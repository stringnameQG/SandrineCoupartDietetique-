<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;

use Cloudinary\Api\Admin\AdminApi;

$config = Configuration::instance();
$config->cloud->cloudName = 'derejrikc';
$config->cloud->apiKey = '397213699967617';
$config->cloud->apiSecret = 'XUy8QfE6MXiU_BKch0excfomIEQ';
$config->url->secure = true;


class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture)
    {
        // stocker au format mp
        $fichier = md5(uniqid(rand(), true)) . '.webp';

        // On récupère les infos de l'image
        $pitctureInfos = getimagesize($picture);

        if($pitctureInfos === false){
            throw new Exception('Format d\'image incorrect');
        }
            
        // On vérifie le format de l'image
        switch($pitctureInfos['mime']){
            case 'image/png':
                $pictureSource = imagecreatefrompng($picture);
                break;
            case 'image/jpeg':
                $pictureSource = imagecreatefromjpeg($picture);
                break;
            case 'image/webp':
                $pictureSource = imagecreatefromwebp($picture);
                break;
            default:
                throw new Exception('Format d\'image incorrect');
        }      

        $path = $this->params->get('images_directory');

        // On stocke l'image
        imagewebp($pictureSource, $path . $fichier);

        // On crée le chemin de sauvegarde pour cloudinary
        $cloudinaryPath = $path . $fichier;
        
        // On ajoute le nom de dossier de stockage de l'image
        $uploadFolder = 'stephaniecarondietetique';

        // On crée une instance de UploadApi
        $upload = new UploadApi();

        // On effectue la sauvegarde 
        $upload->upload($cloudinaryPath, [
            'public_id' => $fichier,
            'folder' => $uploadFolder
        ]);

        return $fichier;
    }

    public function delete(string $fichier){
        if($fichier !== 'default.webp'){
            $succes = false;
            $path = $this->params->get('images_directory');

            $original = $path . $fichier;

            if(file_exists($original)){
                unlink($original);
                $sucess = true;
            }

            return $succes;
        }
        return false;
    }
}