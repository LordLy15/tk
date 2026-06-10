<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= lang('Errors.whoops') ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= function_exists('base_url') ? base_url('assets/dashboard/images/logo-ra.svg') : '/tk/public/assets/dashboard/images/logo-ra.svg' ?>">
    <link rel="shortcut icon" type="image/svg+xml" href="<?= function_exists('base_url') ? base_url('assets/dashboard/images/logo-ra.svg') : '/tk/public/assets/dashboard/images/logo-ra.svg' ?>">

    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>

    <div class="container text-center">

        <h1 class="headline"><?= lang('Errors.whoops') ?></h1>

        <p class="lead"><?= lang('Errors.weHitASnag') ?></p>

    </div>

</body>

</html>
