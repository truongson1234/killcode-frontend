<template>
    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="login-modal__content modal-content">
                <div class="login-modal__header modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="login-modal__body modal-body pb-4 px-3">
                    <!-- nav-tabs -->
                    <ul class="login-modal__nav nav nav-tabs" id="myTab" role="tablist">
                        <li class="login-modal__nav-item nav-item" role="presentation">
                            <button class="login-modal__nav-link nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="home" aria-selected="true">
                                Đăng nhập
                            </button>
                        </li>
                        <li class="login-modal__nav-item nav-item" role="presentation">
                            <button class="login-modal__nav-link nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">
                                Đăng kí
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content pt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <!-- form-login -->
                            <form @submit.prevent="handleLogin" class="login-form">
                                <div class="mb-3">
                                    <label for="" class="login-form__label form-label">Email</label>
                                    <input type="email" name="" class="login-form__input form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="login-form__label form-label">Mật khẩu</label>
                                    <input type="password" name="" class="login-form__input form-control">
                                </div>
                                <button type="submit" class="login-form__btn btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <!-- form-register -->
                            <form @submit.prevent="handleRegister" class="login-form">
                                <div class="mb-3">
                                    <label for="" class="login-form__label form-label">Email</label>
                                    <input type="email" name="" class="login-form__input form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="login-form__label form-label">Mật khẩu</label>
                                    <input type="password" name="" class="login-form__input form-control">
                                </div>
                                <button type="submit" class="login-form__btn btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const handleLogin = () => {
    console.log('form-login');
}
const handleRegister = () => {
    console.log('form-register');
}
</script>

<style scoped>
.login-modal__content{
    background: var(--color-light-mode);
    border-radius: 4px;
}
.login-modal__header{
    border-bottom: none;
}
/* .login-modal__nav */
.login-modal__nav-item{
    width: 50%;
}
.login-modal__nav-link{
    color: var(--color-dark-mode);
    width: 100%;
    border-radius: 4px;
}
.login-modal__nav-link.active{
    color: var(--color-light-mode);
    background: var(--color-dark-mode);
}
.login-modal__body{
    
}

/* login-form */
.login-form{
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.login-form__btn,
.login-form__btn:active
{
    padding: 10px 20px;
    color: var(--color-light-mode);
    background: var(--color-dark-mode);
    border-radius: 4px;
    border: none !important;
    outline: none !important;
}
</style>