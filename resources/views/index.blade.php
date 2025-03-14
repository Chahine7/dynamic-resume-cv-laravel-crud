{{ view('layouts.header') }}

<div class="content-wrapper mt-4">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">
                        @if($is_admin)
                            Manage All Resumes
                        @else
                            My Profile
                        @endif
                    </h1>
                </div>
                <div class="col-4 text-right">
                    @if (!$is_admin && !$has_resume)
                        <a href="{{ route('user.profile.create') }}" class="add-btn">
                            <i class="fa fa-user-plus"></i>
                            <br> Add New
                        </a>
                    @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item">Home</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if($is_admin)
            <!-- Admin View -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Resumes</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($resumes as $resume)
                                    <tr>
                                        <td>{{ $resume->first_name }} {{ $resume->last_name }}</td>
                                        <td>{{ $resume->user->email }}</td>
                                    
                                        <td>{{ $resume->profile_title }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('user.profile.view', $resume->user_id) }}" 
                                                   class="text-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('edit', $resume->user_id) }}" 
                                                   class="text-success" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('destroy', $resume->user_id) }}" method="POST">
                                                    @csrf
                                                    <a href="javascript:void(0)" 
                                                       onclick="confirm_form_delete(this)" 
                                                       class="text-danger" title="Delete">
                                                        <i class="fas fa-user-minus"></i>
                                                    </a>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $resumes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    @if($has_resume)
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Profile Photo</th>
                                            <th>Title</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users_data as $user)
                                        <tr>
                                            <td>
                                                <img class="profile img-fluid img-circle elevation-2" 
                                                     src="{{ asset('assets/images/'. ($user['personal_info']['image_path'] ?? 'user-thumb.jpg')) }}"
                                                     style="height:40px; width:40px;" alt="Profile">
                                            </td>
                                            <td>{{ $user['personal_info']['profile_title'] ?? '' }}</td>
                                            <td>{{ $user['personal_info']['first_name'] ?? '' }}</td>
                                            <td>{{ $user['personal_info']['last_name'] ?? '' }}</td>
                                            <td>{{ $user['contact_info']['email'] ?? '' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-around">
                                                    <a href="{{ route('user.profile.view', $user['personal_info']['user_id']) }}" 
                                                       class="text-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('edit', $user['personal_info']['user_id']) }}" 
                                                       class="text-success" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('destroy', $user['personal_info']['user_id']) }}" 
                                                          method="POST">
                                                        @csrf
                                                        <a href="javascript:void(0)" 
                                                           onclick="confirm_form_delete(this)" 
                                                           class="text-danger" title="Delete">
                                                            <i class="fas fa-user-minus"></i>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> No Resume Found!</h5>
                            <p>Click the "Add New" button to create your resume.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

{{ view('layouts.footer') }}