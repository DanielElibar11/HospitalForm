@extends('layouts.app', ['activePage' => 'user-management', 'menuParent' => 'laravel', 'titlePage' => __('User Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __('Users') }}</h4>
              </div>
              <div class="card-body">
                @can('create', App\User::class)
                  <div class="row">
                    <div class="col-12 text-right mb-3">
                      <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                    </div>
                  </div>
                @endcan
                <div class="table-responsive m-0 h-100 overflow-hidden" id="users-table">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover" style="display:none">
                    <thead class="text-primary">
                      <th>
                          {{ __('Photo') }}
                      </th>
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Email') }}
                      </th>
                      <th>
                        {{ __('Role') }}
                      </th>
                      <th>
                        {{ __('Creation date') }}
                      </th>
                      @can('manage-users', App\User::class)
                        <th class="text-right">
                          {{ __('Actions') }}
                        </th>
                      @endcan
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                        <tr>
                          <td>
                            <div class="avatar avatar-sm rounded-circle img-circle" style="width:100px; height:100px;overflow: hidden;">
                                <img src="{{ $user->profilePicture() }}" alt="" style="max-width: 100px;">
                            </div>
                          </td>
                          <td>
                            {{ $user->name }}
                          </td>
                          <td>
                            {{ $user->email }}
                          </td>
                          <td>
                            {{ $user->role->name }}
                          </td>
                          <td>
                            {{ $user->created_at->format('Y-m-d') }}
                          </td>
                          @can('manage-users', App\User::class)
                            <td class="td-actions text-right">
                                @if ($user->id != auth()->id())
                                <form action="{{ route('user.destroy', $user) }}" method="post">
                                      @csrf
                                      @method('delete')

                                      @can('update', $user)
                                        <a href="{{ route('user.edit', $user) }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                      @endcan
                                      @can('delete', $user)
                                        <button type="button" class="btn btn-link btn-danger btn-icon btn-sm remove" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                          <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                      @endcan
                                  </form>
                              @else
                                @can('update', $user)
                                  <a href="{{ route('user.edit', $user) }}" class="btn btn-link btn-warning btn-icon btn-sm edit"><i class="tim-icons icon-pencil"></i></a>
                                @endcan
                              @endif
                            </td>
                          @endcan
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      $('#datatables').fadeIn(1100);
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search users",
        },
        "columnDefs": [
          { "orderable": false, "targets": 6 },
        ],
      });
    });
  </script>
@endpush
