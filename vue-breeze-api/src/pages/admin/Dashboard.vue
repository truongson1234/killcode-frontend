<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
var ctx1 = ref(null),
    gradientStroke1 = ref(null);
const statistical = ref({});


onMounted(() => {
    fetchData();

    ctx1.value = document.getElementById("chart-line").getContext("2d");
    gradientStroke1.value = ctx1.value.createLinearGradient(0, 230, 0, 50);
    gradientStroke1.value.addColorStop(1, "rgba(94, 114, 228, 0.2)");
    gradientStroke1.value.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
    gradientStroke1.value.addColorStop(0, "rgba(94, 114, 228, 0)");
    new Chart(ctx1.value, {
        type: "line",
        data: {
            labels: [
                "Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12",
            ],
            datasets: [
                {
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1.value,
                    borderWidth: 3,
                    fill: true,
                    data: statistical.value.chart,
                    maxBarThickness: 6,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
            interaction: {
                intersect: false,
                mode: "index",
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: "#fbfbfb",
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: "normal",
                            lineHeight: 2,
                        },
                    },
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5],
                    },
                    ticks: {
                        display: true,
                        color: "#ccc",
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: "normal",
                            lineHeight: 2,
                        },
                    },
                },
            },
        },
    });
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
        var options = {
            damping: "0.5",
        };
        Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
});

