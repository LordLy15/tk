<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;

    // Mengaktifkan helper URL agar base_url() berfungsi
    protected $helpers = ['url', 'form', 'session'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    protected function hasUploadedFile(string $field): bool
    {
        $file = $this->request->getFile($field);

        return $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
    }

    protected function profilePhotoValidationRule(string $field, string $label = 'Foto profil'): array
    {
        return [
            'rules' => "uploaded[$field]|max_size[$field,2048]|is_image[$field]|mime_in[$field,image/jpg,image/jpeg,image/png,image/webp]",
            'errors' => [
                'uploaded' => $label . ' gagal diunggah.',
                'max_size' => $label . ' maksimal 2 MB.',
                'is_image' => $label . ' harus berupa file gambar.',
                'mime_in' => $label . ' harus berformat JPG, JPEG, PNG, atau WEBP.',
            ],
        ];
    }

    protected function storeUploadedProfilePhoto(string $field, string $directory): ?string
    {
        $file = $this->request->getFile($field);

        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        $targetPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . trim($directory, '/\\');

        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0775, true);
        }

        $fileName = $file->getRandomName();
        $file->move($targetPath, $fileName);

        return $fileName;
    }

    protected function deleteUploadedProfilePhoto(?string $fileName, string $directory): void
    {
        $fileName = basename((string) $fileName);

        if ($fileName === '') {
            return;
        }

        $path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . trim($directory, '/\\') . DIRECTORY_SEPARATOR . $fileName;

        if (is_file($path)) {
            unlink($path);
        }
    }
}
