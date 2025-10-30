<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class DonationController extends Controller
{
    public function __construct(private readonly StripeClient $stripeClient) {}

public function store(Request $request)
    {

        $validationRules = [
            // Persönliche Daten
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],

            // Adresse
            'street' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:20', 'regex:/^[0-9]{5}$/'], // PLZ-Regel ergänzt
            'city' => ['required', 'string', 'max:255'],

            // Spendenbetrag
            'amount' => [
                'required_without:custom_amount',
                'nullable',
                'numeric',
                'in:7.50,12.50,15.00,25.00,50.00'
            ],
            'custom_amount' => [
                'required_without:amount',
                'nullable',
                'numeric',
                'min:7.50'
            ],

            // Zahlungsintervall
            'interval' => ['required', 'string', 'in:monthly,yearly'],

            // Zustimmung
            'privacy' => ['accepted'],

            // Newsletter (optional)
            'newsletter' => ['nullable', 'boolean'],
        ];
        
        $data = $request->validate($validationRules);

        $fullName = $data['first_name'] . ' ' . $data['last_name'];
        
        $address = [
            'line1' => $data['street'], // 'street' aus dem Formular wird zu 'line1'
            'city' => $data['city'],
            'postal_code' => $data['zip'],
            'country' => 'DE', // Für deutsche NGOs und Adressen standardmäßig 'DE'
        ];

        // Customer Object erstellen
        $customer = $this->stripeClient->customers->create([
            'name' => $fullName,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null, // 'phone' ist optional
            'address' => $address,
            'preferred_locales' => ['de'],
            'metadata' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'newsletter_opt_in' => $data['newsletter'] ? 'yes' : 'no',
            ],
        ]);
        
        // HINWEIS: Hier müsste nun die Logik folgen, um:
        // 1. Den tatsächlichen Betrag zu ermitteln ($data['amount'] oder $data['custom_amount'])
        // 2. Den Kunden zur Auswahl der Zahlungsmethode (z.B. SEPA) weiterzuleiten
        // 3. Das Subscription-Objekt zu erstellen.

        $amount = $customer['amount'] ?? $customer['custom_amount'];

        
        // Beispiel für die Weiterleitung (Platzhalter)
        return redirect()->route('donation.payment', [
            'customer_id' => $customer->id,
            'interval' => $customer['interval'],
            'amount' => $amount
        ]);
    }
}
