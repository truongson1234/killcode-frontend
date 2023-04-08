import { ref, computed } from "vue";
import { useTagStore } from "@/stores/tag.js";
export const tagStore = useTagStore();
export const currentPage = ref(1);
export const pageTag = ref(1);
export const itemsPerPage = ref(5);
export const indexStartTag = ref(""),
    indexEndTag = ref("");
export const checkValiAddTag = ref({
    name: false,
    slug: false,
});
export const checkValiEditTag = ref({
    name: false,
    slug: false,
});
export const formAddTag = ref({
    name: "",
    slug: "",
});
export const formEditTag = ref({
    id: "",
    name: "",
    slug: "",
});
export const sortKey = ref(''), sortOrder = ref(1)
export const deleteTag = (item, id) => {
    Swal.fire({
        title: "",
        text: `Bạn có chắc muốn xóa thẻ "${item.name}" ?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await tagStore
                .handleDeleteTag(id)
                .then((res) => {
                    if (tagStore.dataTagErrors == "success!") {
                        const index = tagStore.dataTags.indexOf(item);
                        if (index || index == 0) {
                            tagStore.dataTags.splice(index, 1);
                        }
                    }
                })
                .catch((err) => {});
        }
    });
};
export const addTag = async (form) => {
    if (formAddTag.value.name != "") {
        checkValiAddTag.value.name = false;
    }else {
        checkValiAddTag.value.name = true;

    }
    if (formAddTag.value.slug != "") {
        checkValiAddTag.value.slug = false;
    }else {
        checkValiAddTag.value.slug = true;

    }
    if(formAddTag.value.name == "" || formAddTag.value.slug == "") return false
    await tagStore
        .handleAddTag(form)
        .then((res) => {
            if(tagStore.dataTagErrors != 'success!') {
                Swal.fire({
                    title: "",
                    text: `${tagStore.dataTagErrors}`,
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Đóng",
                });
            }
        })
        .catch((err) => {
            console.log(err);
        });
};
export const editTag = async(id, form) => {
    await tagStore.handleEditTag(id, form)
    .then(res => {
        if(tagStore.dataTagErrors == 'success!') {
            console.log('update-success')
        }else {
            Swal.fire({
                title: "",
                text: `${tagStore.dataTagErrors}`,
                icon: "warning",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Đóng",
            });
        }
    })
}
export const onPageChanged = (page) => {
    currentPage.value = page;
};
export const valiEmptyInput = (name_condition, value) => {
    if (value == "") {
        if (name_condition == "name") checkValiAddTag.value.name = true;
        if (name_condition == "slug") checkValiAddTag.value.slug = true;
        if (name_condition == "name-edit") checkValiEditTag.value.name = true;
        if (name_condition == "slug-edit") checkValiEditTag.value.slug = true;
    } else {
        if (name_condition == "name") checkValiAddTag.value.name = false;
        if (name_condition == "slug") checkValiAddTag.value.slug = false;
        if (name_condition == "name-edit") checkValiEditTag.value.name = false;
        if (name_condition == "slug-edit") checkValiEditTag.value.slug = false;
    }
};
export const showModalEditTag = (item, id, name, slug) => {
    $('#modal-edit-tag').removeClass('hidden')
    formEditTag.value.id = id
    formEditTag.value.name = name
    formEditTag.value.slug = slug
}
export const closeModalEditTag = () => {
    $('#modal-edit-tag').addClass('hidden')
}
export const sortTable = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value * -1;
    } else {
        sortKey.value = key;
        sortOrder.value = 1;
    }
}
export const sortIcon = (column) => {
    if (sortKey.value === column) {
        return sortOrder.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
    }
    return 'bx bxs-sort-alt';
}
export const listTags = computed(() => {
    if (tagStore.dataTags !== null && typeof tagStore.dataTags !== 'undefined') {
        return tagStore.dataTags.sort((a, b) => {
            let modifier = sortOrder.value === 1 ? 1 : -1;
            if (a[sortKey.value] < b[sortKey.value]) {
                return -1 * modifier;
            }
            if (a[sortKey.value] > b[sortKey.value]) {
                return 1 * modifier;
            }
            if (a[sortKey.value] === null && b[sortKey.value] === null) {
                return 0;
            }
            if (a[sortKey.value] === null) {
                return modifier * 1;
            }
            if (b[sortKey.value] === null) {
                return modifier * -1;
            }
            return 0;
        });
    }
});
export const totalPagesTag = computed(() => {
    if (tagStore.dataTags != null) {
        return Math.ceil(tagStore.dataTags.length / itemsPerPage.value);
    }
});
export const displayedItemsTag = computed(() => {
    if (tagStore.dataTags != null) {
        var startIndex = (currentPage.value - 1) * itemsPerPage.value;
        var endIndex = startIndex + itemsPerPage.value;
        if (endIndex > tagStore.dataTags.length) {
            endIndex = tagStore.dataTags.length;
        }
        indexStartTag.value = startIndex + 1;
        indexEndTag.value = endIndex;
        return tagStore.dataTags.slice(startIndex, endIndex);
    }
});
