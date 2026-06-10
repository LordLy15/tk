<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Check Maintenance Mode
        $maintenanceFile = WRITEPATH . 'maintenance.json';
        if (file_exists($maintenanceFile)) {
            $maintenanceData = json_decode(file_get_contents($maintenanceFile), true);
            if ((bool) ($maintenanceData['active'] ?? false)) {
                if (strtolower((string) session()->get('role')) !== 'administrator') {
                    return redirect()->to($this->url('maintenance'));
                }
            }
        }

        if (! session()->get('isLoggedIn')) {
            session()->set('redirect_url', (string) $request->getUri());

            return redirect()->to($this->url('login'))
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $allowedRoles = $this->normalizeRoles($arguments ?? []);

        if ($allowedRoles === []) {
            return null;
        }

        $currentRole = strtolower((string) session()->get('role'));

        if (in_array($currentRole, $allowedRoles, true)) {
            return null;
        }

        return redirect()->to($this->url($this->defaultPathForRole((string) session()->get('role'))))
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    private function normalizeRoles(array $arguments): array
    {
        $roles = [];

        foreach ($arguments as $argument) {
            foreach (explode(',', (string) $argument) as $role) {
                $role = strtolower(trim($role));

                if ($role !== '') {
                    $roles[] = $role;
                }
            }
        }

        return array_values(array_unique($roles));
    }

    private function defaultPathForRole(string $role): string
    {
        return 'admin';
    }

    private function url(string $path): string
    {
        return rtrim(config('App')->baseURL, '/') . '/' . ltrim($path, '/');
    }
}
