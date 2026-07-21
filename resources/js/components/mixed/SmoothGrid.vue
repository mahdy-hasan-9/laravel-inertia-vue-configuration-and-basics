<!-- components/transitions/SmoothGrid.vue -->
<script setup>
defineProps({
  tag: {
    type: String,
    default: 'div'
  }
})
</script>

<template>
  <TransitionGroup :tag="tag" name="smooth-grid">
    <slot />
  </TransitionGroup>
</template>

<style scoped>
.smooth-grid-enter-active,
.smooth-grid-leave-active {
  transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.smooth-grid-enter-from,
.smooth-grid-leave-to {
  opacity: 0;
  transform: translateY(30px) scale(0.96);
}

/* পজিশন চেঞ্জ হওয়ার মুভমেন্ট স্পিডও সেম থাকবে */
.smooth-grid-move {
  transition: transform 0.9s cubic-bezier(0.4, 0, 0.2, 1);
}

:deep(.smooth-grid-leave-active) {
  position: absolute !important;
  visibility: hidden;
}
</style>