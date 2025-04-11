<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GWM Nepal: ORA 03 EV Booking</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16892671741">
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-16892671741');
        </script>
    </head>
<body class="bg-gray-100 flex flex-col justify-center items-center min-h-screen p-4">

    <img src="{{ asset('images/logo.png') }}" alt="" width="100" class="mb-4">

    <div class="flex flex-row-reverse items-center bg-white p-5 sm:p-8 rounded-lg shadow-lg w-full max-w-5xl gap-8">
        <div class="lg:w-1/2">
            <h2 class="text-2xl font-bold mb-2">Booking for ORA 03 EV</h2>
            <p class="mb-4">Please fill in the form below to book your test drive.</p>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('ads.submit') }}" method="POST">
                @csrf

                <input type="hidden" value="" id="adTrackInput" name="ad_track_id">

                <div class="mb-4">
                    <label class="block font-semibold">Name <span class="text-red-600">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full p-2 border rounded">
                    @error('name')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Email <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full p-2 border rounded">
                    @error('email')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Phone <span class="text-red-600">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full p-2 border rounded">
                    @error('phone')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Location <span class="text-red-600">*</span></label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full p-2 border rounded">
                    @error('location')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Interested In Dropdown --}}
                <div class="mb-4">
                    <label class="block font-semibold">Interested In <span class="text-red-600">*</span></label>
                    <select name="interested_in" class="w-full p-2 border rounded">
                        <option value="" disabled selected>Select an option</option>
                        <option value="Buying" {{ old('interested_in') == 'New Car' ? 'selected' : '' }}>New Car</option>
                        <option value="Leasing" {{ old('interested_in') == 'Test Drive' ? 'selected' : '' }}>Test Drive</option>
                        <option value="Test Drive" {{ old('interested_in') == 'Financing Options' ? 'selected' : '' }}>Financing Options</option>
                    </select>
                    @error('interested_in')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold">Message</label>
                    <textarea name="message" class="w-full p-2 border rounded">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-700 text-white py-2 rounded hover:bg-gradient-to-r hover:from-red-600 hover:to-red-800">
                    Submit
                </button>
            </form>
        </div>
        <div class="hidden lg:block w-1/2 h-full relative">
            <img src="{{ asset('images/ora 03 ev.jpg') }}" alt="Car Image" class="h-full object-cover rounded-lg shadow-lg">
        </div>
    </div>

    <script>
        // Function to generate a UUID (Universal Unique Identifier)
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        // Function to set a cookie
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Set expiration time in days
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";  // Set the cookie
        }

        function sendAdTrackIdToServer(adTrackId) {
            // Send an AJAX request to the backend to store the ad_track_id in the database
            fetch('/store-ad-track-id', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token for security
                },
                body: JSON.stringify({ ad_track_id: adTrackId }) // Send the ad_track_id in the request body
            })
            .then(response => response.json())  // Wait for the server's response and parse the JSON
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error:', error); // Log any errors from the request
            });
        }


        // Check if the ad_track_id cookie exists, otherwise generate and set a new one
        function checkAndSetAdTrackCookie() {
            // Check if cookie already exists
            var cookieName = "ad_track_id";
            var cookieValue = getCookie(cookieName);

            if (!cookieValue) {
                // If cookie doesn't exist, generate a new one and set it
                var newAdTrackId = generateUUID();
                setCookie(cookieName, newAdTrackId, 365);
            }

            var adTrackId = getCookie('ad_track_id');  // Get the cookie value

            if (adTrackId) {
                document.getElementById('adTrackInput').value = adTrackId;  // Set the input field value
            }

            var newAdTrackId = getCookie('ad_track_id');  // Get the cookie value again

            sendAdTrackIdToServer(newAdTrackId);
        }

        // Function to get the value of a cookie by name
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        // Call function to check and set ad_track_id cookie
        checkAndSetAdTrackCookie();
    </script>

</body>
</html>
