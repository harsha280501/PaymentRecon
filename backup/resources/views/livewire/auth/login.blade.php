<section x-data="{ 
    email: '', 
    password: '', 
    remember: true, 
    hasClicked: false,

    emailError: '',
    passwordError: '',

    validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },

    // validate all the inputs
    validate() {

        this.emailError = '' 
        this.passwordError = ''

        if(this.email == '') {
            this.emailError = 'The Email Address cannot be empty';
        }


        if(!this.validateEmail(this.email)) {
            this.emailError = 'Please enter a valid email address';
        }

        if(this.password == '') {
            this.passwordError = 'The password field is required.';
        }

        if(this.emailError != '' || this.passwordError != '') {
            return false
        }

        return true;
    }

}" class="ftco-section" style="background: url('assets/images/bg.jpg');" x-init="() => {
    Livewire.on('reset:login', () => {
        console.log('reset:login');
        hasClicked = false
    })
}">
    <x-spinner.spinner />
    <div class="container" style="max-height: 90vh;">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-8">
                <div x-data="{ open: false }" class="wrap d-md-flex">
                    <div class="img" style="background-image: url('assets/images/login-bg-blue.png');"></div>
                    <div class="login-wrap p-4 p-md-5">
                        <div class="login-header">
                            <div class="brand mb-3">
                                <b class="text-red">Login to your account</b><br>
                                <small>Don't have access ?</small> <a @click="open = true" href="javascript:;">Contact support</a>
                            </div>
                            <div class="icon"></div>
                        </div>
                        @if(session()->has('reset:password')) <div class="text-success">{{ session('reset:password') }}</div> @endif

                        @error('error') <div class="error">{{ $message }}</div> @enderror
                        <form x-on:submit.prevent="() => {

                            if(!validate()) {
                                return false;
                            }

                            hasClicked = true
                            $wire.authenticate({ email, password, remember })
                        }" class="signin-form">
                            <div class="form-group mb-4">
                                <input x-model="email" type="email" class="form-control" placeholder="Email Address">
                                <div x-text="emailError" class="error"></div>

                            </div>
                            <div class="form-group mb-4">
                                <input x-model="password" type="password" class="form-control" placeholder="Password">
                                <div x-text="passwordError" class="error"></div>
                            </div>
                            <center>
                                <div class="m-t-20 mb-4 text-inverse ">
                                    <a href="{{ url('/') }}/forgot-password">Forgot Password?</a>
                                </div>
                            </center>
                            {{-- <template x-bind:style=""> --}}
                            <div x-bind:style="{ 'opacity': hasClicked ? '0.5' : '1', 'pointer-events': hasClicked ? 'none' : 'auto' }" class="login-buttons">
                                <button type="submit" class="btn btn-secondary btn-block btn-lg">Login with email</button>
                            </div>
                            {{-- </template> --}}
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
