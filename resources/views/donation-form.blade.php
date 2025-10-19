<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hermine Patenschaft</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Patenschaft abschließen</h1>

        @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('donation.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Persönliche Daten --}}
            <div>
                <h2 class="text-xl font-semibold mb-4">Persönliche Daten</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Vorname *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nachname *</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-Mail *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefon (optional)</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            {{-- Adresse --}}
            <div>
                <h2 class="text-xl font-semibold mb-4">Adresse</h2>
                <div class="mt-2">
                    <label for="street" class="block text-sm font-medium text-gray-700">Straße & Hausnummer *</label>
                    <input type="text" name="street" id="street" value="{{ old('street') }}"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('street')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="zip" class="block text-sm font-medium text-gray-700">PLZ *</label>
                        <input type="text" name="zip" id="zip" value="{{ old('zip') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('zip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Stadt *</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Spendenbetrag --}}
            <div>
                <h2 class="text-xl font-semibold mb-4">Spendenbetrag</h2>

                <div class="flex flex-wrap gap-3">
                    @foreach ([7.50, 12.50, 15.00, 25.00, 50.00] as $preset)
                    <label class="inline-flex items-center">
                        <input type="radio" name="amount" value="{{ $preset }}"
                            class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                            @checked(old('amount')==$preset)>
                        <span class="ml-2">{{ number_format($preset, 2, ',', '.') }} €</span>
                    </label>
                    @endforeach
                </div>

                <div class="mt-4">
                    <label for="custom_amount" class="block text-sm font-medium text-gray-700">Oder eigener Betrag (mind. 7,50 €)</label>
                    <input type="number" name="custom_amount" id="custom_amount" step="0.01" min="7.50"
                        value="{{ old('custom_amount') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            {{-- Zahlungsintervall --}}
            <div>
                <h2 class="text-xl font-semibold mb-4">Zahlungsintervall</h2>
                <div class="flex gap-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="interval" value="monthly" required
                            class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                            @checked(old('interval')==='monthly' )>
                        <span class="ml-2">Monatlich</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="interval" value="yearly" required
                            class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                            @checked(old('interval')==='yearly' )>
                        <span class="ml-2">Jährlich</span>
                    </label>
                </div>
                @error('interval')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Datenschutz --}}
            <div>
                <div class="flex items-start">
                    <input id="privacy" name="privacy" type="checkbox" required
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="privacy" class="ml-2 block text-sm text-gray-700">
                        Ich stimme der Verarbeitung meiner Daten gemäß der
                        <a href="{{ route('privacy') }}" target="_blank" class="underline text-indigo-600 hover:text-indigo-800">Datenschutzerklärung</a> zu.
                    </label>
                </div>
                @error('privacy')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Optional: Newsletter --}}
            <div>
                <div class="flex items-start">
                    <input id="newsletter" name="newsletter" type="checkbox"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                        @checked(old('newsletter'))>
                    <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                        Ich möchte den Newsletter erhalten (optional).
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-6">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Weiter zur Zahlungsart
                </button>
            </div>
        </form>
    </div>
</body>

</html>