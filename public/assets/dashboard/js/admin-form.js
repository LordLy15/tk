const provinceCities = {
    'Aceh': ['Banda Aceh', 'Langsa', 'Lhokseumawe', 'Sabang'],
    'Sumatera Utara': ['Medan', 'Binjai', 'Pematangsiantar', 'Tebing Tinggi'],
    'Sumatera Barat': ['Padang', 'Bukittinggi', 'Payakumbuh', 'Pariaman'],
    'Riau': ['Pekanbaru', 'Dumai', 'Bengkalis', 'Siak'],
    'Kepulauan Riau': ['Batam', 'Tanjungpinang', 'Bintan', 'Karimun'],
    'Jambi': ['Jambi', 'Sungai Penuh', 'Muaro Jambi', 'Tanjung Jabung Barat'],
    'Sumatera Selatan': ['Palembang', 'Prabumulih', 'Lubuklinggau', 'Pagar Alam'],
    'Bangka Belitung': ['Pangkalpinang', 'Bangka', 'Belitung', 'Bangka Barat'],
    'Bengkulu': ['Bengkulu', 'Rejang Lebong', 'Bengkulu Utara', 'Seluma'],
    'Lampung': ['Bandar Lampung', 'Metro', 'Lampung Selatan', 'Lampung Tengah'],
    'DKI Jakarta': ['Jakarta Barat', 'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Utara', 'Kepulauan Seribu'],
    'Banten': ['Tangerang', 'Tangerang Selatan', 'Serang', 'Cilegon', 'Pandeglang'],
    'Jawa Barat': ['Bandung', 'Bekasi', 'Bogor', 'Depok', 'Cimahi', 'Cirebon', 'Sukabumi', 'Tasikmalaya'],
    'Jawa Tengah': ['Semarang', 'Surakarta', 'Magelang', 'Pekalongan', 'Salatiga', 'Tegal'],
    'DI Yogyakarta': ['Yogyakarta', 'Bantul', 'Sleman', 'Kulon Progo', 'Gunungkidul'],
    'Jawa Timur': ['Surabaya', 'Malang', 'Kediri', 'Madiun', 'Mojokerto', 'Pasuruan', 'Probolinggo'],
    'Bali': ['Denpasar', 'Badung', 'Gianyar', 'Tabanan', 'Buleleng'],
    'Nusa Tenggara Barat': ['Mataram', 'Bima', 'Lombok Barat', 'Lombok Tengah'],
    'Nusa Tenggara Timur': ['Kupang', 'Ende', 'Maumere', 'Labuan Bajo'],
    'Kalimantan Barat': ['Pontianak', 'Singkawang', 'Ketapang', 'Sintang'],
    'Kalimantan Tengah': ['Palangka Raya', 'Sampit', 'Pangkalan Bun', 'Kapuas'],
    'Kalimantan Selatan': ['Banjarmasin', 'Banjarbaru', 'Martapura', 'Barabai'],
    'Kalimantan Timur': ['Samarinda', 'Balikpapan', 'Bontang', 'Kutai Kartanegara'],
    'Kalimantan Utara': ['Tanjung Selor', 'Tarakan', 'Nunukan', 'Malinau'],
    'Sulawesi Utara': ['Manado', 'Bitung', 'Tomohon', 'Kotamobagu'],
    'Gorontalo': ['Gorontalo', 'Bone Bolango', 'Boalemo', 'Pohuwato'],
    'Sulawesi Tengah': ['Palu', 'Donggala', 'Poso', 'Tolitoli'],
    'Sulawesi Barat': ['Mamuju', 'Majene', 'Polewali Mandar', 'Mamasa'],
    'Sulawesi Selatan': ['Makassar', 'Parepare', 'Palopo', 'Gowa', 'Maros'],
    'Sulawesi Tenggara': ['Kendari', 'Baubau', 'Kolaka', 'Konawe'],
    'Maluku': ['Ambon', 'Tual', 'Maluku Tengah', 'Buru'],
    'Maluku Utara': ['Ternate', 'Tidore Kepulauan', 'Halmahera Barat', 'Halmahera Utara'],
    'Papua': ['Jayapura', 'Keerom', 'Sarmi', 'Biak Numfor'],
    'Papua Barat': ['Manokwari', 'Fakfak', 'Kaimana', 'Teluk Bintuni'],
    'Papua Barat Daya': ['Sorong', 'Maybrat', 'Raja Ampat', 'Tambrauw'],
    'Papua Pegunungan': ['Jayawijaya', 'Yahukimo', 'Tolikara', 'Lanny Jaya'],
    'Papua Selatan': ['Merauke', 'Boven Digoel', 'Mappi', 'Asmat'],
    'Papua Tengah': ['Nabire', 'Mimika', 'Paniai', 'Dogiyai'],
};

