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
    const selects = modal.querySelectorAll("select");

    // dont need validation array
    const dontValidateArray = ["supportDocupload"];

    inputs.forEach((item) => {
        mainInputs = item.querySelectorAll("input");
        files = item.querySelectorAll('input[type="file"]');

        files.forEach((inp) => {
            if (inp.files[0] && !fileExtension(inp.files[0])) {
                error = true;
                inp.classList.add("form-error");
            }
        });

        mainInputs.forEach((inp) => {
            if (!dontValidateArray.includes(inp.id)) {
                if (inp.value == "") {
                    error = true;
                    inp.classList.add("form-error");
                }
            }
        });

        selects.forEach((inp) => {
            // if (!dontValidateArray.includes(inp.id)) {
            if (inp.value == "") {
                error = true;
                inp.classList.add("form-error");
            }
            // }
        });
    });

    if (error == true) {
        return false;
    }

    return true;
}

const mainSubmit = async (dataset, id, total, tenderAdj, bankAdj) => {
    const _resArray = dataset.map(async (item) => {
        const formData = new FormData();
        formData.append("item", item.item == "Other" ? item.name : item.item);
        formData.append("CashTenderBkDrpUID", id);
        formData.append("amount", item.amount);
        formData.append("bankName", item.bankName);
        formData.append("creditDate", item.creditDate);
        formData.append("slipnoORReferenceNo", item.slipnoORReferenceNo);
        formData.append("remarks", item.remarks);
        formData.append(
            "supportDocupload",
            item.supportDocupload ? item.supportDocupload[0] : ""
        );
        formData.append("tenderAdj", tenderAdj);
        formData.append("bankAdj", bankAdj);
        formData.append("adjAmount", total);

        // creating a new record
        const data = await request.http({
            url: "/cuser/process/cash-recon/create-main-mis/" + id,
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
