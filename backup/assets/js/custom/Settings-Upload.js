const mainsettingsUpload = async (url, data) => {
    if (!data) {
        errorMessageConfiguration("Please import a file");
        return false;
    }

    const formData = new FormData();
    formData.append("file", data);

    try {
        const response = await request.http({
            url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
        });

        const { data: main, isError, error } = await response;

        if (isError) {
            errorMessageConfiguration(error?.message);
            return false;
        }

        return main;
    } catch (error) {
        errorMessageConfiguration("An error occurred during the upload");
        return false;
    }
};

const mainUploadFunc = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/amex/upload", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};

const amexSaveImport = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/amex/save", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};

const iciciSaveImport = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/icici/save", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};

const sbiSaveImport = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/sbi/save", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};

const hdfcSaveImport = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/hdfc/save", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};

const mainUploadsbiFunc = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/sbi/upload", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};

const mainUploadiciciFunc = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/icici/upload", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};

const mainUploadhdfcFunc = async (file, loader) => {
    // loader
    loader.style.display = "unset";

    const data = await mainsettingsUpload("/chead/hdfc/upload", file);

    // error
    if (!data) {
        loader.style.display = "none";
        return false;
    }

    // success
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = "none";
    window.location.reload();
};
