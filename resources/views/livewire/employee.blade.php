<div class="container">
    @if ($errors->any())
        <div class="pt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </ul>
        </div>
    @endif
    

    @if (session()->has('message'))
    <div class="pt-3">
    <div class="alert alert-success">
        {{ session('message') }}
        </div>
    </div>
    @endif
    <!-- START FORM -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form wire:submit.prevent="store">
            <!-- Name Input -->
            <form wire:submit.prevent="store">
                <!-- Name Input -->
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" wire:model="name" placeholder="Enter your name">
                    </div>
                </div>
            
                <!-- Email Input -->
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" wire:model="email" placeholder="Enter your email">
                    </div>
                </div>
            
                <!-- Address Input -->
                <div class="mb-3 row">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" wire:model="address" placeholder="Enter your address">
                    </div>
                </div>
            
                <!-- Submit Button -->
                <div class="mb-3 row">
                    <div class="col-sm-10 offset-sm-2">
                        @if ($updateData == false)
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        @else
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        @endif
                            <button type="submit" class="btn btn-secondary" wire:click="clear()">CLEAR</button>

                    </div>
                </div>
            </form>

    </div>

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data</h1>
        <div class="pb-3 pt-3">
            <input type="text" class="form-control mb-3 w-25" placeholder="Search..." wire:model.live="keywords">
        </div>

        @if ($employee_selected_id)
        <a wire:click="delete_confirmation('')" class="btn btn-danger btn-sm mb-3" data-bs-toggle="modal" 
            data-bs-target="#exampleModal">Del {{ count($employee_selected_id) }} data</a>
        @endif

        {{ $dataEmployees->links() }}
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4 sort @if($sortColumn=='name') {{$sortDirection}} @endif"
                     wire:click="sort('name')">Name</th>
                    <th class="col-md-3 sort @if($sortColumn=='name') {{$sortDirection}} @endif"
                     wire:click="sort('email')">Email</th>
                    <th class="col-md-2 sort @if($sortColumn=='name') {{$sortDirection}} @endif"
                     wire:click="sort('address')">Address</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataEmployees as $key => $value)

                <tr>
                    <td><input type="checkbox" wire:key="{{ $value->id }}" value="{{ $value->id }}" 
                            wire:model.live="employee_selected_id"> 
                    </td>
                    <td>{{ $dataEmployees->firstItem() + $key }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->email }}</td>
                    <td>{{ $value->address }}</td>
                    <td>
                        <a wire:click="edit({{ $value->id }})" class="btn btn-warning btn-sm">Edit</a>
                        <a wire:click="delete_confirmation({{ $value->id }})" class="btn btn-danger btn-sm"
                        data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataEmployees->links() }}
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Do you confirm to delete the selected data?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="delete()"
                data-bs-dismiss="modal">Save changes</button>
            </div>
          </div>
        </div>
      </div>
</div>