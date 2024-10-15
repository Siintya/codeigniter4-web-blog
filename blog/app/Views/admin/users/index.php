<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-2">Users</h3>
        <h6 class="op-7 mb-2"><i class="fas fa-calendar me-1"></i> <?= date('l, d F Y, H:i'); ?></span></h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <button type="button" class="btn btn-label-primary rounded-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus"></i> Add User
        </button>
    </div>
</div>
<div class="card" id="user">
    <div class="card-body">
        <div class="table-responsive">
            <table id="usersTable" class="table table-striped table-hover nowrap display" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center text-capitalize">No.</th>
                        <th class="text-center text-capitalize">Username</th>
                        <th class="text-center text-capitalize">Status</th>
                        <th class="text-center text-capitalize">Roles</th>
                        <th class="text-center text-capitalize">Date Created</th>
                        <th class="text-center text-capitalize">Last Modified</th>
                        <th class="text-center"><i class="fas fa-cogs"></i></th>
                    </tr>
                </thead>
            </table>
        </div>   
    </div>
</div>
<?= $this->include('admin/modals/users/add') ?>
<?= $this->include('admin/modals/users/delete') ?>
<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#usersTable').DataTable({
            processing: true,
            responsive: true,
            serverSide: false, 
            ordering: true,
            order: [[0, 'asc']],
            data: <?= json_encode($users) ?>,
            columns: [
                { 
                    "data": null, 
                    "render": function (data, type, row, meta) {
                        return '<div class="text-center">' + (meta.row + 1 ) + '. </div>'; 
                    }
                },
                { "data": "username" },
                { 
                    "data": "status",
                    "render": function (data, type, row) {
                        if ( data == 'online') {
                            return '<div class="text-center"><button class="btn btn-sm rounded-pill btn-success">' + data + '</button></div>';
                        } else {
                            return '<div class="text-center"><button class="btn btn-sm rounded-pill btn-danger">' + data + '</button></div>';
                        }   
                    }
                },
                { "data": "role" },
                { 
                    "data": "created_at",
                    "render": function (data, type, row) {
                        return formatDate(data); // Memformat tanggal
                    }
                },
                { 
                    "data": "updated_at",
                    "render": function (data, type, row) {
                        if (!data) {
                            return '<div class="text-center">Blank</div>';
                        } else {
                            return '<div class="text-center">' + formatDate(data) + '</div>';
                        }
                    }
                },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        // console.log(row.id);
                        return '<div class="text-center"><a href="<?= base_url("users/update/") ?>' + row.id + '" class="text-primary"><i class="fas fa-edit"></i></a>' + '<a href="#" class="text-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="' + row.id + '"><i class="fas fa-trash-alt"></i></a></div>';
                    }
                }
            ],
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }]
        });



        function formatDate(dateString) {
            var date    = new Date(dateString);
            var month   = date.getMonth() + 1; // Bulan dimulai dari 0
            var day     = date.getDate();
            var year    = date.getFullYear();
            var hours   = date.getHours();
            var minutes = date.getMinutes();

            // Menambahkan nol di depan jika nilai kurang dari 10
            if (month < 10) {
                month = '0' + month;
            }
            if (day < 10) {
                day = '0' + day;
            }
            if (hours < 10) {
                hours = '0' + hours;
            }
            if (minutes < 10) {
                minutes = '0' + minutes;
            }

            return month + '-' + day + '-' + year + '<span class="ms-2">' + hours + ':' + minutes + '</span>';
        }


        $('#deleteUserModal').on('show.bs.modal', function (event) {
            var button      = $(event.relatedTarget);
            var id          = button.data('id');
            var modal       = $(this);
            var deleteUrl   = '<?= base_url("users/delete/") ?>' + id;
            modal.find('#deleteConfirmBtn').attr('href', deleteUrl);
        });



    });


    
</script>
<?= $this->endSection(); ?>
