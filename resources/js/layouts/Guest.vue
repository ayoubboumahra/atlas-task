<template>
    <div class="main">
        <slot></slot>
    </div>
</template>
<style scoped>
    .main{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f2f2f2;
    }
</style>