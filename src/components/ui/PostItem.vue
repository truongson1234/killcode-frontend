<template>
    <div class="col-12 col-md-4 pb-3">
        <main class="l-card p-3">
            <section class="l-card__text">
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, doloribus?
                </p>
            </section>
            <section class="l-card__user">
                <div class="l-card__userImage">
                    <img src="https://scontent.fhan4-2.fna.fbcdn.net/v/t1.6435-9/149299062_232989691790324_2796829381264086336_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=xSgUwUshPDIAX_YWlPi&_nc_ht=scontent.fhan4-2.fna&oh=00_AfATcRKgKC6HOtrIudxtwXaQj0z7TlcyK_SPiDv43zMjSA&oe=6421D58C" alt="logo-user">
                </div>
                <div class="l-card__userInfo">
                    <span>Sonng Ngu</span>
                    <span>Lorem, ipsum dolor.</span>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>

</script>

<style scoped>
.l-card {
	background: var(--color-light-mode);
	color: var(--color-dark-mode);
    border-radius: 10px;
	box-shadow: 0px 7px 24px rgba(100, 100, 100, 0.4);
}

.l-card__text p {
	font-size: 24px;
	font-family: "Vollkorn", serif;
	font-weight: 400;
	color: var(--color-dark-mode);
	text-align: left;
}

.l-card__text p::after {
	content: "\201D";
	display: inline;
	color: #999;
}

.l-card__text p::before {
	content: "\201C";
	display: inline;
	color: #999;
}

.l-card__user {
	display: flex;
	flex-direction: row;
	/* border-top: 1px solid #c1c1c1; */
	align-items: center;
}
.l-card__userImage {
	width: 42px;
	height: 42px;
	overflow: hidden;
	border-radius: 50%;
}

.l-card__userInfo {
	display: flex;
	flex-direction: column;
	margin-left: 16px;
}

.l-card__userInfo span:nth-child(1) {
	font-weight: bold;
	font-family: sans-serif;
	font-size: 14px;
	color: #3f3f55;
}
.l-card__userInfo span:nth-child(2) {
	color: #adada6;
	font-family: sans-serif;
	font-size: 12px;
	margin-top: 2px;
}

</style>