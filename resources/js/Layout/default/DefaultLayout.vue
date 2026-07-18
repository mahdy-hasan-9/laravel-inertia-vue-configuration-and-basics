<template>
  <div class="min-h-screen bg-gray-100">
    <!-- ডায়নামিক হেডার মেনু -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- পেজ থেকে পাঠানো টাইটেল এখানে সরাসরি রেন্ডার হবে -->
        <h1 class="text-3xl font-bold text-gray-900">
          {{'Default Title' }}
        </h1>
      </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <slot /> <!-- এখানে পেজের মেইন কন্টেন্ট রেন্ডার হবে -->
    </main>
  </div>
</template>

<script setup>

</script>