function cleanDigits(input) {
    input.value = input.value.replace(/\D/g, '');
}

function getAddressField(builder, name) {
    return builder.querySelector(`[data-address-field="${name}"]`);
}

function setCityOptions(builder) {
    const province = getAddressField(builder, 'provinsi')?.value || '';
    const list = builder.querySelector('[data-city-list]');

    if (!list) {
        return;
    }

    list.innerHTML = '';

    (provinceCities[province] || []).forEach((city) => {
        const option = document.createElement('option');
        option.value = city;
        list.appendChild(option);
    });
}

function composeAddress(builder) {
    const value = (name) => (getAddressField(builder, name)?.value || '').trim();
    const lines = [];
    const detailParts = [];
    const jalan = value('jalan');
    const rt = value('rt');
    const rw = value('rw');
    const kelurahan = value('kelurahan');
    const kecamatan = value('kecamatan');
    const kota = value('kota');
    const provinsi = value('provinsi');
    const kodePos = value('kode_pos');
    const catatan = value('catatan');

    if (jalan) {
        lines.push(jalan);
    }

    if (rt || rw) {
        detailParts.push(`RT ${rt || '-'}/RW ${rw || '-'}`);
    }

    if (kelurahan) {
        detailParts.push(`Kel. ${kelurahan}`);
    }

    if (kecamatan) {
        detailParts.push(`Kec. ${kecamatan}`);
    }

    if (kota) {
        detailParts.push(kota);
    }

    if (provinsi) {
        detailParts.push(provinsi);
    }

    if (kodePos) {
        detailParts.push(`Kode Pos ${kodePos}`);
    }

    if (detailParts.length) {
        lines.push(detailParts.join(', '));
    }

    if (catatan) {
        lines.push(`Patokan: ${catatan}`);
    }

    const address = lines.join('\n').trim();
    const output = builder.querySelector('[data-address-output]');
    const preview = builder.querySelector('[data-address-preview]');

    if (output) {
        output.value = address;
    }

    if (preview) {
        preview.value = address;
    }
}

function initAddressBuilder(builder) {
    setCityOptions(builder);
    composeAddress(builder);

    builder.querySelectorAll('[data-address-field]').forEach((field) => {
        field.addEventListener('input', () => composeAddress(builder));
        field.addEventListener('change', () => {
            if (field.matches('[data-province-select]')) {
                setCityOptions(builder);
            }

            composeAddress(builder);
        });
    });
}

function initProfessionalForms() {
    document.querySelectorAll('.content select.form-control').forEach((select) => {
        select.classList.add('form-select');
    });

    document.querySelectorAll('[data-digit-only]').forEach((input) => {
        input.addEventListener('input', () => cleanDigits(input));
        cleanDigits(input);
    });

    document.querySelectorAll('[data-address-builder]').forEach(initAddressBuilder);

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            form.querySelectorAll('[data-address-builder]').forEach(composeAddress);

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });
    });
}

document.addEventListener('DOMContentLoaded', initProfessionalForms);
