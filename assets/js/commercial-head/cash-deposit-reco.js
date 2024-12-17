document.addEventListener("alpine:init", () => {
    Alpine.data("_select", () => ({
        start: null,
        end: null,
        selection: [],
        checkedAll: false,
    }))
});
