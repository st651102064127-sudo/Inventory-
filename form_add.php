<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มข้อมูลเครื่องมือเครื่องจักร</title>
     <link rel="icon" href="Image/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="style/index.css"> </head>

<body>

<?php 

    include("Navbar.php"); 
?>

    <div class="container-fluid mt-4">
        <div class="card main-card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="fas fa-plus-circle me-2"></i>เพิ่มข้อมูลเครื่องมือ/เครื่องจักรใหม่
                </h4>

                <form id="createForm" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="new_code" class="form-label">
                                <i class="fas fa-hashtag me-1 text-primary"></i>รหัสใหม่ (New Code)
                            </label>
                            <input type="text" class="form-control" id="new_code" name="new_code" placeholder="เช่น 430168SVDE001" required>
                        </div>

                        <div class="col-md-6">
                            <label for="tool_code" class="form-label">
                                <i class="fas fa-barcode me-1 text-info"></i>รหัสเครื่องมือ (Tool Code)
                            </label>
                            <input type="text" class="form-control" id="tool_code" name="tool_code" placeholder="เช่น SV-001" required>
                        </div>

                        <div class="col-12">
                            <label for="tool_name" class="form-label">
                                <i class="fas fa-wrench me-1 text-success"></i>ชื่อเครื่องมือ (Tool Name)
                            </label>
                            <input type="text" class="form-control" id="tool_name" name="tool_name" placeholder="เช่น DELL EMC PowerEdge R450" required>
                        </div>

                        <div class="col-md-6">
                            <label for="old_group" class="form-label">
                                <i class="fas fa-layer-group me-1 text-secondary"></i>กลุ่มเก่า (Old Group)
                            </label>
                            <input type="text" class="form-control" id="old_group" name="old_group" placeholder="เช่น คอมพิวเตอร์ (CASE)">
                        </div>

                        <div class="col-md-6">
                            <label for="project_code" class="form-label">
                                <i class="fas fa-code me-1 text-warning"></i>รหัสโครงการ (Project Code)
                            </label>
                            <input type="text" class="form-control" id="project_code" name="project_code" placeholder="เช่น HO-1">
                        </div>

                        <div class="col-12">
                            <label for="project_name" class="form-label">
                                <i class="fas fa-project-diagram me-1 text-danger"></i>โครงการ (Project Name)
                            </label>
                            <input type="text" class="form-control" id="project_name" name="project_name" placeholder="เช่น สำนักงานใหญ่">
                        </div>

                        <div class="col-12 mt-5 text-end">
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="fas fa-redo me-1"></i>ล้างข้อมูล
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#createForm').on('submit', function (e) {
                e.preventDefault(); // ป้องกันการ Submit แบบปกติ

                const formData = {
                    new_code: $('#new_code').val(),
                    tool_code: $('#tool_code').val(),
                    tool_name: $('#tool_name').val(),
                    old_group: $('#old_group').val(),
                    project_code: $('#project_code').val(),
                    project_name: $('#project_name').val()
                };

                $.ajax({
                    url: 'api.php?action=create',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'บันทึกสำเร็จ!',
                                text: 'ข้อมูลเครื่องมือถูกบันทึกเรียบร้อยแล้ว',
                                confirmButtonText: 'ตกลง',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(() => {
                                // ล้างฟอร์มหลังจากบันทึกสำเร็จ
                                $('#createForm')[0].reset();
                                $('#new_code').focus();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: response.message || 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
                                confirmButtonText: 'ตกลง',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'warning',
                            title: 'การเชื่อมต่อผิดพลาด',
                            text: 'ไม่สามารถติดต่อกับเซิร์ฟเวอร์ได้: ' + error,
                            confirmButtonText: 'ตกลง',
                            customClass: {
                                confirmButton: 'btn btn-secondary'
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>