
@extends('layouts.app')

@section('title', 'Api')

@section('content')
<h2>AJAX orqali foydalanuvchilar</h2>
<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel"><span class="foydalanuvchi"></span>-raqamli foydalanuvchini tahrirlash</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Yopish"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editUserId">
        <div class="mb-3">
          <label for="editFirstName" class="form-label">Ismi</label>
          <input type="text" class="form-control" id="editFirstName">
        </div>
        <div class="mb-3">
          <label for="editLastName" class="form-label">Familiyasi</label>
          <input type="text" class="form-control" id="editLastName">
        </div>
        <div class="mb-3">
          <label for="editEmail" class="form-label">Email</label>
          <input type="email" class="form-control" id="editEmail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="button" class="btn btn-primary" id="saveEditBtn">Saqlash</button>
      </div>
    </div>
  </div>
</div>


    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>first_name</th>
                <th>last_name</th>
                <th>email</th>
                <th>ip_address</th>
                <th>edit</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <nav>
        <ul class="pagination" id="pagination-links"></ul>
    </nav>
<script>
    function loadUsers(page = 1) {
        $.ajax({
            url: "{{ route('users.fetch') }}?page=" + page,
            type: "GET",
            dataType: "json",
            success: function(response) {
                let rows = '';
                $.each(response.data, function(index, user) {
                    rows += `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.first_name}</td>
                            <td>${user.last_name}</td>
                            <td>${user.email}</td>
                            <td>${user.ip_address}</td>
                            <td>
                                <button class="btn btn-sm btn-info btn-edit"
                                    data-id="${user.id}"
                                    data-first_name="${user.first_name}"
                                    data-last_name="${user.last_name}"
                                    data-email="${user.email}">
                                <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-delete" data-id="${user.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                });
                $('#users-table tbody').html(rows);

                // Paginatsiyani chiqarish
                renderPagination(response);
            }
        });
    }
    function renderPagination(data) {
        let pagination = '';
        let current = data.current_page;
        let last = data.last_page;

        // Oldingi sahifa
        if (data.prev_page_url) {
            pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${current - 1}">&laquo;</a></li>`;
        }

        let start = current - 2;
        let end = current + 2;

        if (start < 1) {
            end += 1 - start;
            start = 1;
        }

        if (end > last) {
            start -= end - last;
            end = last;
        }

        if (start > 1) {
            pagination += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (start > 2) pagination += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            pagination += `<li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
        }

        if (end < last) {
            if (end < last - 1) pagination += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${last}">${last}</a></li>`;
        }

        // Keyingi sahifa
        if (data.next_page_url) {
            pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${current + 1}">&raquo;</a></li>`;
        }

        $('#pagination-links').html(pagination);
    }


    $(document).ready(function() {
        loadUsers();

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            let page = $(this).data('page');
            loadUsers(page);
        });
    });

    // Delete
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        // if (!confirm('Rostdan ham o‘chirmoqchimisiz?')) return;

        let userId = $(this).data('id');
        let row = $(this).closest('tr');

        $.ajax({
            url: `/users/${userId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status === 'success') {
                    row.remove(); // Jadvaldan o‘chiradi
                    loadUsers(currentPage);
                    // location.reload();
                } else {
                    alert('Xatolik: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Serverda xatolik yuz berdi.');
            }
        });
    });


    $(document).on('click', '.btn-edit', function () {
        let userId = $(this).data('id');
        let firstName = $(this).data('first_name'); // ← diqqat bu yerga
        let lastName = $(this).data('last_name');   // ← va bu yerga
        let email = $(this).data('email');
        $('.foydalanuvchi').text(userId);
        $('#editUserId').val(userId);
        $('#editFirstName').val(firstName);
        $('#editLastName').val(lastName);
        $('#editEmail').val(email);

        $('#editUserModal').modal('show');
    });
    // Save
    $('#saveEditBtn').click(function () {
        let id = $('#editUserId').val();
        let firstName = $('#editFirstName').val();
        let lastName = $('#editLastName').val();
        let email = $('#editEmail').val();

        $.ajax({
            url: `/users/${id}`, // Laravel update route
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                first_name: firstName,
                last_name: lastName,
                email: email
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#editUserModal').modal('hide');
                    location.reload();
                } else {
                    alert('Xatolik: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Serverda xatolik: ' + xhr.responseText);
            }
        });
    });



</script>
@endsection
