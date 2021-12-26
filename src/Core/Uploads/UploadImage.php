<?php

namespace App\Core\Uploads;

use Config\UploadsConfig;
use App\Core\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Uploads\UploadsException\UploadsException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImage
{
    private Request $request;

    private Session $session;

    private $files;

    private string $filename;

    public function __construct(Request $request, Session $session)
    {
        $this->session = $session;
        $this->request = $request;
        $this->files = $request->files;
    }

    public function isValid(string $key, bool $nullable = false)
    {

        if (!array_key_exists($key, $this->files->all())) {
            throw new UploadsException("The key = $key, does not exist", 500);
        }

        if (false === $nullable) {
            if (empty($this->files->get($key))) {
                $this->session->set($key, "Vous n'avez pas inséré de pièce jointe");
                return false;
            }
        } else {
            if (empty($this->files->get($key))) {
                return null;
            }
        }

        /** @var UploadedFile $image */
        $file = $this->files->get($key);

        $extension = $file->getClientOriginalExtension();

        if (!in_array($extension, $this->getAllowedUpload())) {
            $this->session->set($key, "L'extension du fichier n'est pas bonne");
            return false;
        }


        if ($file->getError() !== 0) {
            $this->session->set($key, "Une erreur est survenu lors de l'upload");
            return false;
        }

        if ($file->getSize() > $this->getMaxSizeUpload() && $file->getSize() < $this->getMinSizeUpload()) {
            $this->session->set($key, "Le fichier est trop volumineux ou trop petit");
            return false;
        }

        return $this;
    }

    public function uploadFile(string $key, string $name = null)
    {
        $file = $this->files->get($key);

        if (null === $name) {
            $this->setFilename(uniqid().".".$file->getClientOriginalExtension());
        } else {
            $this->setFilename($name.".".$file->getClientOriginalExtension());
        }

        $file->move($this->getPathDestination(), $this->getFilename());
    }

    private function getPathDestination(): string
    {
        return UploadsConfig::IMAGE_PATH;
    }

    private function getAllowedUpload(): array
    {
        return UploadsConfig::IMAGE_ALLOWED;
    }

    private function getMaxSizeUpload(): int
    {
        return UploadsConfig::MAX_SIZE_IMAGE;
    }

    private function getMinSizeUpload(): int
    {
        return UploadsConfig::MIN_SIZE_IMAGE;
    }

    private function setFilename(string $name)
    {
        $this->filename = $name;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}

