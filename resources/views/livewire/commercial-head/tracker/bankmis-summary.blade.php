<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank MIS Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            color: black;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            color: black;
        }

        th {
            font-weight: bold;
        }

        .header-row {
            background-color: #ddd;
            font-weight: bold;
        }

        .axis-header,
        .axis-sub {
            background-color: #ffcccc;
        }

        .icici-header,
        .icici-sub {
            background-color: #ccffcc;
        }

        .sbicash2-header,
        .sbicash2-sub {
            background-color: #cce0ff;
        }

        .sbihcm-header,
        .sbihcm-sub {
            background-color: #ffffcc;
        }

        .sbihcm2-header,
        .sbihcm2-sub {
            background-color: #ffccff;
        }

        .tabs {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
        }

        .tabs .tab {
            padding: 10px 20px;
            cursor: pointer;
            text-align: center;
            color: black;
            /* Set tab name color to black */
            font-weight: bold;
            /* Optional: makes the text bold */
        }

        .tabs .tab.active {
            background-color: #ddd;
            font-weight: bold;
        }

        /* Scrollable Container Style */
        .table-container {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 500px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        /* Optional: Add a fixed height for the tables */
        table {
            min-width: 800px;
            /* Adjust width as per the content */
        }
    </style>
</head>

<body>


    <!-- Tab Navigation -->
    <ul class="tabs">
        <li class="tab active">CASH</li>
        <li class="tab">CARD</li>
        <li class="tab">UPI</li>
        <li class="tab">WALLET</li>
    </ul>

    <!-- Table Data Containers -->
    <div id="cash" class="table-container w-100">
        <table>
            <tr class="header-row">
                <th class="date-column" rowspan="2" colspan="2">Date</th>
                <th class="axis-header" colspan="4">AXIS</th>
                <th class="icici-header" colspan="4">ICICI</th>
                <th class="sbicash2-header" colspan="4">SBICASH2</th>
                <th class="sbihcm-header" colspan="4">SBIHCM</th>
                <th class="sbihcm2-header" colspan="4">SBIHCM2</th>
            </tr>
            <tr>
                <th class="axis-sub">BANKMIS</th>
                <th class="axis-sub">RECO COLLECTION</th>
                <th class="axis-sub">UNALLOCATED</th>
                <th class="axis-sub">DIFFERENCE</th>

                <th class="icici-sub">BANKMIS</th>
                <th class="icici-sub">RECO COLLECTION</th>
                <th class="icici-sub">UNALLOCATED</th>
                <th class="icici-sub">DIFFERENCE</th>

                <th class="sbicash2-sub">BANKMIS</th>
                <th class="sbicash2-sub">RECO COLLECTION</th>
                <th class="sbicash2-sub">UNALLOCATED</th>
                <th class="sbicash2-sub">DIFFERENCE</th>

                <th class="sbihcm-sub">BANKMIS</th>
                <th class="sbihcm-sub">RECO COLLECTION</th>
                <th class="sbihcm-sub">UNALLOCATED</th>
                <th class="sbihcm-sub">DIFFERENCE</th>

                <th class="sbihcm2-sub">BANKMIS</th>
                <th class="sbihcm2-sub">RECO COLLECTION</th>
                <th class="sbihcm2-sub">UNALLOCATED</th>
                <th class="sbihcm2-sub">DIFFERENCE</th>
            </tr>

            @foreach ($data as $item)
                <tr>
                    <td colspan="2" style="white-space: nowrap;">{{ $item->Date }}</td>

                    <!-- Axis Bank Data -->
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Axis Bank Mis'}, 2) }}">
                        {{ number_format($item->{'Axis Bank Mis'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Axis Reco Collection'}, 2) }}">
                        {{ number_format($item->{'Axis Reco Collection'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Axis Unallocated'}, 2) }}">
                        {{ number_format($item->{'Axis Unallocated'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Axis Difference'}, 2) }}">
                        {{ number_format($item->{'Axis Difference'}, 3) }}</td>

                    <!-- ICICI Bank Data -->
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Icici Bank Mis'}, 2) }}">
                        {{ number_format($item->{'Icici Bank Mis'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Icici Reco Collection'}, 2) }}">
                        {{ number_format($item->{'Icici Reco Collection'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Icici Unallocated'}, 2) }}">
                        {{ number_format($item->{'Icici Unallocated'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Icici Difference'}, 2) }}">
                        {{ number_format($item->{'Icici Difference'}, 3) }}</td>

                    <!-- SBI Cash Data -->
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Sbi Cash Mis'}, 2) }}">
                        {{ number_format($item->{'Sbi Cash Mis'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Sbi Reco Collection'}, 2) }}">
                        {{ number_format($item->{'Sbi Reco Collection'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Sbi Unallocated'}, 2) }}">
                        {{ number_format($item->{'Sbi Unallocated'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'Sbi Difference'}, 2) }}">
                        {{ number_format($item->{'Sbi Difference'}, 3) }}</td>

                    <!-- SBIHCM Data -->
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM Bank Mis'}, 2) }}">
                        {{ number_format($item->{'SbiHCM Bank Mis'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM Reco Collection'}, 2) }}">
                        {{ number_format($item->{'SbiHCM Reco Collection'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM Unallocated'}, 2) }}">
                        {{ number_format($item->{'SbiHCM Unallocated'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM Difference'}, 2) }}">
                        {{ number_format($item->{'SbiHCM Difference'}, 3) }}</td>

                    <!-- SBIHCM2 Data -->
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM2 Bank Mis'}, 2) }}">
                        {{ number_format($item->{'SbiHCM2 Bank Mis'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM2 Reco Collection'}, 2) }}">
                        {{ number_format($item->{'SbiHCM2 Reco Collection'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM2 Unallocated'}, 2) }}">
                        {{ number_format($item->{'SbiHCM2 Unallocated'}, 3) }}</td>
                    <td data-bs-toggle="tooltip" title="{{ number_format($item->{'SbiHCM2 Difference'}, 2) }}">
                        {{ number_format($item->{'SbiHCM2 Difference'}, 3) }}</td>
                </tr>
            @endforeach
        </table>

    </div>

    <!-- CARD Table Data Container -->
    <div id="card" class="table-container" style="display:none;">
        <table>
            <tr class="header-row">
                <th class="date-column" rowspan="2" colspan="2">Date</th>
                <th class="axis-header" colspan="4">HDFC CARD</th>
                <th class="icici-header" colspan="4">ICICI CARD</th>
                <th class="axis-header" colspan="4">AMEX CARD</th>
                <th class="sbihcm-header" colspan="4">SBI CARD</th>
            </tr>
            <tr>
                <th class="axis-sub">BANKMIS</th>
                <th class="axis-sub">RECO COLLECTION</th>
                <th class="axis-sub">UNAALOCATED</th>
                <th class="axis-sub">DIFFERENCE</th>

                <th class="icici-sub">BANKMIS</th>
                <th class="icici-sub">RECO COLLECTION</th>
                <th class="icici-sub">UNAALOCATED</th>
                <th class="icici-sub">DIFFERENCE</th>

                <th class="axis-sub">BANKMIS</th>
                <th class="axis-sub">RECO COLLECTION</th>
                <th class="axis-sub">UNAALOCATED</th>
                <th class="axis-sub">DIFFERENCE</th>

                <th class="sbihcm-sub">BANKMIS</th>
                <th class="sbihcm-sub">RECO COLLECTION</th>
                <th class="sbihcm-sub">UNAALOCATED</th>
                <th class="sbihcm-sub">DIFFERENCE</th>
            </tr>
            <tr>
                <td colspan="2" style="white-space: nowrap;">01-11-2024</td>
                <td>500</td>
                <td>450</td>
                <td>50</td>
                <td>0</td>
                <td>600</td>
                <td>550</td>
                <td>50</td>
                <td>0</td>
                <td>700</td>
                <td>650</td>
                <td>50</td>
                <td>0</td>
                <td>800</td>
                <td>750</td>
                <td>50</td>
                <td>0</td>
            </tr>
        </table>
    </div>

    <!-- UPI Table Data Container -->
    <div id="upi" class="table-container w-50" style="display:none;">
        <table>
            <tr class="header-row">
                <th class="date-column" rowspan="2" colspan="2">Date</th>
                <th class="axis-header" colspan="4">HDFC UPI</th>
            </tr>
            <tr>
                <th class="axis-sub">BANKMIS</th>
                <th class="axis-sub">RECO COLLECTION</th>
                <th class="axis-sub">UNAALOCATED</th>
                <th class="axis-sub">DIFFERENCE</th>
            </tr>
            <tr>
                <td colspan="2" style="white-space: nowrap;">01-11-2024</td>
                <td>500</td>
                <td>450</td>
                <td>50</td>
                <td>0</td>
            </tr>
        </table>
    </div>

    <!-- WALLET Table Data Container -->
    <div id="wallet" class="table-container w-75" style="display:none; overflow-x: auto; max-width: 100%;">
        <table style="width: 100%; min-width: 1000px;">
            <tr class="header-row">
                <th class="date-column" rowspan="2" colspan="2" style="min-width: 150px;">Date</th>
                <th class="axis-header" colspan="4" style="min-width: 70px;">WALLET PHONEPAY</th>
                <th class="icici-header" colspan="4" style="min-width: 70px;">WALLET PAYTM</th>
            </tr>
            <tr>
                <th class="axis-sub" style="min-width: 70px;">BANKMIS</th>
                <th class="axis-sub" style="min-width: 70px;">RECO COLLECTION</th>
                <th class="axis-sub" style="min-width: 70px;">UNAALOCATED</th>
                <th class="axis-sub" style="min-width: 70px;">DIFFERENCE</th>

                <th class="icici-sub" style="min-width: 70px;">BANKMIS</th>
                <th class="icici-sub" style="min-width: 70px;">RECO COLLECTION</th>
                <th class="icici-sub" style="min-width: 70px;">UNAALOCATED</th>
                <th class="icici-sub" style="min-width: 70px;">DIFFERENCE</th>
            </tr>
            <tr>
                <td colspan="2" style="white-space: nowrap;">01-11-2024</td>
                <td>100</td>
                <td>50</td>
                <td>50</td>
                <td>0</td>
                <td>200</td>
                <td>150</td>
                <td>50</td>
                <td>0</td>
            </tr>
        </table>
    </div>


    <script>
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.table-container');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                // Hide all tab contents
                tabContents.forEach(content => content.style.display = 'none');
                // Remove active class from all tabs
                tabs.forEach(tab => tab.classList.remove('active'));
                // Show the corresponding tab content
                tabContents[index].style.display = 'block';
                // Add active class to the clicked tab
                tab.classList.add('active');
            });
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>

</html>
