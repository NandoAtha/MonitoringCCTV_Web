@extends('layouts.admin')

@section('title', 'User Management')

@section('content')

<div class="bg-dark vh-100 d-flex flex-column">



<div class="container-fluid flex-grow-1 mt-4">
    <div class="row h-100">
        <div class="col-lg-3 col-md-4">
            <div class="card bg-dark-subtle h-100 border-secondary">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-users-cog me-2"></i>User and Role</h6>
                </div>
                <div class="card-body text-white d-flex flex-column p-3">
                    <div class="btn-toolbar mb-3">
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-primary" title="New User"><i class="fas fa-plus me-1"></i> New</button>
                            <button class="btn btn-outline-light" title="Edit User"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-outline-danger" title="Delete User"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text bg-dark text-white border-secondary"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control bg-dark text-white border-secondary" placeholder="Search user...">
                    </div>
                    <ul class="list-group" style="overflow-y: auto;">
                        <a href="#" class="list-group-item list-group-item-action active bg-primary border-primary d-flex align-items-center">
                            <i class="fas fa-user-shield me-2"></i> admin
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-secondary d-flex align-items-center">
                            <i class="fas fa-user-cog me-2"></i> operator
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-secondary d-flex align-items-center">
                            <i class="fas fa-user me-2"></i> guest
                        </a>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-8">
             <div class="card bg-dark-subtle h-100 border-secondary text-white">
                <div class="card-header bg-secondary">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-user-edit me-2"></i>User Info: admin</h6>
                </div>
                 <div class="card-body">
                     <dl class="row">
                         <dt class="col-sm-3">User Name:</dt>
                         <dd class="col-sm-9">admin</dd>
                         <dt class="col-sm-3">Role:</dt>
                         <dd class="col-sm-9">admin</dd>
                         <dt class="col-sm-3">Remark:</dt>
                         <dd class="col-sm-9">Default administrator user</dd>
                     </dl>

                     <hr class="border-secondary">

                     <ul class="nav nav-tabs nav-tabs-dark" id="permissionTabs" role="tablist">
                         <li class="nav-item" role="presentation">
                             <button class="nav-link active" id="menu-rights-tab" data-bs-toggle="tab" data-bs-target="#menu-rights" type="button" role="tab">Menu Rights</button>
                         </li>
                         <li class="nav-item" role="presentation">
                             <button class="nav-link" id="channel-rights-tab" data-bs-toggle="tab" data-bs-target="#channel-rights" type="button" role="tab">Channel Rights</button>
                         </li>
                     </ul>

                     <div class="tab-content pt-3" id="permissionTabsContent">
                         <div class="tab-pane fade show active" id="menu-rights" role="tabpanel">
                             <h6 class="mb-3 fw-semibold">Assign Menu Permissions</h6>
                             <div class="row g-3">
                                 @foreach (['Live View', 'Playback', 'Event', 'Access', 'Video Wall', 'People Counting', 'Log', 'Devices', 'Device CFG', 'Event Config', 'Tour & Task', 'User', 'System Config', 'Heat Map'] as $permission)
                                 <div class="col-md-4">
                                     <div class="form-check form-switch">
                                         <input class="form-check-input" type="checkbox" role="switch" id="perm_{{ Str::slug($permission) }}" checked>
                                         <label class="form-check-label" for="perm_{{ Str::slug($permission) }}">{{ $permission }}</label>
                                     </div>
                                 </div>
                                 @endforeach
                             </div>
                         </div>
                         <div class="tab-pane fade" id="channel-rights" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-3 fw-semibold">Permissions</h6>
                                    @foreach (['Preview', 'Playback', 'Export', 'PTZ', 'E-focus'] as $right)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="right_{{ Str::slug($right) }}" checked>
                                            <label class="form-check-label" for="right_{{ Str::slug($right) }}">{{ $right }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-8">
                                    <h6 class="mb-3 fw-semibold">Apply to Devices</h6>
                                     <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text bg-dark text-white border-secondary"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control bg-dark text-white border-secondary" placeholder="Search device group...">
                                    </div>
                                    <div class="border border-secondary rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="group_default">
                                            <label class="form-check-label" for="group_default">Default Group</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                     </div>
                 </div>
                 <div class="card-footer bg-secondary text-end">
                     <button class="btn btn-primary fw-semibold"><i class="fas fa-save me-2"></i>Save Changes</button>
                 </div>
             </div>
        </div>
    </div>
</div>

</div>

<style>
    :root {
        --primary-color: #0d6efd;
    }

    .bg-dark-subtle {
        background-color: #2c3034;
    }

    .border-secondary {
        border-color: #495057 !important;
    }

    .nav-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        position: relative;
    }

    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-item.active {
        background-color: rgba(13, 110, 253, 0.15);
    }

    .active-indicator {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }
    
    .list-group-item-action.bg-dark:hover {
        background-color: #343a40 !important;
    }

    .nav-tabs-dark .nav-link {
        color: #adb5bd;
        border-color: transparent;
        border-bottom-color: #495057;
    }
    .nav-tabs-dark .nav-link:hover {
        border-color: #495057;
        isolation: isolate;
    }
    .nav-tabs-dark .nav-link.active {
        color: #fff;
        background-color: #343a40;
        border-color: #495057 #495057 #343a40;
        font-weight: 600;
    }
</style>
@endsection