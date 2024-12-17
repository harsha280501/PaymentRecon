@livewireScripts()

{{-- meta --}}
<meta name="_token" content="{{ csrf_token() }}" />
{{-- request script --}}
<script src="{{ asset('/assets/js/requests/requests.js') }}"></script>

{{-- configure the request Object --}}
<script defer>
    const request = createHttpRequest("{{ url('/') }}");
    const BASEURL = "{{ url('/') }}";
    const CSRFTOKEN = "{{ csrf_token() }}";
    //alert("BASEURL"+BASEURL);

</script>


<script defer>
    function getEndOfMonth(date) {
        // Clone the date to avoid modifying the original
        const clonedDate = new Date(date);

        // Set the date to the next month's first day
        clonedDate.setMonth(clonedDate.getMonth() + 1, 1);

        // Subtract one day to get the last day of the current month
        clonedDate.setDate(clonedDate.getDate() - 1);

        return clonedDate.toISOString().split('T')[0];
    }



    function getUrlParams(data) {
        const params = new URLSearchParams(window.location.search)
        return params.get(data);
    }



    function confirmAction(callback, message, errorCallback = null) {
        Swal.fire({
            title: 'Confirm Action'
            , text: message
            , icon: 'question'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Confirm'
            , cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed == true) {
                callback()
            }
        }).catch((error) => {
            errorCallback()
        });
    }

</script>



<script defer>
    // initalizing success message function if not initalized already
    // if (typeof succesMessageConfiguration !== 'function') {
    /**
     * Generating success response
     * @param {*} message
     * @returns
     */
    const succesMessageConfiguration = (message) => {
        return Swal.fire("Success!", message, "success");
    };
    // }

    // initalizing success message function if not initalized already
    // if (typeof errorMessageConfiguration !== 'function') {
    /**
     * Generating error response
     * @param {*} message
     * @returns
     */
    const errorMessageConfiguration = (message) => {
        return Swal.fire("Error!", message, "error");
    };
    // }

</script>
