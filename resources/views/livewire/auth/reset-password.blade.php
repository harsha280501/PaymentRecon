<section class="ftco-section" style="background: url('../assets/images/bg.jpg');">
    <x-spinner.spinner />
    <div class="container" style="height: 60.5vh">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-8">
                <div x-data="{ open: false }" class="wrap d-md-flex">
                    <div class="img" style="background-image: url('../assets/images/login-bg-blue.png');"></div>
                    <div class="login-wrap p-4 p-md-5">
                        <div class="login-header">
                            <div class="brand mb-1">
                                <b class="text-red">Reset Password?</b><br>
                            </div>
                            <div class="icon"></div>
                        </div>
                        <form wire:submit.prevent="resetpassword">
                            <input type="hidden" wire:model="token">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" wire:model.defer="password" placeholder="*******">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="text" class="form-control" id="password_confirmation" wire:model.defer="password_confirmation" placeholder="your password here!">
                            </div>
                            <div x-bind:style="{ 'opacity': hasClicked ? '0.5' : '1', 'pointer-events': hasClicked ? 'none' : 'auto' }" class="login-buttons">
                                <button type="submit" class="btn btn-secondary btn-block btn-lg">Reset Password</button>
                            </div>
                            <div class="text-inverse text-center mt-1">
                                <a href="{{ url('/') }}">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
