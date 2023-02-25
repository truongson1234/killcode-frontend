<template>
  <button class="btn-darkmode" @click="toggleDark()">
    Chế độ: {{ isDark ? "Tối" : "Sáng" }}
  </button>
</template>

<script setup>
import { ref } from "vue";
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
