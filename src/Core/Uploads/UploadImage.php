<?php

namespace App\Core\Uploads;

use App\Core\Session\Session;
use App\Core\Uploads\UploadsException\UploadsException;
use Config\UploadsConfig;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * isValid
     *
     * @param  string $key
     * @param  bool $nullable
     * @return mixed
     */
    public function isValid(string $key, bool $nullable = false): mixed
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

        if (!in_array($extension, $this->getAllowedUpload()) || !in_array(mime_content_type($file->getRealPath()), $this->getMimetypeAllowed())) {
            $this->session->set($key, "L'extension du fichier n'est pas bonne");

            return false;
        }

        if (0 !== $file->getError()) {
            $this->session->set($key, "Une erreur est survenu lors de l'upload");

            return false;
        }

        if ($file->getSize() > $this->getMaxSizeUpload() && $file->getSize() < $this->getMinSizeUpload()) {
            $this->session->set($key, 'Le fichier est trop volumineux ou trop petit');

            return false;
        }

        return $this;
    }

    /**
     * uploadFile
     * Upload file on server
     * @param  string $key
     * @param  string $name
     * @return void
     */
    public function uploadFile(string $key, string $name = null): void
    {
        $file = $this->files->get($key);

        if (null === $name) {
            $this->setFilename(uniqid().'.'.$file->getClientOriginalExtension());
        } else {
            $this->setFilename($name.'.'.$file->getClientOriginalExtension());
        }

        $file->move($this->getPathDestination(), $this->getFilename());
    }

    /**
     * getPathDestination
     *
     * @return string
     */
    private function getPathDestination(): string
    {
        return UploadsConfig::IMAGE_PATH;
    }

    /**
     * getMimetypeAllowed
     *
     * @return array
     */
    private function getMimetypeAllowed(): array
    {
        return UploadsConfig::MIMETYPE_ALLOWED;
    }

    /**
     * getAllowedUpload
     *
     * @return array
     */
    private function getAllowedUpload(): array
    {
        return UploadsConfig::EXTENSION_ALLOWED;
    }

    /**
     * getMaxSizeUpload
     *
     * @return int
     */
    private function getMaxSizeUpload(): int
    {
        return UploadsConfig::MAX_SIZE_IMAGE;
    }

    /**
     * getMinSizeUpload
     *
     * @return int
     */
    private function getMinSizeUpload(): int
    {
        return UploadsConfig::MIN_SIZE_IMAGE;
    }

    /**
     * setFilename
     *
     * @param  mixed $name
     * @return void
     */
    private function setFilename(string $name): void
    {
        $this->filename = $name;
    }

    /**
     * getFilename
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}
