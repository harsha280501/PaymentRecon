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
const mainUpload = async (url, data) => {
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
const idfcModal = document.querySelector("#idfcUploadModal");
const idfcModalSubmitButton = idfcModal.querySelector("#uploadBtn");
const idfcFileUpload = idfcModal.querySelector("#idfcUploadModalFileUploadBtn");
const idfcLoader = idfcModal.querySelector(".loader");

/**
 * Main Submit Event
 */
idfcModalSubmitButton.addEventListener("click", async (e) => {
    idfcLoader.style.display = "unset";
    idfcModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        idfcModal.dataset.url,
        idfcFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        idfcModalSubmitButton.removeAttribute("disabled");
        idfcLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    idfcLoader.style.display = "none";
    idfcModalSubmitButton.removeAttribute("disabled");

    window.location.reload();
    // setTimeout(() => {
    // }, 2000);
});

// 2. SBI
const sbiModal = document.querySelector("#sbiUploadModal");
const sbiModalSubmitButton = sbiModal.querySelector("#uploadBtn");
const sbiFileUpload = sbiModal.querySelector("#sbiUploadModalFileUploadBtn");
const SBIloader = sbiModal.querySelector(".loader");

/**
 * Main Submit Event
 */
sbiModalSubmitButton.addEventListener("click", async (e) => {
    // upload file
    SBIloader.style.display = "unset";
    sbiModalSubmitButton.setAttribute("disabled", true);

    const data = await mainUpload(sbiModal.dataset.url, sbiFileUpload.files[0]);
    // if not data, dont want to contineu
    if (!data) {
        sbiModalSubmitButton.removeAttribute("disabled");
        SBIloader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbiModalSubmitButton.removeAttribute("disabled");
    SBIloader.style.display = "none";
    window.location.reload();
});

// SBI CARD MODEL
const sbiCardUploadModal = document.querySelector("#sbiCardUploadModal");
const sbiCardUploadModalSubmitButton =
    sbiCardUploadModal.querySelector("#uploadBtn");
const sbiCardUploadModalFileUploadBtn = sbiCardUploadModal.querySelector(
    "#sbiCardUploadModalFileUploadBtn"
);
const sbiCardLoader = sbiCardUploadModal.querySelector(".loader");

/**
 * Main Submit Event
 */
sbiCardUploadModalSubmitButton.addEventListener("click", async (e) => {
    sbiCardLoader.style.display = "unset";
    sbiCardUploadModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        sbiCardUploadModal.dataset.url,
        sbiCardUploadModalFileUploadBtn.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        sbiCardUploadModalSubmitButton.removeAttribute("disabled");
        sbiCardLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbiCardLoader.style.display = "none";
    sbiCardUploadModalSubmitButton.removeAttribute("disabled");

    window.location.reload();
    // setTimeout(() => {
    // }, 2000);
});
// SBI CARD MODEL ENDS

// 3. ICICI cash
const iciciModal = document.querySelector("#iciciUploadModal");
const iciciModalSubmitButton = iciciModal.querySelector("#uploadBtn");
const iciciFileUpload = iciciModal.querySelector(
    "#iciciUploadModalFileUploadBtn"
);
const iciciloader = iciciModal.querySelector(".loader");

iciciModalSubmitButton.addEventListener("click", async (e) => {
    iciciModalSubmitButton.setAttribute("disabled", true);
    iciciloader.style.display = "unset";
    // upload file
    const data = await mainUpload(
        iciciModal.dataset.url,
        iciciFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        iciciModalSubmitButton.removeAttribute("disabled", true);
        iciciloader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    iciciModalSubmitButton.removeAttribute("disabled", true);
    iciciloader.style.display = "none";
    window.location.reload();
    // setTimeout(() => {
    // }, 2000);
});

// 3. ICICI credit
const icicicreditModal = document.querySelector("#icicicreditUploadModal");
const icicicreditModalSubmitButton =
    icicicreditModal.querySelector("#uploadBtn");
const icicicreditFileUpload = icicicreditModal.querySelector(
    "#icicicreditUploadModalFileUploadBtn"
);
const iciciCreditloader = icicicreditModal.querySelector(".loader");

/**
 * Main Submit Event
 */
icicicreditModalSubmitButton.addEventListener("click", async (e) => {
    iciciCreditloader.style.display = "unset";
    icicicreditModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        icicicreditModal.dataset.url,
        icicicreditFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        icicicreditModalSubmitButton.removeAttribute("disabled");
        iciciCreditloader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    iciciCreditloader.style.display = "none";
    icicicreditModalSubmitButton.removeAttribute("disabled");
    //window.location.reload();
    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// HDFC UPload

// 1. HDFC UPI MODEL
const hdfcUPIModal = document.querySelector("#hdfcUPIModal");
const hdfcUPIModalSubmitButton = hdfcUPIModal.querySelector("#uploadBtn");
const hdfcUPIFileUpload = hdfcUPIModal.querySelector(
    "#hdfcUPIModalFileUploadBtn"
);
const hdfcUPILoader = hdfcUPIModal.querySelector(".loader");

/**
 * Main Submit Event
 */
hdfcUPIModalSubmitButton.addEventListener("click", async (e) => {
    hdfcUPILoader.style.display = "unset";
    hdfcUPIModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        hdfcUPIModal.dataset.url,
        hdfcUPIFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        hdfcUPIModalSubmitButton.removeAttribute("disabled");
        hdfcUPILoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    hdfcUPILoader.style.display = "none";
    hdfcUPIModalSubmitButton.removeAttribute("disabled");

    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// HDFC UPI MODEL Code ENDS

// 2. HDFC CARD MODEL
const hdfcCardmodel = document.querySelector("#hdfcCardmodel");
const hdfcCardModalSubmitButton = hdfcCardmodel.querySelector("#uploadBtn");
const hdfcCardmodelFileUploadBtn = hdfcCardmodel.querySelector(
    "#hdfcCardmodelFileUploadBtn"
);
const hdfcCardLoader = hdfcCardmodel.querySelector(".loader");

/**
 * Main Submit Event
 */
hdfcCardModalSubmitButton.addEventListener("click", async (e) => {
    hdfcCardLoader.style.display = "unset";
    hdfcCardModalSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        hdfcCardmodel.dataset.url,
        hdfcCardmodelFileUploadBtn.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        hdfcCardModalSubmitButton.removeAttribute("disabled");
        hdfcCardLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    hdfcCardLoader.style.display = "none";
    hdfcCardModalSubmitButton.removeAttribute("disabled");

    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// HDFC CARD MODEL Code ENDS

// 3. HDFC CASH MODEL
const hdfcCashmodel = document.querySelector("#hdfcCashmodel");
const hdfcCashmodelSubmitButton = hdfcCashmodel.querySelector("#uploadBtn");
const hdfcCashmodelFileUploadBtn = hdfcCashmodel.querySelector(
    "#hdfcCashmodelFileUploadBtn"
);
const hdfcCashLoader = hdfcCashmodel.querySelector(".loader");

/**
 * Main Submit Event
 */
hdfcCashmodelSubmitButton.addEventListener("click", async (e) => {
    hdfcCashLoader.style.display = "unset";
    hdfcCashmodelSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        hdfcCashmodel.dataset.url,
        hdfcCashmodelFileUploadBtn.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        hdfcCashmodelSubmitButton.removeAttribute("disabled");
        hdfcCashLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    hdfcCashLoader.style.display = "none";
    hdfcCashmodelSubmitButton.removeAttribute("disabled");

    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// HDFC CARD MODEL Code ENDS

// 3. AXIS CASH MODEL
const axisCashmodel = document.querySelector("#axisCashmodel");
const axisCashmodelSubmitButton = axisCashmodel.querySelector("#uploadBtn");
const axisCashmodelFileUploadBtn = axisCashmodel.querySelector(
    "#axisCashmodelFileUploadBtn"
);
const axisCashLoader = axisCashmodel.querySelector(".loader");

/**
 * Main Submit Event
 */
axisCashmodelSubmitButton.addEventListener("click", async (e) => {
    axisCashLoader.style.display = "unset";
    axisCashmodelSubmitButton.setAttribute("disabled", true);
    // upload file
    const data = await mainUpload(
        axisCashmodel.dataset.url,
        axisCashmodelFileUploadBtn.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        axisCashmodelSubmitButton.removeAttribute("disabled");
        axisCashLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    axisCashLoader.style.display = "none";
    axisCashmodelSubmitButton.removeAttribute("disabled");

    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// AXIS CASH MODEL Code ENDS

// 4. PHONEPAY cash

const PhonePayModal = document.querySelector("#PhonepayUploadModal");
const PhonePayModalSubmitButton = PhonePayModal.querySelector("#uploadBtn");
const PhonePayFileUpload = PhonePayModal.querySelector(
    "#PhonepayUploadModalFileUploadBtn"
);
const Phonepayloader = PhonePayModal.querySelector(".loader");

PhonePayModalSubmitButton.addEventListener("click", async (e) => {
    PhonePayModalSubmitButton.setAttribute("disabled", true);
    Phonepayloader.style.display = "unset";
    // upload file
    const data = await mainUpload(
        PhonePayModal.dataset.url,
        PhonePayFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        PhonePayModalSubmitButton.removeAttribute("disabled", true);
        Phonepayloader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    PhonePayModalSubmitButton.removeAttribute("disabled", true);
    Phonepayloader.style.display = "none";
    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// 4. AMEX CARD
const AmexModal = document.querySelector("#AmexUploadModal");
const AmexModalSubmitButton = AmexModal.querySelector("#uploadBtn");
const AmexModalFileUpload = AmexModal.querySelector(
    "#AmexUploadModalFileUploadBtn"
);
const Amexloader = AmexModal.querySelector(".loader");

AmexModalSubmitButton.addEventListener("click", async (e) => {
    AmexModalSubmitButton.setAttribute("disabled", true);
    Amexloader.style.display = "unset";
    // upload file
    const data = await mainUpload(
        AmexModal.dataset.url,
        AmexModalFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        AmexModalSubmitButton.removeAttribute("disabled", true);
        Amexloader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    AmexModalSubmitButton.removeAttribute("disabled", true);
    Amexloader.style.display = "none";
    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// 4. PAYTM cash
const PayTMModal = document.querySelector("#PayTMUploadModal");
const PayTMModalSubmitButton = PayTMModal.querySelector("#uploadBtn");
const PAYTMModalFileUpload = PayTMModal.querySelector(
    "#PayTMUploadModalFileUploadBtn"
);
const PayTMloader = PayTMModal.querySelector(".loader");

PayTMModalSubmitButton.addEventListener("click", async (e) => {
    PayTMModalSubmitButton.setAttribute("disabled", true);
    PayTMloader.style.display = "unset";
    // upload file
    const data = await mainUpload(
        PayTMModal.dataset.url,
        PAYTMModalFileUpload.files[0]
    );
    // if not data, dont want to contineu
    if (!data) {
        PayTMModalSubmitButton.removeAttribute("disabled", true);
        PayTMloader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    PayTMModalSubmitButton.removeAttribute("disabled", true);
    PayTMloader.style.display = "none";
    window.location.reload();
});

// hide and unhide spinners
const hideSpinners = (item) => {
    item.style.display = "none";
};

// hide and unhide spinners
const showSpinners = (item) => {
    item.style.display = "unset";
};

// others
function lastyear() {
    document.getElementById("sales").style.display = "none";
    document.getElementById("sales1").style.display = "block";
    document.getElementById("topcust").style.display = "none";
    document.getElementById("topcust1").style.display = "block";
}

function thisyear() {
    document.getElementById("sales").style.display = "block";
    document.getElementById("sales1").style.display = "none";
    document.getElementById("topcust").style.display = "block";
    document.getElementById("topcust1").style.display = "none";
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

// 1. idfc
const sbiBoxModal = document.querySelector("#sbiBoxUploadModal");
const sbiBoxModalSubmitButton = sbiBoxModal.querySelector("#uploadBtn");
const sbiBoxFileUpload = sbiBoxModal.querySelector(
    "#sbiBoxUploadModalFileUploadBtn"
);
const sbiBoxLoader = sbiBoxModal.querySelector(".loader");

/**
 * Main Submit Event
 */
sbiBoxModalSubmitButton.addEventListener("click", async (e) => {
    sbiBoxLoader.style.display = "unset";
    sbiBoxModalSubmitButton.setAttribute("disabled", true);

    // upload file
    const data = await mainUpload(
        sbiBoxModal.dataset.url,
        sbiBoxFileUpload.files[0]
    );

    // if not data, dont want to contineu
    if (!data) {
        sbiBoxModalSubmitButton.removeAttribute("disabled");
        sbiBoxLoader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbiBoxLoader.style.display = "none";
    sbiBoxModalSubmitButton.removeAttribute("disabled");

    // setTimeout(() => {
    window.location.reload();
    // }, 2000);
});

// 5. SBI Mis 2
const sbi2Modal = document.querySelector("#sbi2UploadModal");
const sbi2ModalSubmitButton = sbi2Modal.querySelector("#uploadBtn");
const sbi2FileUpload = sbi2Modal.querySelector("#sbi2UploadModalFileUploadBtn");
const SBI2loader = sbi2Modal.querySelector(".loader");

/**
 * Main Submit Event
 */
sbi2ModalSubmitButton.addEventListener("click", async (e) => {
    // upload file
    SBI2loader.style.display = "unset";
    sbi2ModalSubmitButton.setAttribute("disabled", true);

    const data = await mainUpload(
        sbi2Modal.dataset.url,
        sbi2FileUpload.files[0]
    );
    // if not data, dont want to continue
    if (!data) {
        sbi2ModalSubmitButton.removeAttribute("disabled");
        SBI2loader.style.display = "none";
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbi2ModalSubmitButton.removeAttribute("disabled");
    SBI2loader.style.display = "none";
    window.location.reload();
});




// 5. SBI Mumbai 2
const sbi2Mumbai = document.querySelector("#sbiBoxMumbaiUploadModal");
const sbi2MumbaiSubmitButton = sbi2Mumbai.querySelector("#uploadBtn");
const sbi2MumbaiFileUpload = sbi2Mumbai.querySelector("#sbiBoxMumbaiUploadModalFileUploadBtn");
const SBI2Mumbailoader = sbi2Mumbai.querySelector(".loader");

/**
 * Main Submit Event
 */
sbi2MumbaiSubmitButton.addEventListener("click", async (e) => {
    // upload file
    SBI2Mumbailoader.style.display = "unset";
    sbi2MumbaiSubmitButton.setAttribute("disabled", true);

    const data = await mainUpload(
        sbi2Mumbai.dataset.url,
        sbi2MumbaiFileUpload.files[0]
    );

    // if not data, dont want to continue
    if (!data) {
        sbi2MumbaiSubmitButton.removeAttribute("disabled");
        SBI2Mumbailoader.style.display = "none";
        return false;
    }

    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbi2MumbaiSubmitButton.removeAttribute("disabled");
    SBI2Mumbailoader.style.display = "none";
    window.location.reload();
});



// sbi hcm
const sbiHCM = document.querySelector("#sbiHCM");
const sbiHCMSubmitButton = sbiHCM.querySelector("#uploadBtn");
const sbiHCMFileUpload = sbiHCM.querySelector("#sbiHCMFileUploadBtn");
const sbiHCMloader = sbiHCM.querySelector(".loader");

/**
 * Main Submit Event
 */
sbiHCMSubmitButton.addEventListener("click", async (e) => {
    // upload file
    sbiHCMloader.style.display = "unset";
    sbiHCMSubmitButton.setAttribute("disabled", true);

    const data = await mainUpload(
        sbiHCM.dataset.url,
        sbiHCMFileUpload.files[0]
    );

    // if not data, dont want to continue
    if (!data) {
        sbiHCMSubmitButton.removeAttribute("disabled");
        sbiHCMloader.style.display = "none";
        return false;
    }

    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbiHCMSubmitButton.removeAttribute("disabled");
    sbiHCMloader.style.display = "none";
    window.location.reload();
});





// sbi hcm
const sbiHCM2 = document.querySelector("#sbiHCM2");
const sbiHCMSubmitButton2 = sbiHCM2.querySelector("#uploadBtn");
const sbiHCMFileUpload2 = sbiHCM2.querySelector("#sbiHCM2FileUploadBtn");
const sbiHCMloader2 = sbiHCM2.querySelector(".loader");

/**
 * Main Submit Event
 */
sbiHCMSubmitButton2.addEventListener("click", async (e) => {
    // upload file
    sbiHCMloader2.style.display = "unset";
    sbiHCMSubmitButton2.setAttribute("disabled", true);

    const data = await mainUpload(
        sbiHCM2.dataset.url,
        sbiHCMFileUpload2.files[0]
    );

    // if not data, dont want to continue
    if (!data) {
        sbiHCMSubmitButton2.removeAttribute("disabled");
        sbiHCMloader2.style.display = "none";
        return false;
    }

    // show success message
    succesMessageConfiguration("Successfully uploaded");
    sbiHCMSubmitButton2.removeAttribute("disabled");
    sbiHCMloader2.style.display = "none";
    window.location.reload();
});



// 
const franchiseeDebit = document.querySelector("#franchiseeUpload");
const franchiseeDebitSubmitButton = franchiseeDebit.querySelector("#uploadBtn");
const franchiseeDebitFileUpload = franchiseeDebit.querySelector("#franchiseeUploadFileUploadBtn");
const franchiseeDebitloader = franchiseeDebit.querySelector(".loader");

/**
 * Main Submit Event
 */
franchiseeDebitSubmitButton.addEventListener("click", async (e) => {
    // upload file
    franchiseeDebitloader.style.display = "unset";
    franchiseeDebitSubmitButton.setAttribute("disabled", true);

    const data = await mainUpload(
        franchiseeDebit.dataset.url,
        franchiseeDebitFileUpload.files[0]
    );

    // if not data, dont want to continue
    if (!data) {
        franchiseeDebitSubmitButton.removeAttribute("disabled");
        franchiseeDebitloader.style.display = "none";
        return false;
    }

    // show success message
    succesMessageConfiguration("Successfully uploaded");
    franchiseeDebitSubmitButton.removeAttribute("disabled");
    franchiseeDebitloader.style.display = "none";
    window.location.reload();
});



