var $j = jQuery.noConflict();

/**
 * Check for proper file extension
 * @param {*} fileName
 * @returns
 */
const fileExtension = (fileName) => {
    const allowedExtensions = ["pdf", "jpg", "png", "xlsx", "csv"];
    const ext = fileName.name.split(".")[1];

    if (!ext) {
        return false;
    }

    if (!allowedExtensions.includes(ext)) {
        return false;
    }
    return true;
};
/**
 * Main Validation
 * @param {*} id
 * @returns
 */
function MainFormvalidate(id) {
    // removing all the form errors
    document
        .querySelectorAll(".form-error")
        .forEach((item) => item.classList.remove("form-error"));

    var error = false;
    // checking for error
    const modal = document.querySelector(`#${id}`);
    const inputs = modal.querySelectorAll(".mainFormValidaitionInputs");

    // dont need validation array
    const dontValidateArray = [""];

    inputs.forEach((item) => {
        mainInputs = item.querySelectorAll("input");
        files = item.querySelectorAll('input[type="file"]');
        selects = item.querySelectorAll("select");

        mainInputs.forEach((inp) => {
            // if (!dontValidateArray.includes(inp.id)) {
            if (inp.value == "") {
                error = true;
                inp.classList.add("form-error");
            }
            // }
        });

        console.log(files);

        files.forEach((inp) => {
            if (inp.files[0] && !fileExtension(inp.files[0])) {
                error = true;
                inp.classList.add("form-error");
            }

            if (!inp.files[0] || inp.files[0] == null) {
                error = true;
                inp.classList.add("form-error");
            }
        });

        selects.forEach((inp) => {
            if (!inp.value) {
                error = true;
                inp.classList.add("form-error");
            }
        });
    });

    if (error == true) {
        return false;
    }

    return true;
}

/**
 * Card Recon submit
 * @param {*} dataset
 * @param {*} id
 * @param {*} total
 * @param {*} tenderAdj
 * @param {*} bankAdj
 * @returns
 */
const cardApproval = async (dataset, id, total, tenderAdj, bankAdj) => {
    const _resArray = dataset.map(async (item) => {
        const formData = new FormData();

        console.log(item);
        formData.append("item", item.item == "Other" ? item.name : item.item);
        formData.append("cardSalesRecoUID", id);
        formData.append("bankName", item.bankName);
        formData.append("saleAmount", item.amount);
        formData.append("creditDate", item.creditDate);
        formData.append("remarks", item.remarks);
        formData.append(
            "supportDocupload",
            item.supportDocupload ? item.supportDocupload[0] : ""
        );

        formData.append("adjAmount", total);

        // creatign a new record
        const data = await request.http({
            url: "/cuser/process/card-recon/update/" + id,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
        });

        const status = data.isSuccess;
        return Promise.resolve(status);
    });

    /**
     * Getting the results of all the objects
     */
    Promise.all(_resArray)
        .then((results) => {
            const hasFalse = results.some((result) => result === false);

            hasFalse == false
                ? succesMessageConfiguration("Success")
                : errorMessageConfiguration("Something went wrong");
            hasFalse == false ? window.location.reload(true) : null;
        })
        .catch(() => {
            errorMessageConfiguration("Something went wrong");
            return false;
        });

    return true;
};

/**
 * Wallet recon submit
 * @param {*} dataset
 * @param {*} id
 * @param {*} total
 * @param {*} tenderAdj
 * @param {*} bankAdj
 * @returns
 */
const walletApproval = async (dataset, id, total, tenderAdj, bankAdj) => {
    const _resArray = dataset.map(async (item) => {
        const formData = new FormData();
        formData.append("item", item.item == "Other" ? item.name : item.item);
        formData.append("bankName", item.bankName);
        formData.append("creditDate", item.creditDate);
        formData.append("referenceNo", item.referenceNo);
        formData.append("saleAmount", item.saleAmount || 0);
        formData.append("depositAmount", item.amount || 0);
        formData.append("remarks", item.remarks);
        formData.append(
            "supportDocupload",
            item.supportDocupload ? item.supportDocupload[0] : ""
        );

        formData.append("walletSalesRecoUID", id);
        formData.append("adjAmount", total);

        // creating a new record
        const data = await request.http({
            url: "/cuser/process/wallet-recon/update/" + id,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
        });

        const status = data.isSuccess;
        return Promise.resolve(status);
    });

    /**
     * Getting the results of all the objects
     */
    Promise.all(_resArray)
        .then((results) => {
            const hasFalse = results.some((result) => result === false);

            hasFalse == false
                ? succesMessageConfiguration("Success")
                : errorMessageConfiguration("Something went wrong");
            hasFalse == false ? window.location.reload(true) : null;
        })
        .catch(() => {
            errorMessageConfiguration("Something went wrong");
            return false;
        });

    return true;
};

/**
 * Card Recon submit
 * @param {*} dataset
 * @param {*} id
 * @param {*} total
 * @param {*} tenderAdj
 * @param {*} bankAdj
 * @returns
 */
const upiApproval = async (dataset, id, total, tenderAdj, bankAdj) => {
    const _resArray = dataset.map(async (item) => {
        const formData = new FormData();

        formData.append("item", item.item == "Other" ? item.name : item.item);
        formData.append("cardSalesRecoUID", id);
        formData.append("bankName", item.bankName);
        formData.append("saleAmount", item.amount);
        formData.append("creditDate", item.creditDate);
        formData.append("remarks", item.remarks);
        formData.append(
            "supportDocupload",
            item.supportDocupload ? item.supportDocupload[0] : ""
        );

        formData.append("adjAmount", total);

        // creatign a new record
        const data = await request.http({
            url: "/cuser/process/upi-recon/update/" + id,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
        });

        const status = data.isSuccess;
        return Promise.resolve(status);
    });

    /**
     * Getting the results of all the objects
     */
    Promise.all(_resArray)
        .then((results) => {
            const hasFalse = results.some((result) => result === false);

            hasFalse == false
                ? succesMessageConfiguration("Success")
                : errorMessageConfiguration("Something went wrong");
            hasFalse == false ? window.location.reload(true) : null;
        })
        .catch(() => {
            errorMessageConfiguration("Something went wrong");
            return false;
        });

    return true;
};

document.addEventListener("livewire:load", (event) => {
    // listen for reset event
    Livewire.on("resetAll", (e) => {
        // clear items
        const resetItems = [
            "#card-stores",
            "#wallet-stores",

            "#card-codes",
            "#wallet-codes",
        ];

        resetItems.forEach((item) => {
            $j(item).select2("destroy");
            $j(item).val("");
            $j(item).select2();
        });
    });
});
