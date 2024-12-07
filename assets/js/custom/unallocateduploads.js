// submitting the banks
/**
 * Generating error response
 * @param {*} message
 * @returns
 */
/*const errorMessageConfiguration = (message) => {
    return Swal.fire("Error!", message, "error");
};*/

/**
 * Generating success response
 * @param {*} message
 * @returns
 */
/*const succesMessageConfiguration = (message) => {
    return Swal.fire("Success!", message, "success");
};
*/
// fetch idfc data
const mainUpload1 = async (url, data) => {
    if (!data || data == undefined) {
        errorMessageConfiguration("Please import a file");
        return false;
    }

    // form data
    const formData = new FormData();
    formData.append("file", data);

    // Fetch main data
    const {
        data: main,
        isError,
        error,
    } = await request.http({
        url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
    });
    // Error
    if (isError) {
        errorMessageConfiguration(error?.mesage);
        return false;
    }
    // main
    return main;
};

// 1. idfc
const cardimportModal = document.querySelector("#import-modal");
const cardimportModalSubmitButton = cardimportModal.querySelector("#uploadBtn");
const cardimportFileUpload = cardimportModal.querySelector("#import-modalFileUploadBtn");
const cardidfcLoader = cardimportModal.querySelector(".loader");

/**
 * Main Submit Event
 */
cardimportModalSubmitButton.addEventListener("click", async (e) => {
    cardidfcLoader.style.display = "unset";
    cardimportModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload1(
        cardimportModal.dataset.url,
        cardimportFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        cardimportModalSubmitButton.removeAttribute("disabled");
        cardidfcLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    cardidfcLoader.style.display = "none";
    cardimportModalSubmitButton.removeAttribute("disabled");

    window.location.reload();
    // setTimeout(() => {
    // }, 2000);
});
