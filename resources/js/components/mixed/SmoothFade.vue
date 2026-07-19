<!-- components/transitions/SmoothFade.vue -->
<template>
  <transition name="smooth-fade" mode="out-in">
    <slot />
  </transition>
</template>

<style scoped>
.smooth-fade-enter-active,
.smooth-fade-leave-active {
  transition: all 0.9s cubic-bezier(0.4, 0, 0.2, 1);
}

.smooth-fade-enter-from,
.smooth-fade-leave-to {
  opacity: 0;
  transform: scale(0.78);
}
</style>