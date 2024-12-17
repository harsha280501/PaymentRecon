/**
 * Ajax requests
 */
class Request {
    // getting the root url
    constructor(url) {
        this.routeUrl = url;
    }

    async http(ajaxConfiguration, headers = {}) {
        ajaxConfiguration.url = this.routeUrl + ajaxConfiguration.url;
        // main dfata return template
        const defaultReturnData = {
            data: [],
            error: null,
            isLoading: false,
            isError: false,
            isSuccess: false,
        };

        // main function
        try {
            defaultReturnData.isLoading = true;
            // ajax request
            const data = await $.ajax({
                ...ajaxConfiguration,
                headers: {
                    "X-CSRF-Token": $("meta[name=_token]").attr("content"),
                },
            }); // unique way to get all the events

            defaultReturnData.isSuccess = true;
            defaultReturnData.data = data;

            if (data.length) {
                defaultReturnData.isLoading = false;
            }

            return defaultReturnData;
        } catch (error) {
            defaultReturnData.isError = true;
            defaultReturnData.date = null;
            defaultReturnData.error = {
                mesage: error?.responseJSON?.message,
                status: error?.status,
            };

            console.log(defaultReturnData);
            return defaultReturnData;
        }
    }
}

const createHttpRequest = (baseUrl) => {
    return new Request(baseUrl);
};
