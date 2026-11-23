<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion | Tickets Alfa</title>
    <style>
        :root { font-family: Inter, ui-sans-serif, system-ui, sans-serif; color: #172033; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f7fb; }
        .wrap { width: min(1180px, calc(100% - 32px)); margin: auto; padding: 40px 0; }
        header { display: flex; justify-content: space-between; gap: 16px; align-items: end; margin-bottom: 24px; }
        h1 { margin: 4px 0; letter-spacing: -.04em; }
        .muted { color: #718096; }
        .button { display: inline-block; padding: 11px 15px; border-radius: 9px; background: #2764e7; color: white; text-decoration: none; font-weight: 700; }
        .card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; overflow: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 850px; }
        th, td { text-align: left; padding: 13px 16px; border-bottom: 1px solid #edf1f6; font-size: .9rem; white-space: nowrap; }
        th { background: #f8fafc; color: #526078; font-size: .78rem; text-transform: uppercase; letter-spacing: .06em; }
        .number { font-weight: 800; color: #2764e7; }
        .pagination { padding: 18px; }
        @media (max-width: 700px) { header { align-items: start; flex-direction: column; } }
    </style>
</head>
<body>
<main class="wrap">
    <header>
        <div><div class="muted">Tickets Alfa</div><h1>Selecciones registradas</h1><div class="muted">{{ $selections->total() }} tickets registrados</div></div>
        <a class="button" href="{{ route('admin.tickets.export') }}">Descargar Excel (CSV)</a>
    </header>
    <section class="card">
        <table>
            <thead><tr><th>Numero</th><th>Usuario de Twitter</th><th>IP</th><th>Ubicacion</th><th>Fecha</th></tr></thead>
            <tbody>
            @forelse ($selections as $selection)
                <tr><td class="number">{{ $selection->ticket_number }}</td><td>{{ '@'.$selection->twitter_username }}</td><td>{{ $selection->ip_address ?: '-' }}</td><td>{{ $selection->ip_location ?: 'No registrada' }}</td><td>{{ $selection->created_at->format('d/m/Y H:i') }}</td></tr>
            @empty
                <tr><td colspan="5">Todavia no hay selecciones.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $selections->links() }}</div>
    </section>
</main>
</body>
</html>
