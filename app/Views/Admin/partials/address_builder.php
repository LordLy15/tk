<?php
$field = $field ?? 'alamat';
$label = $label ?? 'Alamat';
$value = old($field, $value ?? '');
$required = $required ?? false;
$structuredRequired = $structuredRequired ?? ($structured_required ?? $required);
$id = preg_replace('/[^A-Za-z0-9_-]/', '-', $field) . '-' . bin2hex(random_bytes(3));
$parts = tk_parse_address($value);

$fieldValue = static function (string $key) use ($field, $parts) {
    return old($field . '_' . $key, $parts[$key] ?? '');
};

$provinces = tk_indonesia_provinces();
$selectedProvince = $fieldValue('provinsi');
?>

<div class="address-builder" data-address-builder>
    <input type="hidden"
           name="<?= esc($field) ?>"
           value="<?= esc($value) ?>"
           data-address-output
        <?= $required ? 'required' : '' ?>>

    <div class="form-section-title">
        <span><?= esc($label) ?></span>
        <?php if ($required) : ?>
            <span class="required-mark">*</span>
        <?php endif; ?>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <label for="<?= esc($id) ?>-jalan" class="form-label">Jalan dan Nomor</label>
            <textarea id="<?= esc($id) ?>-jalan"
                      name="<?= esc($field) ?>_jalan"
                      class="form-control"
                      rows="2"
                      data-address-field="jalan"
                      placeholder="Contoh: Jl. Melati No. 12"
                <?= $structuredRequired ? 'required' : '' ?>><?= esc($fieldValue('jalan')) ?></textarea>
            <div class="form-hint">Isi nama jalan, nomor rumah, blok, atau nama komplek.</div>
        </div>

        <div class="col-6 col-md-3">
            <label for="<?= esc($id) ?>-rt" class="form-label">RT</label>
            <input id="<?= esc($id) ?>-rt"
                   type="text"
                   name="<?= esc($field) ?>_rt"
                   class="form-control"
                   maxlength="3"
                   inputmode="numeric"
                   value="<?= esc($fieldValue('rt')) ?>"
                   data-address-field="rt"
                   data-digit-only>
        </div>

        <div class="col-6 col-md-3">
            <label for="<?= esc($id) ?>-rw" class="form-label">RW</label>
            <input id="<?= esc($id) ?>-rw"
                   type="text"
                   name="<?= esc($field) ?>_rw"
                   class="form-control"
                   maxlength="3"
                   inputmode="numeric"
                   value="<?= esc($fieldValue('rw')) ?>"
                   data-address-field="rw"
                   data-digit-only>
        </div>

        <div class="col-md-6">
            <label for="<?= esc($id) ?>-kode-pos" class="form-label">Kode Pos</label>
            <input id="<?= esc($id) ?>-kode-pos"
                   type="text"
                   name="<?= esc($field) ?>_kode_pos"
                   class="form-control"
                   maxlength="5"
                   inputmode="numeric"
                   value="<?= esc($fieldValue('kode_pos')) ?>"
                   data-address-field="kode_pos"
                   data-digit-only>
        </div>

        <div class="col-md-6">
            <label for="<?= esc($id) ?>-provinsi" class="form-label">Provinsi</label>
            <select id="<?= esc($id) ?>-provinsi"
                    name="<?= esc($field) ?>_provinsi"
                    class="form-select"
                    data-address-field="provinsi"
                    data-province-select
                <?= $structuredRequired ? 'required' : '' ?>>
                <option value="">Pilih Provinsi</option>
                <?php foreach ($provinces as $province) : ?>
                    <option value="<?= esc($province) ?>" <?= $selectedProvince === $province ? 'selected' : '' ?>>
                        <?= esc($province) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="<?= esc($id) ?>-kota" class="form-label">Kabupaten/Kota</label>
            <input id="<?= esc($id) ?>-kota"
                   type="text"
                   name="<?= esc($field) ?>_kota"
                   class="form-control"
                   value="<?= esc($fieldValue('kota')) ?>"
                   list="<?= esc($id) ?>-kota-list"
                   data-address-field="kota"
                   data-city-input
                   placeholder="Pilih atau ketik kabupaten/kota"
                <?= $structuredRequired ? 'required' : '' ?>>
            <datalist id="<?= esc($id) ?>-kota-list" data-city-list></datalist>
        </div>

        <div class="col-md-6">
            <label for="<?= esc($id) ?>-kecamatan" class="form-label">Kecamatan</label>
            <input id="<?= esc($id) ?>-kecamatan"
                   type="text"
                   name="<?= esc($field) ?>_kecamatan"
                   class="form-control"
                   value="<?= esc($fieldValue('kecamatan')) ?>"
                   data-address-field="kecamatan"
                   placeholder="Contoh: Cengkareng"
                <?= $structuredRequired ? 'required' : '' ?>>
        </div>

        <div class="col-md-6">
            <label for="<?= esc($id) ?>-kelurahan" class="form-label">Kelurahan/Desa</label>
            <input id="<?= esc($id) ?>-kelurahan"
                   type="text"
                   name="<?= esc($field) ?>_kelurahan"
                   class="form-control"
                   value="<?= esc($fieldValue('kelurahan')) ?>"
                   data-address-field="kelurahan"
                   placeholder="Contoh: Rawa Buaya"
                <?= $structuredRequired ? 'required' : '' ?>>
        </div>

        <div class="col-12">
            <label for="<?= esc($id) ?>-catatan" class="form-label">Patokan/Catatan</label>
            <input id="<?= esc($id) ?>-catatan"
                   type="text"
                   name="<?= esc($field) ?>_catatan"
                   class="form-control"
                   value="<?= esc($fieldValue('catatan')) ?>"
                   data-address-field="catatan"
                   placeholder="Contoh: dekat masjid atau gerbang sekolah">
        </div>

        <div class="col-12">
            <label class="form-label">Preview Alamat Lengkap</label>
            <textarea class="form-control address-preview"
                      rows="3"
                      data-address-preview
                      readonly><?= esc($value) ?></textarea>
        </div>
    </div>
</div>
