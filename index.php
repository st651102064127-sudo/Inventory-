<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ระบบจัดการเครื่องมือเครื่องจักร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
    include("Navbar.php");
    ?>

    <div class="container-fluid mt-4">
        <div class="card main-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h4 class="card-title">
                        <i class="fas fa-list me-2"></i>รายการเครื่องมือเครื่องจักร
                    </h4>
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="ค้นหา...">
                        <button class="btn" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="table-responsive table-scroll">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>รหัสใหม่</th>
                                <th><i class="fas fa-barcode me-2"></i>รหัสเครื่องมือ</th>
                                <th><i class="fas fa-wrench me-2"></i>ชื่อเครื่องมือ</th>
                                <th><i class="fas fa-layer-group me-2"></i>กลุ่มเก่า</th>
                                <th><i class="fas fa-code me-2"></i>รหัสโครงการ</th>
                                <th><i class="fas fa-project-diagram me-2"></i>โครงการ</th>
                                <th><i class="fas fa-cogs me-2"></i>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody id="tools-table-body">
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="loading"></div>
                                    <p class="mt-3 text-muted">กำลังโหลดข้อมูล...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-left me-1"></i>ก่อนหน้า
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                ถัดไป<i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal แก้ไข -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-2"></i>แก้ไขข้อมูลเครื่องมือ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit_id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_new_code" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i>รหัสใหม่
                                </label>
                                <input type="text" class="form-control" id="edit_new_code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_tool_code" class="form-label">
                                    <i class="fas fa-barcode me-1"></i>รหัสเครื่องมือ
                                </label>
                                <input type="text" class="form-control" id="edit_tool_code" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_tool_name" class="form-label">
                                    <i class="fas fa-wrench me-1"></i>ชื่อเครื่องมือ
                                </label>
                                <input type="text" class="form-control" id="edit_tool_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_old_group" class="form-label">
                                    <i class="fas fa-layer-group me-1"></i>กลุ่มเก่า
                                </label>
                                <input type="text" class="form-control" id="edit_old_group" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_project_code" class="form-label">
                                    <i class="fas fa-code me-1"></i>รหัสโครงการ
                                </label>
                                <input type="text" class="form-control" id="edit_project_code" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_project_name" class="form-label">
                                    <i class="fas fa-project-diagram me-1"></i>โครงการ
                                </label>
                                <input type="text" class="form-control" id="edit_project_name" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>ยกเลิก
                    </button>
                    <button type="button" class="btn btn-primary" id="saveEdit">
                        <i class="fas fa-save me-1"></i>บันทึกการแก้ไข
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ลบ -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>ยืนยันการลบ
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id">
                    <div class="text-center py-3">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h5>คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?</h5>
                        <p class="text-muted mb-3">การดำเนินการนี้ไม่สามารถย้อนกลับได้</p>
                        <div class="alert alert-warning" role="alert">
                            <strong id="delete_tool_name"></strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>ยกเลิก
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash me-1"></i>ยืนยันการลบ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            let allData = [];
            let filteredData = [];
            let currentPage = 1;
            const itemsPerPage = 15;

            // Function to fetch data from the backend
            function fetchData() {
                $.ajax({
                    url: 'api.php?action=read',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            allData = response.data;
                            filteredData = allData;
                            currentPage = 1;
                            displayData();
                            setupPagination();
                        } else {
                            console.error("Error: " + response.message);
                            $('#tools-table-body').html(`
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-danger">
                                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                        <p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p>
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: " + xhr.responseText);
                        $('#tools-table-body').html(`
                            <tr>
                                <td colspan="7" class="text-center py-5 text-warning">
                                    <i class="fas fa-wifi fa-2x mb-3"></i>
                                    <p>ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์</p>
                                </td>
                            </tr>
                        `);
                    }
                });
            }

            // Display data for current page
            function displayData() {
                const tableBody = $('#tools-table-body');
                tableBody.empty();

                if (filteredData.length === 0) {
                    tableBody.html(`
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-search fa-2x mb-3"></i>
                                <p>ไม่พบข้อมูลที่ค้นหา</p>
                            </td>
                        </tr>
                    `);
                    return;
                }

                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, filteredData.length);
                const pageData = filteredData.slice(startIndex, endIndex);

                pageData.forEach(function (item, index) {
                    const row = `
                    <tr style="animation-delay: ${index * 0.05}s">
                        <td><span class="badge bg-primary">${item.new_code}</span></td>
                        <td><strong>${item.tool_code}</strong></td>
                        <td>${item.tool_name}</td>
                        <td><span class="badge bg-secondary">${item.old_group}</span></td>
                        <td>${item.project_code}</td>
                        <td>${item.project_name}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-edit" data-id="${item.id}">
                                    <i class="fas fa-edit me-1"></i>แก้ไข
                                </button>
                                <button type="button" class="btn btn-sm btn-delete" data-id="${item.id}">
                                    <i class="fas fa-trash me-1"></i>ลบ
                                </button>
                            </div>
                        </td>
                    </tr>
                    `;
                    tableBody.append(row);
                });
            }

            // Setup pagination
            function setupPagination() {
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                const pagination = $('.pagination');
                pagination.empty();

                // Previous button
                pagination.append(`
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">
                            <i class="fas fa-chevron-left me-1"></i>ก่อนหน้า
                        </a>
                    </li>
                `);

                // Page numbers
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, currentPage + 2);

                if (currentPage <= 3) {
                    endPage = Math.min(5, totalPages);
                }
                if (currentPage >= totalPages - 2) {
                    startPage = Math.max(1, totalPages - 4);
                }

                if (startPage > 1) {
                    pagination.append(`
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="1">1</a>
                        </li>
                    `);
                    if (startPage > 2) {
                        pagination.append(`
                            <li class="page-item disabled">
                                <a class="page-link">...</a>
                            </li>
                        `);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    pagination.append(`
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        pagination.append(`
                            <li class="page-item disabled">
                                <a class="page-link">...</a>
                            </li>
                        `);
                    }
                    pagination.append(`
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                        </li>
                    `);
                }

                // Next button
                pagination.append(`
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">
                            ถัดไป<i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </li>
                `);

                // Page click event
                $('.pagination .page-link').on('click', function (e) {
                    e.preventDefault();
                    const page = parseInt($(this).data('page'));
                    if (page && page !== currentPage && page >= 1 && page <= totalPages) {
                        currentPage = page;
                        displayData();
                        setupPagination();
                        $('html, body').animate({ scrollTop: 0 }, 300);
                    }
                });
            }

            // Search functionality
            let searchTimeout;
            function performSearch() {
                const searchTerm = $('.search-box input').val().toLowerCase().trim();

                if (searchTerm === '') {
                    filteredData = allData;
                } else {
                    filteredData = allData.filter(function (item) {
                        // ค้นหาในทุกฟิลด์ โดยแปลงเป็น string และตรวจสอบว่ามีค่าหรือไม่
                        const newCode = (item.new_code || '').toString().toLowerCase();
                        const toolCode = (item.tool_code || '').toString().toLowerCase();
                        const toolName = (item.tool_name || '').toString().toLowerCase();
                        const oldGroup = (item.old_group || '').toString().toLowerCase();
                        const projectCode = (item.project_code || '').toString().toLowerCase();
                        const projectName = (item.project_name || '').toString().toLowerCase();

                        return (
                            newCode.includes(searchTerm) ||
                            toolCode.includes(searchTerm) ||
                            toolName.includes(searchTerm) ||
                            oldGroup.includes(searchTerm) ||
                            projectCode.includes(searchTerm) ||
                            projectName.includes(searchTerm)
                        );
                    });
                }
                currentPage = 1;
                displayData();
                setupPagination();
            }

            $('.search-box input').on('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            });

            // Search button click
            $('.search-box button').on('click', function (e) {
                e.preventDefault();
                performSearch();
            });

            // Enter key for search
            $('.search-box input').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    performSearch();
                }
            });

            // Call the function on page load
            fetchData();

            // Edit button click
            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                const item = allData.find(item => item.id == id);

                if (item) {
                    $('#edit_id').val(item.id);
                    $('#edit_new_code').val(item.new_code);
                    $('#edit_tool_code').val(item.tool_code);
                    $('#edit_tool_name').val(item.tool_name);
                    $('#edit_old_group').val(item.old_group);
                    $('#edit_project_code').val(item.project_code);
                    $('#edit_project_name').val(item.project_name);

                    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                    editModal.show();
                }
            });

            // Save edit button click
            $('#saveEdit').on('click', function () {
                const id = $('#edit_id').val();
                const formData = {
                    id: id,
                    new_code: $('#edit_new_code').val(),
                    tool_code: $('#edit_tool_code').val(),
                    tool_name: $('#edit_tool_name').val(),
                    old_group: $('#edit_old_group').val(),
                    project_code: $('#edit_project_code').val(),
                    project_name: $('#edit_project_name').val()
                };

                // ตรวจสอบความถูกต้องของฟอร์มก่อนส่ง (ถ้ามี)
                if (!$('#editForm')[0].checkValidity()) {
                    $('#editForm').addClass('was-validated');
                    return;
                }

                $.ajax({
                    url: 'api.php?action=update',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                        modal.hide();

                        if (response.success) {
                            if (response.no_change) {
                                // กรณี: พบ ID แต่ข้อมูลไม่มีการเปลี่ยนแปลง
                                Swal.fire({
                                    icon: 'info',
                                    title: 'ไม่มีการเปลี่ยนแปลง',
                                    text: response.message || 'ข้อมูลเดิมกับข้อมูลที่แก้ไขเหมือนกัน',
                                    confirmButtonText: 'ตกลง'
                                });
                            } else {
                                // กรณี: แก้ไขสำเร็จ
                                Swal.fire({
                                    icon: 'success',
                                    title: 'แก้ไขสำเร็จ!',
                                    text: response.message || 'ข้อมูลถูกแก้ไขเรียบร้อยแล้ว',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                fetchData(); // โหลดข้อมูลใหม่เมื่อแก้ไขสำเร็จ
                            }
                        } else {
                            // กรณี: เกิดข้อผิดพลาด (เช่น ไม่พบ ID, ข้อมูลไม่ครบถ้วน)
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: response.message || 'ไม่สามารถแก้ไขข้อมูลได้',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                        modal.hide();

                        Swal.fire({
                            icon: 'warning',
                            title: 'การเชื่อมต่อผิดพลาด',
                            text: 'ไม่สามารถติดต่อกับเซิร์ฟเวอร์เพื่อแก้ไขข้อมูลได้',
                            confirmButtonText: 'ตกลง'
                        });
                        console.error('Error:', error);
                    }
                });
            });

            // Delete button click (โค้ดเดิม)
            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                const item = allData.find(item => item.id == id);

                if (item) {
                    $('#delete_id').val(item.id);
                    $('#delete_tool_name').text(item.tool_name || 'รายการนี้');

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                }
            });

            // Delete button click
            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                const item = allData.find(item => item.id == id);

                if (item) {
                    $('#delete_id').val(item.id);
                    $('#delete_tool_name').text(item.tool_name);

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                }
            });

            // Confirm delete button click
            // Confirm delete button click (แก้ไขใช้ SweetAlert2 และรอ Modal ปิดสนิท)
            // Confirm delete button click (แก้ไข: เพิ่มการล้าง Modal Backdrop)
            $('#confirmDelete').on('click', function () {
                const id = $('#delete_id').val();

                // 1. เก็บ instance ของ modal และปิดมันทันที
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                modal.hide();

                // 2. ใช้ Event 'hidden.bs.modal' เพื่อรอให้ Modal ปิดสนิทก่อนเรียก AJAX
                $('#deleteModal').one('hidden.bs.modal', function () {

                    // *** โค้ดส่วนที่แก้ไขเพื่อล้าง Backdrop และ Body Class ***
                    // บังคับลบ Backdrop ของ Bootstrap ออกจาก DOM
                    $('.modal-backdrop').remove();
                    // ลบคลาส 'modal-open' ออกจาก <body> เพื่อแก้ไขการเลื่อนหน้า
                    $('body').removeClass('modal-open');
                    // ตั้งค่า style overflow ให้กลับเป็นค่าปกติ
                    $('body').css('overflow', '');
                    // *** สิ้นสุดโค้ดส่วนที่แก้ไข ***

                    $.ajax({
                        url: 'api.php?action=delete',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบสำเร็จ!',
                                    text: response.message || 'ข้อมูลถูกลบเรียบร้อยแล้ว',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                fetchData();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: response.message || 'ไม่สามารถลบข้อมูลได้',
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'การเชื่อมต่อผิดพลาด',
                                text: 'ไม่สามารถติดต่อกับเซิร์ฟเวอร์เพื่อลบข้อมูลได้',
                                confirmButtonText: 'ตกลง'
                            });
                            console.error('Error:', error);
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>