<template>
    <div class="app">
        <navbar/>
        <div class="main">
            <slot></slot>
        </div>
    </div>
</template>
<script>
import Navbar from "../components/Navbar.vue";
export default {
    components: {
        Navbar,
    },
}
</script>
<style scoped>
    .app{
        height: 100vh;
        margin: 0;
        background-color: #f2f2f2;
    }
    .main {
        width: 90%;
        margin: auto;
    }
</style>