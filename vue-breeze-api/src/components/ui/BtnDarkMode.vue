<template>
  <button class="btn-darkmode flex items-center" @click="toggleDark()">
    <span v-if="isDark" class="pr-1.5"><i class='bx bxs-sun'></i></span>
    <span v-else class="pr-1.5"><i class='bx bxs-moon' ></i></span>
    Chế độ: {{ isDark ? "Sáng" : "Tối" }}
  </button>
</template>

<script setup>
import { ref,computed } from "vue";
import { useDark, useToggle } from "@vueuse/core";

const isDark = useDark({
  selector: "#app",
  attribute: "class",
  valueDark: "dark",
  valueLight: "",
});
const toggleDark = useToggle(isDark);
</script>

<style>
.btn-darkmode {
  width: 100%;
  height: 100%;
  padding: var(--bs-dropdown-item-padding-y) var(--bs-dropdown-item-padding-x);
  text-align: left;
  border: none;
  outline: none;
  background: transparent;
}
.btn-darkmode:hover {
  background: #e9ecef;
}

/* dark mode */

/* dark mode - navbar */
#app.dark{
  --color-dark-mode: #f1f2f6 !important;
  --color-light-mode: #16171d !important;
}

</style>
