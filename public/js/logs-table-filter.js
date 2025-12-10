// public/js/logs-table-filter.js

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const sortBy = document.getElementById("sortBy");
    const tbody = document.querySelector("#logsTable tbody");
    const displayedCount = document.getElementById("displayedCount");
    const totalCount = document.getElementById("totalCount");

    // Safety check — if we're not on the logs page, do nothing
    if (!tbody || !searchInput || !statusFilter || !sortBy || !displayedCount) {
        return;
    }

    if (totalCount) {
        totalCount.textContent = rows.length;
    }

    const rows = Array.from(tbody.querySelectorAll(".log-row"));

    function filterAndSort() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedStatus = statusFilter.value; // '' means "all"

        let visibleRows = rows.filter((row) => {
            const rowText = row.textContent.toLowerCase();
            const rowStatus = row.dataset.status;

            const matchesSearch = rowText.includes(searchTerm);
            const matchesStatus =
                !selectedStatus || rowStatus === selectedStatus;

            return matchesSearch && matchesStatus;
        });

        // Sorting
        const sortValue = sortBy.value;
        visibleRows.sort((a, b) => {
            switch (sortValue) {
                case "date-desc":
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case "date-asc":
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case "hours-desc":
                    return (
                        parseFloat(b.dataset.hours) -
                        parseFloat(a.dataset.hours)
                    );
                case "hours-asc":
                    return (
                        parseFloat(a.dataset.hours) -
                        parseFloat(b.dataset.hours)
                    );
                default:
                    return 0;
            }
        });

        // Hide all rows first
        rows.forEach((row) => (row.style.display = "none"));

        // Show and re-append in correct order
        visibleRows.forEach((row) => {
            row.style.display = "";
            tbody.appendChild(row);
        });

        // Update counter
        displayedCount.textContent = visibleRows.length;
    }

    // Event listeners
    searchInput.addEventListener("input", filterAndSort);
    statusFilter.addEventListener("change", filterAndSort);
    sortBy.addEventListener("change", filterAndSort);

    // Run once on load
    filterAndSort();
});
