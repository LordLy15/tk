<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        try {

            $db = \Config\Database::connect();

            if ($db->connID) {

                echo "<h1 style='color:green'>DATABASE BERHASIL TERKONEK</h1>";

            } else {

                echo "<h1 style='color:red'>DATABASE GAGAL</h1>";

            }

        } catch (\Exception $e) {

            echo "<h1 style='color:red'>ERROR DATABASE</h1>";

            echo $e->getMessage();
        }
    }
}