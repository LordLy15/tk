<?php

namespace App\Controllers;

use Config\Database;

class Developer extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        
        // System Information
        $dbVersion = $db->getVersion();
        $dbPlatform = $db->getPlatform();
        $phpVersion = PHP_VERSION;
        
        // Writable directories size
        $cacheSize = $this->getDirectorySize(WRITEPATH . 'cache');
        $logsSize = $this->getDirectorySize(WRITEPATH . 'logs');
        $debugSize = $this->getDirectorySize(WRITEPATH . 'debugbar');
        
        // Database tables list and row count
        $tables = [];
        if ($db->connID) {
            $tablesRaw = $db->listTables();
            foreach ($tablesRaw as $table) {
                $count = $db->table($table)->countAllResults();
                $tables[] = [
                    'name' => $table,
                    'rows' => $count
                ];
            }
        }
        
        // Activity logs
        $logs = [];
        if ($db->tableExists('log_aktivitas')) {
            $logs = $db->table('log_aktivitas')
                ->select('log_aktivitas.*, users.username')
                ->join('users', 'users.id_users = log_aktivitas.id_user', 'left')
                ->orderBy('log_aktivitas.created_at', 'DESC')
                ->limit(20)
                ->get()
                ->getResultArray();
        }

        // Maintenance Mode Status
        $maintenanceFile = WRITEPATH . 'maintenance.json';
        $maintenanceActive = false;
        if (file_exists($maintenanceFile)) {
            $maintenanceData = json_decode(file_get_contents($maintenanceFile), true);
            $maintenanceActive = (bool) ($maintenanceData['active'] ?? false);
        }

        // Disk space calculations (safely wrapped)
        $diskFree = 'N/A';
        $diskTotal = 'N/A';
        try {
            $diskFreeVal = @disk_free_space(ROOTPATH);
            $diskTotalVal = @disk_total_space(ROOTPATH);
            if ($diskFreeVal !== false) {
                $diskFree = $this->formatBytes($diskFreeVal);
            }
            if ($diskTotalVal !== false) {
                $diskTotal = $this->formatBytes($diskTotalVal);
            }
        } catch (\Throwable $e) {
            // Ignored
        }

        $data = [
            'title'              => 'Panel Maintenance Developer',
            'php_version'        => $phpVersion,
            'db_version'         => $dbVersion,
            'db_platform'        => $dbPlatform,
            'cache_size'         => $this->formatBytes($cacheSize),
            'logs_size'          => $this->formatBytes($logsSize),
            'debug_size'         => $this->formatBytes($debugSize),
            'tables'             => $tables,
            'activity_logs'      => $logs,
            'maintenance_active' => $maintenanceActive,
            // New premium environment stats
            'environment'        => defined('ENVIRONMENT') ? ENVIRONMENT : 'production',
            'os'                 => PHP_OS_FAMILY . ' (' . php_uname('r') . ')',
            'upload_limit'       => ini_get('upload_max_filesize'),
            'post_limit'         => ini_get('post_max_size'),
            'memory_limit'       => ini_get('memory_limit'),
            'db_name'            => $db->database,
            'db_host'            => $db->hostname,
            'disk_free'          => $diskFree,
            'disk_total'         => $diskTotal,
        ];

        return view('Developer/index', $data);
    }

    public function toggleMaintenance()
    {
        $maintenanceFile = WRITEPATH . 'maintenance.json';
        $active = (bool) $this->request->getPost('active');

        $data = [
            'active'     => $active,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (file_put_contents($maintenanceFile, json_encode($data))) {
            $status = $active ? 'diaktifkan' : 'nonaktifkan';
            
            // Log this action
            $this->logActivity('Mengubah mode maintenance menjadi ' . $status, 'Developer Panel');

            return redirect()->to('/admin/developer')->with('success', 'Mode Maintenance berhasil ' . $status . '.');
        }

        return redirect()->to('/admin/developer')->with('error', 'Gagal mengubah status Mode Maintenance.');
    }

    public function clearCache()
    {
        helper('filesystem');
        
        $cleared = 0;
        $paths = [
            WRITEPATH . 'cache/',
            WRITEPATH . 'debugbar/'
        ];

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $files = scandir($path);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..' && $file !== '.gitignore' && $file !== 'index.html') {
                        @unlink($path . $file);
                        $cleared++;
                    }
                }
            }
        }

        $this->logActivity('Membersihkan cache aplikasi (' . $cleared . ' file)', 'Developer Panel');

        return redirect()->to('/admin/developer')->with('success', 'Berhasil membersihkan ' . $cleared . ' file cache.');
    }

    public function clearLogs()
    {
        $db = Database::connect();
        
        if ($db->tableExists('log_aktivitas')) {
            $db->table('log_aktivitas')->truncate();
            $this->logActivity('Membersihkan semua log aktivitas sistem', 'Developer Panel');
            return redirect()->to('/admin/developer')->with('success', 'Log aktivitas sistem berhasil dikosongkan.');
        }

        return redirect()->to('/admin/developer')->with('error', 'Tabel log_aktivitas tidak ditemukan.');
    }

    public function resetDatabase()
    {
        $sqlPath = ROOTPATH . 'db_tk.sql';
        if (!file_exists($sqlPath)) {
            return redirect()->to('/admin/developer')->with('error', 'File db_tk.sql tidak ditemukan di root project.');
        }

        $db = Database::connect();
        
        try {
            // Disable foreign key checks during reset
            $db->query('SET FOREIGN_KEY_CHECKS = 0');
            
            $sqlContent = file_get_contents($sqlPath);
            
            // Split queries by semicolon (handling comments)
            $queries = explode(';', $sqlContent);
            
            $executed = 0;
            foreach ($queries as $query) {
                $trimmed = trim($query);
                // Skip empty queries or pure comments
                if ($trimmed !== '' && !str_starts_with($trimmed, '--') && !str_starts_with($trimmed, '/*')) {
                    $db->query($trimmed);
                    $executed++;
                }
            }
            
            $db->query('SET FOREIGN_KEY_CHECKS = 1');
            
            $this->logActivity('Melakukan reset database menggunakan db_tk.sql', 'Developer Panel');
            
            // Force log out because table structure was reset
            session()->destroy();
            
            return redirect()->to('/login')->with('success', 'Database berhasil di-reset ke keadaan awal. Silakan login kembali.');
        } catch (\Exception $e) {
            $db->query('SET FOREIGN_KEY_CHECKS = 1');
            return redirect()->to('/admin/developer')->with('error', 'Gagal mereset database: ' . $e->getMessage());
        }
    }

    public function logs()
    {
        $db = Database::connect();
        
        $search = $this->request->getGet('search');
        
        $builder = $db->table('log_aktivitas')
            ->select('log_aktivitas.*, users.username')
            ->join('users', 'users.id_users = log_aktivitas.id_user', 'left');
            
        if ($search) {
            $builder->groupStart()
                ->like('log_aktivitas.aksi', $search)
                ->orLike('log_aktivitas.modul', $search)
                ->orLike('users.username', $search)
            ->groupEnd();
        }
        
        // Pagination logic
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 30;
        $offset = ($page - 1) * $perPage;
        
        $totalBuilder = clone $builder;
        $totalLogs = $totalBuilder->countAllResults();
        
        $logs = $builder->orderBy('log_aktivitas.created_at', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
            
        $totalPages = ceil($totalLogs / $perPage);
        
        $data = [
            'title'       => 'Log Aktivitas & Perubahan Sistem',
            'logs'        => $logs,
            'search'      => $search,
            'page'        => $page,
            'total_pages' => $totalPages,
            'total_logs'  => $totalLogs
        ];
        
        return view('Developer/logs', $data);
    }

    public function backupDatabase()
    {
        $db = Database::connect();
        
        try {
            $db->initialize();
        } catch (\Throwable $e) {
            return redirect()->to('/admin/developer')->with('error', 'Database gagal terhubung: ' . $e->getMessage());
        }
        
        if (!$db->connID) {
            return redirect()->to('/admin/developer')->with('error', 'Database tidak terhubung.');
        }

        $tables = $db->listTables();
        $output = "-- RA PERWANIDA Database Backup\n";
        $output .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n";
        $output .= "-- PHP Version: " . PHP_VERSION . "\n\n";
        $output .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

        foreach ($tables as $table) {
            // Get CREATE TABLE statement
            $query = $db->query("SHOW CREATE TABLE " . $db->escapeIdentifiers($table));
            $row = $query->getRowArray();
            if (isset($row['Create Table'])) {
                $output .= "DROP TABLE IF EXISTS " . $db->escapeIdentifiers($table) . ";\n";
                $output .= $row['Create Table'] . ";\n\n";
            }

            // Get records
            $records = $db->table($table)->get()->getResultArray();
            if (!empty($records)) {
                $output .= "-- Data for table: " . $table . "\n";
                foreach ($records as $record) {
                    $keys = array_keys($record);
                    $values = array_map(function($val) use ($db) {
                        if ($val === null) {
                            return 'NULL';
                        }
                        return $db->escape($val);
                    }, array_values($record));
                    
                    $output .= "INSERT INTO " . $db->escapeIdentifiers($table) . " (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ");\n";
                }
                $output .= "\n";
            }
        }

        $output .= "SET FOREIGN_KEY_CHECKS = 1;\n";

        $filename = 'backup_db_' . date('Ymd_His') . '.sql';
        
        $this->logActivity('Melakukan backup database ke file ' . $filename, 'Developer Panel');

        return $this->response->setHeader('Content-Type', 'application/sql')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($output);
    }

    public function runQuery()
    {
        $queryText = trim((string) $this->request->getPost('sql_query'));
        if ($queryText === '') {
            return redirect()->to('/admin/developer')->with('error', 'Masukkan query SQL terlebih dahulu.');
        }

        $db = Database::connect();
        
        try {
            // Check query type
            $isSelect = preg_match('/^\s*select/i', $queryText);
            $isExplain = preg_match('/^\s*explain/i', $queryText);
            $isShow = preg_match('/^\s*show/i', $queryText);
            $isDescribe = preg_match('/^\s*desc/i', $queryText);

            $startTime = microtime(true);
            $queryResult = $db->query($queryText);
            $elapsedTime = round((microtime(true) - $startTime) * 1000, 2); // ms

            if ($isSelect || $isExplain || $isShow || $isDescribe) {
                $results = $queryResult->getResultArray();
                $fields = $queryResult->getFieldNames();
                
                session()->setFlashdata('query_success', 'Query berhasil dieksekusi dalam ' . $elapsedTime . ' ms.');
                session()->setFlashdata('query_results', $results);
                session()->setFlashdata('query_fields', $fields);
                session()->setFlashdata('query_sql', $queryText);
            } else {
                $affectedRows = $db->affectedRows();
                session()->setFlashdata('query_success', 'Query berhasil dieksekusi dalam ' . $elapsedTime . ' ms. Baris terpengaruh: ' . $affectedRows);
                session()->setFlashdata('query_sql', $queryText);
            }
            
            $this->logActivity('Menjalankan query SQL kustom via Console', 'Developer Panel');
        } catch (\Throwable $e) {
            session()->setFlashdata('query_error', 'Query Error: ' . $e->getMessage());
            session()->setFlashdata('query_sql', $queryText);
        }

        return redirect()->to('/admin/developer#query-console');
    }

    private function getDirectorySize($path): int
    {
        $size = 0;
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && $file !== '.gitignore' && $file !== 'index.html') {
                    $size += filesize($path . '/' . $file);
                }
            }
        }
        return $size;
    }

    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
