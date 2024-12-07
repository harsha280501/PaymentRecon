const misSelectTable = document.querySelector("#misSelectTable");

const checkedValues = [...misSelectTable.querySelectorAll("input")];
const table = document.querySelector("#bankMISTable");

const select = (mainName, heading) => {
    return `
    <div class="form-group mb-1">
        <label>
            <input type="checkbox" data-name="${mainName}" checked />
            <span>${heading}</span>
        </label>
    </div>
`;
};

// get headers
const headers = [...table.querySelector(".headers").children];

headers.forEach((head) => {
    const element = document.createElement("div");
    element.innerHTML = select(head.dataset.headername, head.textContent);
    misSelectTable.appendChild(element);

    // selecting the input
    const input = element.children[0].children[0].children[0];

    // adding eventlistener to element
    input.addEventListener("change", (e) => {
        const tableRows = [
            ...table.querySelectorAll(`.${head.dataset.headername}`),
        ];

        tableRows.forEach((item) => {
            item.style.display = e.target.checked ? "table-cell" : "none";
            head.style.display = item.style.display;
        });
    });
});
