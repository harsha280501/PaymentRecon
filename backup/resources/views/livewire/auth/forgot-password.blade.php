<section x-data="{ 
    email: '', 
    hasClicked: false,

    emailError: '',

    validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },

    // validate all the inputs
    validate() {

        this.emailError = '' 

        if(this.email == '') {
            this.emailError = 'The Email Address cannot be empty';
        }


        if(!this.validateEmail(this.email)) {
            this.emailError = 'Please enter a valid email address';
        }


        if(this.emailError != '') {
            return false
        }

        return true;
    }

}" class="ftco-section" style="background: url('assets/images/bg.jpg'); height: 100vh" x-init="() => {
    Livewire.on('reset:login', () => {
        console.log('reset:login');
        hasClicked = false
    })
}">

    <x-spinner.spinner />
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12 col-lg-8">
                <div x-data="{ open: false }" class="wrap d-md-flex">
                    <div class="img" style="background-image: url('assets/images/login-bg-blue.png');"></div>
                    <div class="login-wrap p-4 p-md-5">

                        <div class="login-header">
                            <div class="brand mb-3">
                                <b class="text-red">Forgot Password?</b><br>
                            </div>
                            <div class="icon"></div>
                        </div>

                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                        @error('error') <div class="error">{{ $message }}</div> @enderror
                        <form x-on:submit.prevent="() => {

                            if(!validate()) {
                                return false;
                            }

                            hasClicked = true
                            $wire.sendResetLink({ email })
                        }" class="signin-form" style="height: 100%">
                            {{-- <form wire:submit.prevent="sendResetLink"> --}}
                            <div class="form-group mb-4">
                                <input type="email" class="form-control" id="email" x-model="email" placeholder="youremail@example.com">
                                <div x-text="emailError" class="error"></div>
                            </div>

                            <div x-bind:style="{ 'opacity': hasClicked ? '0.5' : '1', 'pointer-events': hasClicked ? 'none' : 'auto' }" class="login-buttons">
                                <button type="submit" class="btn btn-secondary btn-block btn-lg">Send Reset Link</button>
                            </div>

                            <div class="m-t-20 mb-4 text-inverse text-center mt-3">
                                <a href="{{ url('/') }}">Back to Login</a>
                                <br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
