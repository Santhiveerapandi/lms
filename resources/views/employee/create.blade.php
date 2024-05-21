<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee Creation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if($message = Session::get('errors'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul>
                    @foreach($errors->all() as $error) 
                        <li>{{$error}}</li>
                    @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                    <div style="min-height: 5vh;" class="min-h-screen bg-gray-100 dark:bg-gray-900">
                        <main>
                        <form id="csvimportform" action="{{ route('admin.employee.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <input type="file" class="form-control" name="csvfile" id="csvfile" />
                            <x-primary-button class="ms-4 btn btn-primary btn-csvimport" name="submit" >
                                {{ __('Submit') }}
                            </x-primary-button>
                        </form>
                        </main>
                    </div>    
                
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>