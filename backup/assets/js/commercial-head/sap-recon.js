document.addEventListener("livewire:load", (event) => {
    const form = document.querySelector("#cash-process-search-form");

    const start = form.querySelector("#startDate");
    const end = form.querySelector("#endDate");

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const dates = {
            start: start.value,
            end: end.value,
        };

        if (dates.start == "" && dates.end == "") {
            start.style.border = "1px solid lightcoral";
            end.style.border = "1px solid lightcoral";
            start.style.color = "lightcoral";
            end.style.color = "lightcoral";
            return false;
        } else {
            start.style.border = "1px solid #000";
            end.style.border = "1px solid #000";
            start.style.color = "#000";
            end.style.color = "#000";
        }

        livewire.components
            .getComponentsByName("commercial-head.process.sap-process")[0]
            .call("dateFilter", dates);
    });

    const form1 = document.querySelector("#cash-process-search-form1");

    const start1 = form1.querySelector("#startDate");
    const end1 = form1.querySelector("#endDate");

    form1.addEventListener("submit", (e) => {
        e.preventDefault();

        const dates = {
            start: start1.value,
            end: end1.value,
        };

        if (dates.start == "" && dates.end == "") {
            start1.style.border = "1px solid lightcoral";
            end1.style.border = "1px solid lightcoral";
            start1.style.color = "lightcoral";
            end1.style.color = "lightcoral";
            return false;
        } else {
            start1.style.border = "1px solid #000";
            end1.style.border = "1px solid #000";
            start1.style.color = "#000";
            end1.style.color = "#000";
        }

        livewire.components
            .getComponentsByName("commercial-head.process.sap-process")[0]
            .call("dateFilter", dates);
    });
});

// Livewire started
document.addEventListener("livewire:load", () => {
    // listen for reset event
    Livewire.on("resetAll", () => {
        const resetItems = [
            "#select1-dropdown",
            "#select2-dropdown",
            "#select3-dropdown",
            "#select4-dropdown",
            "#select5-dropdown",
            "#select6-dropdown",
        ];

        resetItems.forEach((item) => {
            $j(item).select2("destroy");
            $j(item).val("");
            $j(item).select2();
        });

        $(".date-filter").val("");

        const dateform = document.querySelector("#cash-process-search-form");
        const start = dateform.querySelector("#startDate");
        const end = dateform.querySelector("#endDate");

        start.value = "";
        end.value = "";
    });
});

/**
 * Card Upload
 * @param {*} e
 * @param {*} id
 * @returns
 */
const handleFormData = async (e, id) => {
    const processPage = document.querySelector(".process-page");
    const modal = processPage.querySelector(`#${id}`);

    // get modal body
    const modalBody = modal.querySelector(".modal-body");

    const spinner = modal.querySelector(".footer-loading-btn");
    spinner.style.display = "block";
    const approvalStatus = modal.querySelector("#approvalStatus");

    if (approvalStatus.value == "") {
        spinner.style.display = "none";
        errorMessageConfiguration("Please select a valid approval status");
        return false;
    }

    // remarks
    const remarks = modal.querySelector("#remarks");
    const amount = modal.querySelector("#recon-amount");
    const depAmount = modal.querySelector("#recon-deposit-amount");

    const data = await request.http({
        url:
            "/chead/process/card-recon/update-card-approval-status/" +
            e.target.dataset.id,
        method: "POST",
        data: {
            approvalStatus: approvalStatus.value,
            saleReconDifferenceAmount: amount.value,
            depositAmount: depAmount.value,
            remarks: remarks.value,
        },
    });

    if (data.isError) {
        errorMessageConfiguration(data.error);
        spinner.style.display = "none";
        return false;
    }

    spinner.style.display = "none";
    succesMessageConfiguration("Success");
    window.location.reload();

    return true;
};

/**
 * Card Upload
 * @param {*} e
 * @param {*} id
 * @returns
 */
const UPISubmit = async (e, id) => {
    const processPage = document.querySelector(".process-page");
    const modal = processPage.querySelector(`#${id}`);

    // get modal body
    const modalBody = modal.querySelector(".modal-body");

    const spinner = modal.querySelector(".footer-loading-btn");
    spinner.style.display = "block";
    const approvalStatus = modal.querySelector("#approvalStatus");

    if (approvalStatus.value == "") {
        spinner.style.display = "none";
        errorMessageConfiguration("Please select a valid approval status");
        return false;
    }

    // remarks
    const remarks = modal.querySelector("#remarks");
    const amount = modal.querySelector("#recon-amount");
    const depAmount = modal.querySelector("#recon-deposit-amount");

    const data = await request.http({
        url:
            "/chead/process/upi-recon/update-upi-approval-status/" +
            e.target.dataset.id,
        method: "POST",
        data: {
            approvalStatus: approvalStatus.value,
            saleReconDifferenceAmount: amount.value,
            depositAmount: depAmount.value,
            remarks: remarks.value,
        },
    });

    if (data.isError) {
        errorMessageConfiguration(data.error);
        spinner.style.display = "none";
        return false;
    }

    spinner.style.display = "none";
    succesMessageConfiguration("Success");
    window.location.reload();

    return true;
};

/**
 * Wallet Upload
 * @param {*} e
 * @param {*} id
 * @returns
 */
const handleSubFormData = async (e, id) => {
    const processPage = document.querySelector(".process-page");
    const modal = processPage.querySelector(`#${id}`);

    // get modal body
    const modalBody = modal.querySelector(".modal-body");

    const spinner = modal.querySelector(".footer-loading-btn");
    spinner.style.display = "block";
    const approvalStatus = modal.querySelector("#approvalStatus");

    if (approvalStatus.value == "") {
        spinner.style.display = "none";
        errorMessageConfiguration("Please select a valid approval status");
        return false;
    }

    // remarks
    const remarks = modal.querySelector("#remarks");
    const amount = modal.querySelector("#recon-amount");
    const depAmount = modal.querySelector("#recon-deposit-amount");

    const data = await request.http({
        url:
            "/chead/process/wallet-recon/update-wallet-approval-status/" +
            e.target.dataset.id,
        method: "POST",
        data: {
            approvalStatus: approvalStatus.value,
            saleReconDifferenceAmount: amount.value,
            depositAmount: depAmount.value,
            remarks: remarks.value,
        },
    });

    if (data.isError) {
        errorMessageConfiguration(data.error);
        spinner.style.display = "none";
        return false;
    }

    spinner.style.display = "none";
    succesMessageConfiguration("Success");
    window.location.reload();

    return true;
};
