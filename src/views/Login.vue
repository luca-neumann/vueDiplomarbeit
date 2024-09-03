<script setup>
</script>

<template>
 <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
            <form>
                <div class="mb-4">
                    <label for="email" class="block mb-2">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" />
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-2">Password</label>
                    <input type="password" id="password" class="w-full px-4 py-2 border border-green-500 rounded" />
                </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800">Login</button>
        </form>
    </div>
</div>
</template>