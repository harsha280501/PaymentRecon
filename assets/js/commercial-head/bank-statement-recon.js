/**
 * Submit cash recon approval process
 * @param {*} e
 * @param {*} id
 * @returns
 */
const cashApproval = async (e, id) => {
    const processPage = document.querySelector(".process-page");
    const modal = processPage.querySelector(`#${id}`);

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
            "/chead/process/bank-statement-recon/cash/update-bank-approval-status/" +
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
        return false;
    }

    spinner.style.display = "none";
    succesMessageConfiguration("Success");
    window.location.reload();

    return true;
};

/**
 * Card recon approval process
 * @param {*} e
 * @param {*} id
 * @returns
 */
const cardApproval = async (e, id) => {
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
            "/chead/process/bank-statement-recon/card/update-bank-approval-status/" +
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
        return false;
    }

    spinner.style.display = "none";
    succesMessageConfiguration("Success");
    window.location.reload();

    return true;
};

/**
 * Handle wallet recon approval
 * @param {*} e
 * @param {*} id
 * @returns
 */
const walletApproval = async (e, id) => {
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
            "/chead/process/bank-statement-recon/wallet/update-bank-approval-status/" +
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
        return false;
    }

    spinner.style.display = "none";
    succesMessageConfiguration("Success");
    window.location.reload();

    return true;
};

/**
 * Handle wallet recon approval process
 * @param {*} e
 * @param {*} id
 * @returns
 */
const upiApproval = async (e, id) => {
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
            "/chead/process/bank-statement-recon/upi/update-bank-approval-status/" +
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
        return false;
    }

    spinner.style.display = "none";
    succesMessageConfiguration("Success");
    window.location.reload();

    return true;
};

// Livewire started
document.addEventListener("livewire:load", (event) => {
    // listen for reset event
    Livewire.on("resetAll", (e) => {
        const resetItems = [
            "#select01-dropdown",
            "#select02-dropdown",
            "#select03-dropdown",
            "#select04-dropdown",
            "#select11-dropdown",
            "#select12-dropdown",
            "#select13-dropdown",
            "#select14-dropdown",
        ];

        resetItems.forEach((item) => {
            $j(item).select2("destroy");
            $j(item).val("");
            $j(item).select2();
        });
    });
});
