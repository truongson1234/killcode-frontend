<template>
    <div>
        <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
            <ul class="flex flex-wrap -mb-px" id="myTab"
                data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button
                        class="item-tab inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center  border-b-2 dark:text-gray-400 dark:hover:text-gray-300 "
                        id="post-tab" data-tabs-target="#post" type="button"
                        role="tab" aria-controls="post" aria-selected="true">Bài
                        viết</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="item-tab inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center  border-b-2 dark:text-gray-400 dark:hover:text-gray-300"
                        id="question-tab" data-tabs-target="#question"
                        type="button" role="tab" aria-controls="question"
                        aria-selected="false">Câu hỏi</button>
                </li>
            </ul>
        </div>
    </div>
</template>