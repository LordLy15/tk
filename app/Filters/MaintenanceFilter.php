<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $maintenanceFile = WRITEPATH . 'maintenance.json';
        if (file_exists($maintenanceFile)) {
            $maintenanceData = json_decode(file_get_contents($maintenanceFile), true);
            if ((bool) ($maintenanceData['active'] ?? false)) {
                // Allow logged-in Administrator (Developer) to browse normally
                if (session()->get('isLoggedIn') && strtolower((string) session()->get('role')) === 'administrator') {
                    return null;
                }
                
                return redirect()->to(base_url('maintenance'));
            }
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
