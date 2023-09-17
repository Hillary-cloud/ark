<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-xl text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row gx-4">
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        {{-- <h5 class="card-title font-weight-bold">Update Profile Information</h5> --}}
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        {{-- <h5 class="card-title font-weight-bold">Change Password</h5> --}}
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Uncomment this section for delete user form -->
            {{-- 
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">Delete User</h5>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            --}}
        </div>
    </div>
</x-app-layout>
