@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Quản Lý Loại Sản Phẩm</h3>
            <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addModal">
                <i class="fas fa-plus me-2"></i>Thêm Loại Sản Phẩm
            </button>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>  
                            <th>Tên Loại</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->categories_id }}</td>
                            <td>{{ $category->categories_name }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-mdb-toggle="modal" 
                                    data-mdb-target="#editModal{{ $category->categories_id }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->categories_id) }}" 
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Bạn có chắc muốn xóa?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Loại Sản Phẩm Mới</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <input type="text" id="categories_name" name="categories_name" class="form-control" required />
                        <label class="form-label" for="categories_name">Tên Loại</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa -->
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->categories_id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categories.update', $category->categories_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Sửa Loại Sản Phẩm</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <input type="text" id="categories_name{{ $category->categories_id }}" 
                            name="categories_name" class="form-control" 
                            value="{{ $category->categories_name }}" required />
                        <label class="form-label" for="categories_name{{ $category->categories_id }}">Tên Loại</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection