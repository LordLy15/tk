<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GuestFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            return null;
        }

        return redirect()->to($this->url($this->defaultPathForRole((string) session()->get('role'))));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    private function defaultPathForRole(string $role): string
    {
        return strtolower($role) === 'staff' ? 'kehadiran' : 'admin';
    }

    private function url(string $path): string
    {
        return rtrim(config('App')->baseURL, '/') . '/' . ltrim($path, '/');
    }
}
