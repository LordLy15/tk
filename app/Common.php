<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('tk_trim_value')) {
    function tk_trim_value($value): string
    {
        return trim((string) ($value ?? ''));
    }
}

if (! function_exists('tk_compose_address_from_post')) {
    function tk_compose_address_from_post(array $post, string $field = 'alamat'): string
    {
        $jalan = tk_trim_value($post[$field . '_jalan'] ?? '');
        $rt = tk_trim_value($post[$field . '_rt'] ?? '');
        $rw = tk_trim_value($post[$field . '_rw'] ?? '');
        $kelurahan = tk_trim_value($post[$field . '_kelurahan'] ?? '');
        $kecamatan = tk_trim_value($post[$field . '_kecamatan'] ?? '');
        $kota = tk_trim_value($post[$field . '_kota'] ?? '');
        $provinsi = tk_trim_value($post[$field . '_provinsi'] ?? '');
        $kodePos = tk_trim_value($post[$field . '_kode_pos'] ?? '');
        $catatan = tk_trim_value($post[$field . '_catatan'] ?? '');
        $fallback = tk_trim_value($post[$field] ?? '');

        $hasStructuredAddress = $jalan !== ''
            || $rt !== ''
            || $rw !== ''
            || $kelurahan !== ''
            || $kecamatan !== ''
            || $kota !== ''
            || $provinsi !== ''
            || $kodePos !== ''
            || $catatan !== '';

        if (! $hasStructuredAddress) {
            return $fallback;
        }

        $lines = [];

        if ($jalan !== '') {
            $lines[] = $jalan;
        }

        $parts = [];

        if ($rt !== '' || $rw !== '') {
            $parts[] = 'RT ' . ($rt !== '' ? $rt : '-') . '/RW ' . ($rw !== '' ? $rw : '-');
        }

        if ($kelurahan !== '') {
            $parts[] = 'Kel. ' . $kelurahan;
        }

        if ($kecamatan !== '') {
            $parts[] = 'Kec. ' . $kecamatan;
        }

        if ($kota !== '') {
            $parts[] = $kota;
        }

        if ($provinsi !== '') {
            $parts[] = $provinsi;
        }

        if ($kodePos !== '') {
            $parts[] = 'Kode Pos ' . $kodePos;
        }

        if ($parts !== []) {
            $lines[] = implode(', ', $parts);
        }

        if ($catatan !== '') {
            $lines[] = 'Patokan: ' . $catatan;
        }

        return trim(implode("\n", $lines));
    }
}

if (! function_exists('tk_parse_address')) {
    function tk_parse_address(?string $address): array
    {
        $value = tk_trim_value($address);
        $parts = [
            'jalan' => $value,
            'rt' => '',
            'rw' => '',
            'kelurahan' => '',
            'kecamatan' => '',
            'kota' => '',
            'provinsi' => '',
            'kode_pos' => '',
            'catatan' => '',
        ];

        if ($value === '') {
            return $parts;
        }

        if (preg_match('/Patokan:\s*(.+)$/im', $value, $match)) {
            $parts['catatan'] = trim($match[1]);
            $value = trim(preg_replace('/Patokan:\s*.+$/im', '', $value));
        }

        if (preg_match('/Kode\s*Pos\s*:?[\s-]*(\d{5})/i', $value, $match)) {
            $parts['kode_pos'] = $match[1];
            $value = trim(preg_replace('/,?\s*Kode\s*Pos\s*:?[\s-]*\d{5}/i', '', $value));
        }

        if (preg_match('/RT\s*([0-9]{1,3}|-)\s*\/\s*RW\s*([0-9]{1,3}|-)/i', $value, $match)) {
            $parts['rt'] = $match[1] !== '-' ? $match[1] : '';
            $parts['rw'] = $match[2] !== '-' ? $match[2] : '';
            $value = trim(preg_replace('/,?\s*RT\s*([0-9]{1,3}|-)\s*\/\s*RW\s*([0-9]{1,3}|-)/i', '', $value));
        }

        $segments = preg_split('/\r\n|\r|\n|,/', $value);
        $jalanSegments = [];
        $provinceMap = array_change_key_case(array_combine(tk_indonesia_provinces(), tk_indonesia_provinces()), CASE_LOWER);

        foreach ($segments as $segment) {
            $segment = trim($segment);

            if ($segment === '') {
                continue;
            }

            if (preg_match('/^(Prov\.?|Provinsi)\s+(.+)$/i', $segment, $match)) {
                $province = $provinceMap[strtolower(trim($match[2]))] ?? null;

                if ($province) {
                    $parts['provinsi'] = $province;
                    continue;
                }
            }

            $province = $provinceMap[strtolower($segment)] ?? null;

            if ($province) {
                $parts['provinsi'] = $province;
                continue;
            }

            if (preg_match('/^(Kel\.?|Kelurahan)\s+(.+)$/i', $segment, $match)) {
                $parts['kelurahan'] = trim($match[2]);
                continue;
            }

            if (preg_match('/^(Kec\.?|Kecamatan)\s+(.+)$/i', $segment, $match)) {
                $parts['kecamatan'] = trim($match[2]);
                continue;
            }

            if (preg_match('/^(Kota|Kab\.?|Kabupaten)\s+(.+)$/i', $segment, $match)) {
                $parts['kota'] = trim($match[1] . ' ' . $match[2]);
                continue;
            }

            $jalanSegments[] = $segment;
        }

        if ($parts['provinsi'] !== '' && $parts['kota'] === '' && count($jalanSegments) > 1) {
            $parts['kota'] = array_pop($jalanSegments);
        }

        if ($jalanSegments !== []) {
            $parts['jalan'] = trim(implode(', ', $jalanSegments));
        }

        return $parts;
    }
}

if (! function_exists('tk_indonesia_provinces')) {
    function tk_indonesia_provinces(): array
    {
        return [
            'Aceh',
            'Sumatera Utara',
            'Sumatera Barat',
            'Riau',
            'Kepulauan Riau',
            'Jambi',
            'Sumatera Selatan',
            'Bangka Belitung',
            'Bengkulu',
            'Lampung',
            'DKI Jakarta',
            'Banten',
            'Jawa Barat',
            'Jawa Tengah',
            'DI Yogyakarta',
            'Jawa Timur',
            'Bali',
            'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
            'Kalimantan Barat',
            'Kalimantan Tengah',
            'Kalimantan Selatan',
            'Kalimantan Timur',
            'Kalimantan Utara',
            'Sulawesi Utara',
            'Gorontalo',
            'Sulawesi Tengah',
            'Sulawesi Barat',
            'Sulawesi Selatan',
            'Sulawesi Tenggara',
            'Maluku',
            'Maluku Utara',
            'Papua',
            'Papua Barat',
            'Papua Barat Daya',
            'Papua Pegunungan',
            'Papua Selatan',
            'Papua Tengah',
        ];
    }
}
