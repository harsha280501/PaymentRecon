<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        <tr>
            <th>Store ID</th>
            <th>Store Name</th>
            <th>Retek Code</th>
            <th>Brand Desc</th>
            <th>Region</th>
            {{-- <th>SStatus</th> --}}
            <th>Pickup Bank</th>
            <th>Location</th>
            <th>City</th>
            <th>State</th>
            <th>Pincode</th>
            <th>Action</th>
        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
