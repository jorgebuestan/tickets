<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tu número</title>
    <style>
        :root { color-scheme: light; font-family: Inter, ui-sans-serif, system-ui, sans-serif; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f7fb; color: #172033; }
        .wrap { width: min(1120px, calc(100% - 32px)); margin: 0 auto; padding: 48px 0; }
        .hero { margin-bottom: 28px; }
        .eyebrow { color: #2764e7; font-size: .78rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
        h1 { margin: 8px 0; font-size: clamp(2rem, 5vw, 3.8rem); letter-spacing: -.05em; }
        .intro { color: #657188; max-width: 620px; font-size: 1.05rem; }
        .layout { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 24px; align-items: start; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 22px; padding: 24px; box-shadow: 0 15px 40px #1b3a6810; }
        .card h2 { margin: 0 0 6px; font-size: 1.2rem; }
        .muted { color: #718096; font-size: .9rem; }
        .numbers { display: grid; grid-template-columns: repeat(10, minmax(0, 1fr)); gap: 8px; margin-top: 22px; }
        .number { border: 1px solid #d8e0ec; background: #f9fbfe; color: #243b63; border-radius: 10px; padding: 10px 3px; cursor: pointer; font-weight: 700; }
        .number:hover, .number.selected { background: #2764e7; color: #fff; border-color: #2764e7; }
        .number.taken { background: #e8edf4; color: #9aa6b8; cursor: not-allowed; text-decoration: line-through; }
        label { display: block; margin: 16px 0 6px; font-size: .88rem; font-weight: 700; }
        input { width: 100%; padding: 12px 13px; border: 1px solid #d8e0ec; border-radius: 10px; font: inherit; }
        input:focus { outline: 3px solid #2764e733; border-color: #2764e7; }
        .submit { width: 100%; border: 0; border-radius: 11px; margin-top: 20px; padding: 14px; background: #172033; color: #fff; font: inherit; font-weight: 800; cursor: pointer; }
        .submit:hover { background: #2764e7; }
        .check { display: flex; gap: 8px; align-items: flex-start; margin-top: 18px; color: #657188; font-size: .8rem; }
        .check input { width: auto; margin-top: 3px; }
        .alert { border-radius: 10px; padding: 12px; margin-bottom: 16px; font-size: .9rem; }
        .success { background: #e7f8ef; color: #17663a; }
        .errors { background: #fff0f0; color: #a32929; }
        @media (max-width: 760px) { .layout { grid-template-columns: 1fr; } .numbers { grid-template-columns: repeat(5, 1fr); } .wrap { padding: 28px 0; } }
    </style>
</head>
<body>
<main class="wrap">
    <section class="hero">
        <div class="eyebrow">Tickets Alfa</div>
        <h1>Elige tu número</h1>
        <p class="intro">Selecciona un número disponible del 1 al 1000. Una vez confirmado, quedará reservado para ti.</p>
    </section>

    @if (session('success')) <div class="alert success">{{ session('success') }}</div> @endif
    @if ($errors->any()) <div class="alert errors">{{ $errors->first() }}</div> @endif

    <div class="layout">
        <section class="card">
            <h2>Números disponibles</h2>
            <div class="muted">Gris: seleccionado · Azul: disponible</div>
            <div class="numbers">
                @for ($number = 1; $number <= 1000; $number++)
                    <button type="button" class="number {{ in_array($number, $takenNumbers, true) ? 'taken' : '' }}" data-number="{{ $number }}" {{ in_array($number, $takenNumbers, true) ? 'disabled' : '' }}>{{ $number }}</button>
                @endfor
            </div>
        </section>

        <form class="card" method="POST" action="{{ route('tickets.store') }}">
            @csrf
            <h2>Tu usuario de Twitter</h2>
            <p class="muted">Solo necesitamos tu usuario para registrar la selección.</p>
            <input type="hidden" name="ticket_number" id="ticket_number" value="{{ old('ticket_number') }}">
            <label for="selected_number">Número elegido</label>
            <input id="selected_number" value="{{ old('ticket_number') }}" placeholder="Selecciona un número" readonly>
            <label for="twitter_username">Usuario de Twitter</label>
            <input id="twitter_username" name="twitter_username" value="{{ old('twitter_username') }}" placeholder="@usuario" required maxlength="80">
            <button class="submit" type="submit">Confirmar selección</button>
        </form>
    </div>
</main>
<script>
    const hidden = document.querySelector('#ticket_number');
    const visible = document.querySelector('#selected_number');
    document.querySelectorAll('.number:not(.taken)').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelector('.number.selected')?.classList.remove('selected');
            button.classList.add('selected');
            hidden.value = button.dataset.number;
            visible.value = button.dataset.number;
        });
    });
</script>
</body>
</html>
