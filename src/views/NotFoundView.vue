<template>
    <div class="flex flex-col items-center justify-center h-screen">
        <h1 class="text-4xl font-bold mb-4">404</h1>
        <p class="text-lg text-gray-600">Page Not Found</p>
        <a href="/" class="mt-4 text-blue-500 hover:underline">Go back to home</a>
    </div>
</template>

<style>
    .flex {
        display: flex;
    }
    .flex-col {
        flex-direction: column;
    }
    .items-center {
        align-items: center;
    }
    .justify-center {
        justify-content: center;
    }
    .h-screen {
        height: 100vh;
    }
    .text-4xl {
        font-size: 2.25rem;
    }
    .font-bold {
        font-weight: 700;
    }
    .mb-4 {
        margin-bottom: 1rem;
    }
    .text-lg {
        font-size: 1.125rem;
    }
    .text-gray-600 {
        color: #718096;
    }
    .mt-4 {
        margin-top: 1rem;
    }
    .text-blue-500 {
        color: #4299e1;
    }
    .hover\:underline:hover {
        text-decoration: underline;
    }
</style>