import { ref } from "vue";

export function useDropdown() {
  const openIndex = ref<number | null>(null);

  function toggleDropdown(i: number) {
    openIndex.value = openIndex.value === i ? null : i;
  }

  function closeAll() {
    openIndex.value = null;
  }

  function isOpen(i: number) {
    return openIndex.value === i;
  }

  function ariaAttrs(i: number) {
    return {
      "aria-expanded": isOpen(i) ? "true" : "false",
      "aria-controls": `submenu-${i}`,
    };
  }

  return {
    openIndex,
    toggleDropdown,
    closeAll,
    isOpen,
    ariaAttrs,
  };
}
