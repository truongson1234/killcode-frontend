<template>
    <div class="wrapper container">
        <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900">
            <div class="flex justify-between px-4 mx-auto max-w-screen-xl">
                <article
                    class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert"
                >
                    <header class="mb-4 lg:mb-6 not-format">
                        <address class="flex items-center mb-6 not-italic">
                            <div
                                class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"
                            >
                                <img
                                    class="mr-4 w-16 h-16 rounded-full"
                                    :src="author.avatar"
                                    alt="Jese Leos"
                                />
                                <div>
                                    <a
                                        href="#"
                                        rel="author"
                                        class="text-xl font-bold text-gray-900 dark:text-white"
                                        >{{ author.name }}</a
                                    >
                                    <p
                                        class="text-base font-light text-gray-500 dark:text-gray-400"
                                    >
                                        Graphic Designer, educator & CEO
                                        Flowbite
                                    </p>
                                    <p
                                        class="text-base font-light text-gray-500 dark:text-gray-400"
                                    >
                                        <time
                                            pubdate
                                            datetime="2022-02-08"
                                            title="February 8th, 2022"
                                            >{{ question.created_at }}</time
                                        >
                                    </p>
                                </div>
                            </div>
                        </address>
                        <h1
                            class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white"
                        >
                            {{ question.title }}
                        </h1>
                    </header>
                    <p class="lead mb-5">
                        {{ question.body }}
                    </p>
                    <section class="not-format">
                        <div class="flex justify-between items-center mb-6">
                            <h2
                                class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white"
                            >
                                Thảo luận (20)
                            </h2>
                        </div>

                        <form class="mb-6" @submit.prevent="sendAw(payload)">
                            <div
                                class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700"
                            >
                                <label for="comment" class="sr-only"
                                    >Your comment</label
                                >
                                <textarea
                                    id="comment"
                                    rows="6"
                                    class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                    placeholder="Write a comment..."
                                    required
                                    v-model="payload.content"
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                            >
                                Trả lời
                            </button>
                        </form>

                        <article
                            class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900"
                            v-for="answer in answers"
                            :key="answer.id"
                        >
                            <footer
                                class="flex justify-between items-center mb-2"
                            >
                                <div class="flex items-center">
                                    <p
                                        class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"
                                    >
                                        <img
                                            class="mr-2 w-6 h-6 rounded-full"
                                            :src="answer.person.avatar"
                                            alt="Michael Gough"
                                        />{{ answer.person.name }}
                                    </p>
                                    <p
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >
                                        <time
                                            pubdate
                                            datetime="2022-02-08"
                                            title="February 8th, 2022"
                                            >{{ answer.created_at }}</time
                                        >
                                    </p>
                                </div>
                                <!-- <button
                                    id="dropdownComment1Button"
                                    data-dropdown-toggle="dropdownComment1"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                    type="button"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                                        ></path>
                                    </svg>
                                    <span class="sr-only"
                                        >Comment settings</span
                                    >
                                </button> -->
                                <!-- Dropdown menu -->
                                <!-- <div
                                    id="dropdownComment1"
                                    class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                                >
                                    <ul
                                        class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownMenuIconHorizontalButton"
                                    >
                                        <li>
                                            <a
                                                href="#"
                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                >Edit</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                href="#"
                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                >Remove</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                href="#"
                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                >Report</a
                                            >
                                        </li>
                                    </ul>
                                </div> -->
                            </footer>
                            <p>
                                {{ answer.content }}
                            </p>
                        </article>
                    </section>
                </article>
            </div>
        </main>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";

// lấy user_id
const authStore = useAuthStore();

const infoAuth = computed(() => {
    return authStore.getInfoUser;
});
// lấy post_id
const route = useRoute();
const questionId = route.params.id;

const data = () => ({
    pusher: null,
    channel: null,
});

const payload = ref({
    question_id: questionId,
    user_id: null,
    content: "",
});

const author = ref([]);
const question = ref([]);
const answers = ref([]);

const fetchData = () => {
    axios
        .get(`/api/questions/${questionId}`)
        .then((response) => {
            console.log(response);
            question.value = response.data.question;
            author.value = response.data.author;
            answers.value = response.data.answers;
            answers.value.reverse();
        })
        .catch((error) => {
            console.log(error);
        });
};

const sendAw = async (payload) => {
    if (payload.user_id && payload.content !== "") {
        await axios.post('/api/answers', payload)
        payload.content = ""
    } else {
        console.error("Lỗi");
    }
};

onMounted(async () => {
    await authStore.getToken();
    await authStore.getUser();

    // add user_id
    if (infoAuth.value) {
        payload.value.user_id = infoAuth.value.id;
    }

    await fetchData();

    // lắng nghe sự kiện
    data.pusher = new Pusher("100f9f72ec40accb9c52", {
        cluster: "ap1",
        encrypted: true,
    });

    data.channel = data.pusher.subscribe("chanel-answers");

    data.channel.bind(`event-answer-${questionId}`, (aw) => {
        answers.value.unshift(aw);
    });
});
</script>

<style scoped></style>
