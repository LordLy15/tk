<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('isLoggedIn')) {
            return null;
        }

        session()->set('redirect_url', (string) $request->getUri());

        return redirect()->to($this->url('login'))
            ->with('error', 'Silakan login terlebih dahulu.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    private function url(string $path): string
    {
        return rtrim(config('App')->baseURL, '/') . '/' . ltrim($path, '/');
    }
}