const fetchData = () => {
    axios
        .get("/api/dashboard/statistical")
        .then((response) => {
            statistical.value = response.data;
            console.log(statistical);
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
<template>
    <div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p
                                        class="text-sm mb-0 text-uppercase font-weight-bold"
                                    >
                                        Tương tác
                                    </p>
                                    <h5 class="font-weight-bolder">{{ statistical.total_interactions }}</h5>
                                    <!-- <p class="mb-0">
                                        <span
                                            class="text-success text-sm font-weight-bolder">+55%</span>
                                        since yesterday
                                    </p> -->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle"
                                >
                                    <i
                                        class="bx bx-donate-heart text-lg opacity-10"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p
                                        class="text-sm mb-0 text-uppercase font-weight-bold"
                                    >
                                        Bài viết
                                    </p>
                                    <h5 class="font-weight-bolder">{{ statistical.total_posts }}</h5>
                                    <!-- <p class="mb-0">
                                        <span
                                            class="text-success text-sm font-weight-bolder">+3%</span>
                                        since last week
                                    </p> -->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle"
                                >
                                    <i
                                        class="bx bx-book text-lg opacity-10"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p
                                        class="text-sm mb-0 text-uppercase font-weight-bold"
                                    >
                                        Câu hỏi
                                    </p>
                                    <h5 class="font-weight-bolder">{{ statistical.total_questions }}</h5>
                                    <!-- <p class="mb-0">
                                        <span
                                            class="text-danger text-sm font-weight-bolder">-2%</span>
                                        since last quarter
                                    </p> -->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle"
                                >
                                    <i
                                        class="bx bx-question-mark text-lg opacity-10"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p
                                        class="text-sm mb-0 text-uppercase font-weight-bold"
                                    >
                                        Thẻ
                                    </p>
                                    <h5 class="font-weight-bolder">{{ statistical.total_tags }}</h5>
                                    <!-- <p class="mb-0">
                                        <span
                                            class="text-success text-sm font-weight-bolder">+5%</span>
                                        than last month
                                    </p> -->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle"
                                >
                                    <i
                                        class="bx bx-purchase-tag-alt text-lg opacity-10"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Tổng quan</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold">4% hơn</span> trong
                            tháng 3 năm 2021
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas
                                id="chart-line"
                                class="chart-canvas"
                                height="300"
                            ></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div
                        id="carouselExampleCaptions"
                        class="carousel slide h-100"
                        data-bs-ride="carousel"
                    >
                        <div class="carousel-inner border-radius-lg h-100">
                            <div
                                class="carousel-item carousel-item-1 h-100 active"
                            >
                                <div
                                    class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5"
                                >
                                    <div
                                        class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3"
                                    >
                                        <i
                                            class="ni ni-camera-compact text-dark opacity-10"
                                        ></i>
                                    </div>
                                    <h5 class="text-white mb-1">
                                        Get started with Argon
                                    </h5>
                                    <p>
                                        There’s nothing I really wanted to do in
                                        life that I wasn’t able to get good at.
                                    </p>
                                </div>
                            </div>
                            <div class="carousel-item carousel-item-2 h-100">
                                <div
                                    class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5"
                                >
                                    <div
                                        class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3"
                                    >
                                        <i
                                            class="ni ni-bulb-61 text-dark opacity-10"
                                        ></i>
                                    </div>
                                    <h5 class="text-white mb-1">
                                        Faster way to create web pages
                                    </h5>
                                    <p>
                                        That’s my skill. I’m not really
                                        specifically talented at anything except
                                        for the ability to learn.
                                    </p>
                                </div>
                            </div>
                            <div class="carousel-item carousel-item-3 h-100">
                                <div
                                    class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5"
                                >
                                    <div
                                        class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3"
                                    >
                                        <i
                                            class="ni ni-trophy text-dark opacity-10"
                                        ></i>
                                    </div>
                                    <h5 class="text-white mb-1">
                                        Share with us your design tips!
                                    </h5>
                                    <p>
                                        Don’t be afraid to be wrong because you
                                        can’t learn anything from a compliment.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button
                            class="carousel-control-prev w-5 me-3"
                            type="button"
                            data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev"
                        >
                            <span
                                class="carousel-control-prev-icon"
                                aria-hidden="true"
                            ></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button
                            class="carousel-control-next w-5 me-3"
                            type="button"
                            data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next"
                        >
                            <span
                                class="carousel-control-next-icon"
                                aria-hidden="true"
                            ></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Thẻ</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <tbody>
                                <tr v-for="tag in statistical.tags" :key="tag.id">
                                    <td class="w-30">
                                        <div
                                            class="d-flex px-2 py-1 align-items-center"
                                        >
                                            <div class="ms-4">
                                                <p
                                                    class="text-xs font-weight-bold mb-0"
                                                >
                                                    Tên:
                                                </p>
                                                <h6 class="text-sm mb-0">{{ tag.name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p
                                                class="text-xs font-weight-bold mb-0"
                                            >
                                                Bài viết:
                                            </p>
                                            <h6 class="text-sm mb-0">{{ tag.total_posts }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p
                                                class="text-xs font-weight-bold mb-0"
                                            >
                                                Câu hỏi:
                                            </p>
                                            <h6 class="text-sm mb-0">{{ tag.total_questions }}</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p
                                                class="text-xs font-weight-bold mb-0"
                                            >
                                                Theo dõi:
                                            </p>
                                            <h6 class="text-sm mb-0">{{ tag.total_followers }}</h6>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Danh mục</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li
                                v-for="category in statistical.categorys"
                                :key="category.id"
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg"
                            >
                                <div class="d-flex align-items-center">
                                    <div
                                        class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center"
                                    >
                                        <i
                                            v-html="category.icon"
                                        ></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">
                                            {{ category.name }}
                                        </h6>
                                        <span class="text-xs"
                                            >250 in stock,
                                            <span class="font-weight-bold"
                                                >{{ category.total }} sold</span
                                            ></span
                                        >
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"
                                    >
                                        <i
                                            class="ni ni-bold-right"
                                            aria-hidden="true"
                                        ></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.carousel-item-1 {
    background-image: url("@/assets/admin/img/carousel-1.jpg");
    background-size: cover;
}

.carousel-item-2 {
    background-image: url("@/assets/admin/img/carousel-2.jpg");
    background-size: cover;
}

.carousel-item-3 {
    background-image: url("@/assets/admin/img/carousel-3.jpg");
    background-size: cover;
}
</style>
