<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Sedang Maintenance - RA PERWANIDA</title>
    
    <link rel="icon" type="image/svg+xml" href="/tk/public/assets/dashboard/images/logo-ra.svg">
    <link rel="shortcut icon" type="image/svg+xml" href="/tk/public/assets/dashboard/images/logo-ra.svg">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        :root {
            --bg-gradient: radial-gradient(circle at top right, #1e1b4b 0%, #0f0b18 50%, #09050d 100%);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.07);
            --glow-color: rgba(139, 92, 246, 0.5);
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: var(--bg-gradient);
            font-family: 'Inter', sans-serif;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .ambient-glow-1 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, rgba(124, 58, 237, 0) 70%);
            top: -100px;
            right: -100px;
            z-index: 0;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, rgba(14, 165, 233, 0) 70%);
            bottom: -150px;
            left: -150px;
            z-index: 0;
            pointer-events: none;
        }

        .container {
            z-index: 10;
            max-width: 600px;
            width: 90%;
            padding: 40px 30px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-align: center;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .logo-area {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .logo-area img {
            width: 40px;
            height: 40px;
            filter: drop-shadow(0 0 8px rgba(139, 92, 246, 0.4));
        }

        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .pulse-icon-container {
            width: 90px;
            height: 90px;
            background: rgba(139, 92, 246, 0.1);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            position: relative;
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.2);
        }

        .pulse-icon-container i {
            font-size: 42px;
            color: #a78bfa;
            animation: wrench 2.5s ease-in-out infinite;
        }

        .pulse-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 1px solid rgba(139, 92, 246, 0.5);
            border-radius: 50%;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 32px;
            color: #fff;
            margin: 0 0 16px 0;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 30px 0;
            color: #94a3b8;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 14px;
        }

        .info-card i {
            font-size: 20px;
            color: #38bdf8;
        }

        .btn-logout {
            background: linear-gradient(135deg, #7c3aed 0%, #4c1d95 100%);
            border: 1px solid rgba(167, 139, 250, 0.3);
            color: #fff;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #8b5cf6 0%, #5b21b6 100%);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.5);
            transform: translateY(-1px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { opacity: 0.3; }
            100% { transform: scale(1.3); opacity: 0; }
        }

        @keyframes wrench {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(15deg); }
            20% { transform: rotate(-10deg); }
            30% { transform: rotate(15deg); }
            40% { transform: rotate(-5deg); }
            50% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
    </style>
</head>
<body>

    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="container">
        <div class="logo-area">
            <img src="/tk/public/assets/dashboard/images/logo-ra.svg" alt="Logo RA">
            <span class="brand-name">RA PERWANIDA</span>
        </div>

        <div>
            <div class="pulse-icon-container">
                <div class="pulse-circle"></div>
                <i class="ti ti-tool"></i>
            </div>
        </div>

        <h1>Sistem Dalam Maintenance</h1>
        <p>Mohon maaf atas ketidaknyamanan Anda. Saat ini sistem aplikasi sekolah sedang menjalani pemeliharaan berkala untuk meningkatkan performa dan fitur baru.</p>

        <div class="info-card">
            <i class="ti ti-info-circle"></i>
            <span>Hanya akun <strong>Developer</strong> yang diperkenankan mengakses dashboard selama masa pemeliharaan.</span>
        </div>

        <a href="/tk/public/logout" class="btn-logout">
            <i class="ti ti-logout"></i>
            Keluar Aplikasi
        </a>
    </div>

</body>
</html>
