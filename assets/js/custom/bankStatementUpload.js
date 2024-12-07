// 1. HDFC
const hdfcModal = document.querySelector("#hdfcBankStatementUploadModal");
const hdfcModalSubmitButton = hdfcModal.querySelector("#uploadBtn");
const hdfcFileUpload = hdfcModal.querySelector("#hdfcBankStatementUploadModalFileUploadBtn");
const hdfcLoader = hdfcModal.querySelector(".loader");

/**
 * Main Submit Event
 */
hdfcModalSubmitButton.addEventListener("click", async (e) => {
    hdfcLoader.style.display = "unset";
    hdfcModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        hdfcModal.dataset.url,
        hdfcFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        hdfcModalSubmitButton.removeAttribute("disabled");
        hdfcLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    hdfcLoader.style.display = "none";
    hdfcModalSubmitButton.removeAttribute("disabled");

    setTimeout(() => {
        window.location.reload();
    }, 2000);
});


//ICICI

const iciciBankModal = document.querySelector("#iciciBankStatementUploadModal");
const iciciBankModalSubmitButton = iciciBankModal.querySelector("#uploadBtn");
const iciciBankFileUpload = iciciBankModal.querySelector("#iciciBankStatementUploadModalFileUploadBtn");
const iciciBankLoader = iciciBankModal.querySelector(".loader");

/**
 * Main Submit Event
 */
iciciBankModalSubmitButton.addEventListener("click", async (e) => {
    iciciBankLoader.style.display = "unset";
    iciciBankModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        iciciBankModal.dataset.url,
        iciciBankFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        iciciBankModalSubmitButton.removeAttribute("disabled");
        iciciBankLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    iciciBankLoader.style.display = "none";
    iciciBankModalSubmitButton.removeAttribute("disabled");

    setTimeout(() => {
        window.location.reload();
    }, 2000);
});


//SBI

const sbiBankModal = document.querySelector("#sbiBankStatementUploadModal");
const sbiBankModalSubmitButton = sbiBankModal.querySelector("#uploadBtn");
const sbiBankModalFileUpload = sbiBankModal.querySelector("#sbiBankStatementUploadModalFileUploadBtn");
const sbiBankModalLoader = sbiBankModal.querySelector(".loader");

/**
 * Main Submit Event
 */
sbiBankModalSubmitButton.addEventListener("click", async (e) => {
    sbiBankModalLoader.style.display = "unset";
    sbiBankModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        sbiBankModal.dataset.url,
        sbiBankModalFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        sbiBankModalSubmitButton.removeAttribute("disabled");
        sbiBankModalLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbiBankModalLoader.style.display = "none";
    sbiBankModalSubmitButton.removeAttribute("disabled");

    setTimeout(() => {
        window.location.reload();
    }, 2000);
});


//AXIS

const axisBankModal = document.querySelector("#axisBankStatementModel");
const axisBankModalSubmitButton = axisBankModal.querySelector("#uploadBtn");
const axisBankModalFileUpload = axisBankModal.querySelector("#axisBankStatementModelFileUploadBtn");
const axisBankModalLoader = axisBankModal.querySelector(".loader");

/**
 * Main Submit Event
 */
axisBankModalSubmitButton.addEventListener("click", async (e) => {
    axisBankModalLoader.style.display = "unset";
    axisBankModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        axisBankModal.dataset.url,
        axisBankModalFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        axisBankModalSubmitButton.removeAttribute("disabled");
        axisBankModalLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    axisBankModalLoader.style.display = "none";
    axisBankModalSubmitButton.removeAttribute("disabled");

    setTimeout(() => {
        window.location.reload();
    }, 2000);
});



//IDFC

const idfcBankModal = document.querySelector("#idfcBankStatementUploadModal");
const idfcBankModalSubmitButton = idfcBankModal.querySelector("#uploadBtn");
const idfcBankModalFileUpload = idfcBankModal.querySelector("#idfcBankStatementUploadModalFileUploadBtn");
const idfcBankModalLoader = idfcBankModal.querySelector(".loader");

/**
 * Main Submit Event
 */
idfcBankModalSubmitButton.addEventListener("click", async (e) => {
    idfcBankModalLoader.style.display = "unset";
    idfcBankModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        idfcBankModal.dataset.url,
        idfcBankModalFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        idfcBankModalSubmitButton.removeAttribute("disabled");
        idfcBankModalLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    idfcBankModalLoader.style.display = "none";
    idfcBankModalSubmitButton.removeAttribute("disabled");

    setTimeout(() => {
        window.location.reload();
    }, 2000);
});