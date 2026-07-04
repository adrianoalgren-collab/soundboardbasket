<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Soundboard Basket</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Share+Tech+Mono&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
<style>
    :root {
        --wood-light: #c17a3d;
        --wood-dark: #8a531f;
        --navy: #10233f;
        --navy-deep: #0a1730;
        --orange: #ea6a1f;
        --cream: #f3e9d6;
        --led-red: #ff3b30;
        --led-off: #3a1010;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
        background:
            repeating-linear-gradient(90deg, var(--wood-light) 0px, var(--wood-light) 38px, var(--wood-dark) 38px, var(--wood-dark) 40px);
        background-attachment: fixed;
        padding: 32px 16px 64px;
        color: var(--cream);
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background: radial-gradient(circle at 50% 30%, transparent 0%, rgba(0,0,0,0.55) 100%);
        pointer-events: none;
        z-index: 0;
    }

    .wrap {
        position: relative;
        z-index: 1;
        max-width: 720px;
        margin: 0 auto;
    }

    .scoreboard {
        background: linear-gradient(180deg, var(--navy) 0%, var(--navy-deep) 100%);
        border: 3px solid #000;
        border-radius: 12px;
        padding: 22px 24px 26px;
        box-shadow: 0 10px 0 rgba(0,0,0,0.35), 0 20px 40px rgba(0,0,0,0.5);
        text-align: center;
    }

    .scoreboard h1 {
        font-family: 'Anton', sans-serif;
        letter-spacing: 4px;
        font-size: 34px;
        margin: 0 0 4px;
        color: var(--orange);
        text-shadow: 0 0 12px rgba(234,106,31,0.6);
    }

    .scoreboard .sub {
        font-size: 12px;
        letter-spacing: 3px;
        color: rgba(243,233,214,0.5);
        margin-bottom: 16px;
        text-transform: uppercase;
    }

    .led-display {
        font-family: 'Share Tech Mono', monospace;
        font-size: 22px;
        letter-spacing: 2px;
        background: #1a0a0a;
        border: 2px solid #000;
        border-radius: 6px;
        padding: 14px 10px;
        color: var(--led-off);
        transition: color 0.15s ease, text-shadow 0.15s ease;
        min-height: 20px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .led-display.on {
        color: var(--led-red);
        text-shadow: 0 0 8px rgba(255,59,48,0.85), 0 0 18px rgba(255,59,48,0.5);
    }

    .grid {
        margin-top: 28px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    @media (min-width: 520px) {
        .grid { grid-template-columns: repeat(3, 1fr); }
    }

    .btn {
        position: relative;
        border: none;
        cursor: pointer;
        border-radius: 10px;
        padding: 16px 10px 14px;
        background: linear-gradient(180deg, #16294a 0%, #0c1a30 100%);
        border: 1px solid rgba(243,233,214,0.12);
        color: var(--cream);
        text-align: left;
        transition: transform 0.08s ease, box-shadow 0.08s ease, border-color 0.15s ease;
        box-shadow: 0 4px 0 rgba(0,0,0,0.4);
        outline-offset: 3px;
    }

    .btn:hover {
        border-color: var(--orange);
    }

    .btn:active,
    .btn.playing {
        transform: translateY(3px);
        box-shadow: 0 1px 0 rgba(0,0,0,0.4);
        border-color: var(--orange);
        background: linear-gradient(180deg, #24365a 0%, #142443 100%);
    }

    .btn .num {
        font-family: 'Anton', sans-serif;
        font-size: 28px;
        color: rgba(234,106,31,0.85);
        line-height: 1;
        display: block;
        margin-bottom: 6px;
    }

    .btn .label {
        font-weight: 800;
        font-size: 13px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: block;
    }

    .btn .desc {
        font-size: 11px;
        color: rgba(243,233,214,0.55);
        display: block;
        margin-top: 2px;
    }

    .court-line {
        margin-top: 26px;
        height: 2px;
        background: repeating-linear-gradient(90deg, var(--cream) 0 10px, transparent 10px 20px);
        opacity: 0.35;
    }

    .footer-note {
        text-align: center;
        font-size: 12px;
        color: rgba(243,233,214,0.5);
        margin-top: 14px;
    }

    .stop-all {
        display: block;
        margin: 18px auto 0;
        background: transparent;
        border: 1px solid rgba(243,233,214,0.3);
        color: var(--cream);
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .stop-all:hover { border-color: var(--orange); color: var(--orange); }
</style>
</head>
<body>
<div class="wrap">

    <div class="scoreboard">
        <h1>Soundboard Basket</h1>
        <div class="sub">Home Team FX Console</div>
        <div id="led" class="led-display">-- pilih tombol --</div>
        <button type="button" class="stop-all" onclick="stopAll()">Stop semua suara</button>
    </div>

    <div class="grid">
        @foreach ($sounds as $i => $s)
            <button
                type="button"
                class="btn"
                data-file="{{ $s['file'] }}"
                data-name="{{ $s['label'] }}"
                onclick="playSound(this)"
            >
                <span class="num">{{ sprintf('%02d', $i + 1) }}</span>
                <span class="label">{{ $s['label'] }}</span>
                <span class="desc">{{ $s['desc'] }}</span>
            </button>
        @endforeach
    </div>

    <div class="court-line"></div>
    <p class="footer-note">Taruh file suara di folder <code>public/sounds/</code> sesuai nama file masing-masing tombol.</p>
</div>

<script>
    const led = document.getElementById('led');
    const audioCache = {};
    let activeButtons = [];

    function playSound(btn) {
        const file = btn.dataset.file;
        const name = btn.dataset.name;
        const src = '/sounds/' + file;

        if (!audioCache[file]) {
            audioCache[file] = new Audio(src);
        }
        const audio = audioCache[file];
        audio.currentTime = 0;

        audio.play().then(() => {
            setLed(name.toUpperCase(), true);
        }).catch(() => {
            setLed('FILE BELUM ADA: ' + file, true);
        });

        btn.classList.add('playing');
        activeButtons.push(btn);
        audio.onended = () => {
            btn.classList.remove('playing');
        };
    }

    function setLed(text, on) {
        led.textContent = text;
        led.classList.toggle('on', on);
    }

    function stopAll() {
        Object.values(audioCache).forEach(a => {
            a.pause();
            a.currentTime = 0;
        });
        activeButtons.forEach(b => b.classList.remove('playing'));
        activeButtons = [];
        setLed('-- semua suara dihentikan --', false);
    }
</script>
</body>
</html>
