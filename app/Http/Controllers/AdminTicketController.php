<?php

namespace App\Http\Controllers;

use App\Models\TicketSelection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class AdminTicketController extends Controller
{
    public function index(): View
    {
        $selections = TicketSelection::query()
            ->latest()
            ->paginate(50);

        return view('admin.tickets.index', compact('selections'));
    }

    public function export(): StreamedResponse
    {
        $filename = 'tickets-alfa-'.now()->format('Y-m-d_H-i-s').'.csv';

        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            fprintf($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Numero', 'Usuario de Twitter', 'IP', 'Ubicacion', 'Fecha'], ';');

            TicketSelection::query()->orderBy('ticket_number')->chunkById(250, function ($selections) use ($output): void {
                foreach ($selections as $selection) {
                    fputcsv($output, [
                        $selection->ticket_number,
                        '@'.$selection->twitter_username,
                        $selection->ip_address,
                        $selection->ip_location,
                        $selection->created_at?->format('Y-m-d H:i:s'),
                    ], ';');
                }
            });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
