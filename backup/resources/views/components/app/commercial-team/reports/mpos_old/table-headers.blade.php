<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        <tr>
            <td class="left"> Date</td>
            <td class="left"> Store ID </td>
            <td class="left"> RETEK Code </td>
            <td class="left"> Brand Desc </td>
            <td class="left"> City </td>
            <td class="right"> Cash </td>
        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
