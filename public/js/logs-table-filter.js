document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const sortBy = document.getElementById("sortBy");
    const tableBody = document.querySelector("#logsTable tbody");
    const displayedCount = document.getElementById("displayedCount");
    const totalCount = document.getElementById("totalCount");

    let allRows = Array.from(document.querySelectorAll(".log-row"));
    const total = allRows.length;

    if (totalCount) {
        totalCount.textContent = total;
    }

    function filterAndSort() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();

        // Filter rows
        let visibleRows = allRows.filter((row) => {
            const rowText = row.textContent.toLowerCase();
            const rowStatus = row.getAttribute("data-status").toLowerCase();

            const matchesSearch = rowText.includes(searchTerm);
            const matchesStatus =
                statusValue === "" ||
                statusValue === "all status" ||
                rowStatus === statusValue;

            return matchesSearch && matchesStatus;
        });

        // Sort rows
        const sortValue = sortBy.value;
        visibleRows.sort((a, b) => {
            const dateA = new Date(a.getAttribute("data-date"));
            const dateB = new Date(b.getAttribute("data-date"));
            const hoursA = parseFloat(a.getAttribute("data-hours"));
            const hoursB = parseFloat(a.getAttribute("data-hours"));

            switch (sortValue) {
                case "date-desc":
                case "latest first":
                    return dateB - dateA;
                case "date-asc":
                case "oldest first":
                    return dateA - dateB;
                case "hours-desc":
                    return hoursB - hoursA;
                case "hours-asc":
                    return hoursA - hoursB;
                default:
                    return dateB - dateA;
            }
        });

        // Hide all rows first
        allRows.forEach((row) => {
            row.style.display = "none";
        });

        // Show and reorder visible rows
        visibleRows.forEach((row) => {
            row.style.display = "";
            tableBody.appendChild(row);
        });

        // Update count
        if (displayedCount) {
            displayedCount.textContent = visibleRows.length;
        }

        // Show "no results" message if needed
        showNoResultsMessage(visibleRows.length);
    }

    function showNoResultsMessage(count) {
        let noResultsRow = document.getElementById("noResultsRow");

        if (count === 0) {
            if (!noResultsRow) {
                noResultsRow = document.createElement("tr");
                noResultsRow.id = "noResultsRow";
                noResultsRow.className = "border-0";
                // Using Tailwind classes for consistent height
                noResultsRow.innerHTML = `
                     <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                         <div class="font-medium">No entries found</div>
                        <div class="text-sm mt-1">Try adjusting your filters</div>
                     </td>
                `;
                tableBody.appendChild(noResultsRow);
            }
            // Ensure the row is visible
            noResultsRow.style.display = "";
        } else {
            if (noResultsRow) {
                noResultsRow.style.display = "none";
            }
        }
    }

    // Event listeners
    if (searchInput) {
        searchInput.addEventListener("input", filterAndSort);
    }

    if (statusFilter) {
        statusFilter.addEventListener("change", filterAndSort);
    }

    if (sortBy) {
        sortBy.addEventListener("change", filterAndSort);
    }

    // Initial sort
    filterAndSort();
});
