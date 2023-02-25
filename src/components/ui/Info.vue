<template>
    <div class="text-center card-box">
    <div class="member-card pt-2 pb-2">
        <div class="thumb-lg member-thumb mx-auto">
        <img
            src="https://bootdey.com/img/Content/avatar/avatar2.png"
            class="rounded-circle img-thumbnail"
            alt="profile-image"
        />
        </div>
        <div class="">
        <h4>Freddie J. Plourde</h4>
        <p class="text-muted">
            @Founder <span>| </span
            ><span><a href="#" class="text-pink">websitename.com</a></span>
        </p>
        </div>
        <ul class="social-links list-inline">
        <li class="list-inline-item">
            <a
            title=""
            data-placement="top"
            data-toggle="tooltip"
            class="tooltips"
            href=""
            data-original-title="Facebook"
            ><i class="fa fa-facebook"></i
            ></a>
        </li>
        <li class="list-inline-item">
            <a
            title=""
            data-placement="top"
            data-toggle="tooltip"
            class="tooltips"
            href=""
            data-original-title="Twitter"
            ><i class="fa fa-twitter"></i
            ></a>
        </li>
        <li class="list-inline-item">
            <a
            title=""
            data-placement="top"
            data-toggle="tooltip"
            class="tooltips"
            href=""
            data-original-title="Skype"
            ><i class="fa fa-skype"></i
            ></a>
        </li>
        </ul>
        <button
        type="button"
        class="btn btn-primary mt-3 btn-rounded waves-effect w-md waves-light"
        >
        Message Now
        </button>
        <div class="mt-4">
        <div class="row">
            <div class="col-4">
            <div class="mt-3">
                <h4>2563</h4>
                <p class="mb-0 text-muted">Wallets Balance</p>
            </div>
            </div>
            <div class="col-4">
            <div class="mt-3">
                <h4>6952</h4>
                <p class="mb-0 text-muted">Income amounts</p>
            </div>
            </div>
            <div class="col-4">
            <div class="mt-3">
                <h4>1125</h4>
                <p class="mb-0 text-muted">Total Transactions</p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</template>

<script setup></script>

<style>
.card-box {
    padding: 20px;
    border-radius: 3px;
    margin-bottom: 30px;
    background-color: var(--color-light-mode);
}

.social-links li a {
    border-radius: 50%;
    color: rgba(121, 121, 121, .8);
    display: inline-block;
    height: 30px;
    line-height: 27px;
    border: 2px solid rgba(121, 121, 121, .5);
    text-align: center;
    width: 30px
}

.social-links li a:hover {
    color: #797979;
    border: 2px solid #797979
}
.thumb-lg {
    height: 88px;
    width: 88px;
}
.img-thumbnail {
    padding: .25rem;
    background-color: var(--color-light-mode);
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    max-width: 100%;
    height: auto;
}
.text-pink {
    color: #ff679b!important;
}
.btn-rounded {
    border-radius: 2em;
}
.text-muted {
    color: #98a6ad!important;
}
h4 {
    line-height: 22px;
    font-size: 18px;
}
</style>
