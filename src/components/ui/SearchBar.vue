<template>
  <form class="search-bar">
    <input
      class="chosen-value"
      type="text"
      placeholder="Type to filter"
      v-model="chosenValue"
      @input="inputChange"
      @focus="onFocus"
      @blur="onBlur"
    />
    <ul class="value-list" ref="valueList">
      <li>Alabama</li>
      <li>Alaska</li>
      <li>Arizona</li>
      <li>Arkansas</li>
      <li>California</li>
      <li>Colorado</li>
      <li>Connecticut</li>
    </ul>
  </form>
</template>

<script setup>
import { ref } from "vue";

const chosenValue = ref('');
const valueList = ref(null);
const onFocus = () => {
    valueList.value.classList.add("open");
}
const onBlur = () => {
    valueList.value.classList.remove("open");
}
const inputChange = () => {
    let list = valueList.value.children;
    for (let i = 0; i < list.length; i++) {
        const el = list[i];
        const isFound = el.innerHTML.toLowerCase().includes(chosenValue.value);
        if (!isFound) {
            el.classList.add("closed")
        } else{
            el.classList.remove("closed")
        }
    }
}
</script>

<style scoped>
.search-bar {
  position: relative;
  margin-bottom: 4rem;
}

.chosen-value,
.value-list {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
}

.chosen-value {
  text-transform: uppercase;
  font-weight: 600;
  letter-spacing: 4px;
  height: 3rem;
  font-size: 1.1rem;
  padding: 1rem;
  background-color: #fafcfd;
  border: 3px solid transparent;
  transition: 0.3s ease-in-out;
}
.chosen-value::-webkit-input-placeholder {
  color: #333;
}
.chosen-value:hover {
  background-color: var(--color-dark-mode);
  cursor: pointer;
}
.chosen-value:hover::-webkit-input-placeholder {
  color: var(--color-light-mode);
}
.chosen-value:focus,
.chosen-value.open {
  box-shadow: 0px 5px 8px 0px rgba(0, 0, 0, 0.2);
  outline: 0;
  background-color: var(--color-dark-mode);
  color: var(--color-light-mode);
}
.chosen-value:focus::-webkit-input-placeholder,
.chosen-value.open::-webkit-input-placeholder {
  color: var(--color-light-mode);
}

.value-list {
  list-style: none;
  margin-top: 3rem;
  box-shadow: 0px 5px 8px 0px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  max-height: 0;
  transition: 0.3s ease-in-out;
}
.value-list.open {
  max-height: 200px;
  overflow: auto;
}
.value-list li {
  position: relative;
  height: 3rem;
  background-color: #fafcfd;
  padding: 1rem;
  font-size: 1.1rem;
  display: flex;
  align-items: center;
  cursor: pointer;
  transition: background-color 0.3s;
  opacity: 1;
}
.value-list li:hover {
    color: var(--color-light-mode);
  background-color: var(--color-dark-mode);
}
.value-list li.closed {
  max-height: 0;
  overflow: hidden;
  padding: 0;
  opacity: 0;
}
</style>
