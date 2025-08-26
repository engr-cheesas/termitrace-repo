<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History UI</title>
    <link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="history.css">
    <style>
        body {
            font-size: 14px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .header {
            font-weight: bold;
            text-align: center;
            padding: 10px;
        }
        .history-list {
            height: 250px; /* Adjusted for 800x400 screens */
            overflow-y: auto;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
        }
        .pagination {
            justify-content: center;
        }
        .view-btn {
            font-size: 12px;
            padding: 5px;
        }
        img {
            max-width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header row text-center py-2">
            <div class="col">Date</div>
            <div class="col">Detection Type</div>
            <div class="col">Findings</div>
            <div class="col">Image</div>
            
        </div>

        <!-- History List Table -->
        <div class="history-list">
            <table class="table table-bordered table-sm">
                <tbody id="historyTable">
                    <!-- Data will be inserted dynamically here -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <li class="page-item disabled" id="prevPage"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#" id="pageNumber">1</a></li>
                <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>

        <!-- Footer -->
        <div class="footer" style="text-align:center">
            <button class="btn btn-secondary" onclick="goPrevious()">BACK</button>
        </div>
    </div>

    <!-- Bootstrap Modal for Image Viewing -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="History Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & JS Scripts -->
    <script src="bootstrap.bundle.min.js"></script>
    <script>
        let historyData = [];
        let currentPage = 1;
        const itemsPerPage = 5;

        document.addEventListener("DOMContentLoaded", function () {
            loadHistory();
        });

         function loadHistory() {
            fetch("fetch_history.php")
                .then(response => response.json())
                .then(data => {
                    console.log("Raw response:", data);
                    historyData = data;
                    displayPage(currentPage);
                })
                .catch(error => console.error("Error loading history:", error));
        }

        function displayPage(page) {
            const table = document.getElementById("historyTable");
            table.innerHTML = "";

            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = historyData.slice(startIndex, endIndex);

            pageData.forEach(entry => {
                let imageButton = "";
                if (entry.image && entry.image.toLowerCase() !== "none") {
                    imageButton = `<button class="btn btn-primary btn-sm view-btn" onclick="viewImage('${entry.image}')">🔍 View</button>`;
                }

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${entry.date}</td>
                    <td>${entry.detection}</td>
                    <td>${entry.findings}</td>
                    <td>${imageButton}</td>
                         `;
                table.appendChild(row);
            });

            updatePagination();
        }

        function updatePagination() {
            document.getElementById("pageNumber").textContent = currentPage;

            document.getElementById("prevPage").classList.toggle("disabled", currentPage === 1);
            document.getElementById("nextPage").classList.toggle("disabled", currentPage * itemsPerPage >= historyData.length);
        }

        document.getElementById("prevPage").addEventListener("click", function () {
            if (currentPage > 1) {
                currentPage--;
                displayPage(currentPage);
            }
        });

        document.getElementById("nextPage").addEventListener("click", function () {
            if (currentPage * itemsPerPage < historyData.length) {
                currentPage++;
                displayPage(currentPage);
            }
        });

        function viewImage(imagePath) {
            if (imagePath) {
                document.getElementById("modalImage").src = imagePath;
                var imageModal = new bootstrap.Modal(document.getElementById("imageModal"));
                imageModal.show();
            }
        }

        function goPrevious() {
            window.location.href = "dashboard.html";
        }
    </script>
</body>
</html>
