<?php

namespace App\Http\Controllers;

use App\Models\TicketSelection;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketSelectionController extends Controller
{
    public function create(): View
    {
        $takenNumbers = TicketSelection::query()
            ->pluck('ticket_number')
            ->map(fn (int $number) => (int) $number)
            ->all();

        return view('tickets.create', compact('takenNumbers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'twitter_username' => strtolower(ltrim(trim((string) $request->input('twitter_username')), '@')),
        ]);

        $data = $request->validate([
            'ticket_number' => ['required', 'integer', 'between:1,1000'],
            'twitter_username' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_]{1,80}$/', 'unique:ticket_selections,twitter_username'],
        ], [
            'ticket_number.required' => 'Selecciona un número.',
            'ticket_number.between' => 'El número debe estar entre 1 y 1000.',
            'twitter_username.regex' => 'Escribe un usuario de Twitter válido, por ejemplo: @usuario.',
            'twitter_username.unique' => 'Ese usuario de Twitter ya registró un número.',
        ]);

        try {
            $selection = TicketSelection::create([
                'ticket_number' => $data['ticket_number'],
                'twitter_username' => ltrim($data['twitter_username'], '@'),
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1000),
            ]);
        } catch (QueryException $exception) {
            if ($this->isDuplicateTicket($exception)) {
                $field = str_contains($exception->getMessage(), 'twitter_username')
                    ? 'twitter_username'
                    : 'ticket_number';

                return back()->withInput()->withErrors([
                    $field => $field === 'twitter_username'
                        ? 'Ese usuario de Twitter ya registró un número.'
                        : 'Ese número acaba de ser seleccionado por otra persona. Elige otro.',
                ]);
            }

            throw $exception;
        }

        return redirect()->route('tickets.create')->with('success', sprintf(
            'El número %d quedó registrado correctamente.',
            $selection->ticket_number,
        ));
    }

    private function isDuplicateTicket(QueryException $exception): bool
    {
        return str_contains(strtolower($exception->getMessage()), 'unique')
            || str_contains(strtolower($exception->getMessage()), 'duplicate');
    }
}
