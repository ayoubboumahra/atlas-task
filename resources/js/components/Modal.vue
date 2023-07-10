<template>
    <transition name="modal">
        <div class="modal-overlay" v-if="isOpen" @click="close">
            <div class="modal-container" @click.stop>
                <div class="modal-content">
                    <slot></slot>
                </div>
            </div>
        </div>
    </transition>
</template>
  
<script>

export default {
    props: {
        isOpen: {
            type: Boolean,
            required: true,
        },
    },
    methods: {
        close() {
            this.$emit('close');
        },
    },
};
</script>
  
<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    width: 500px;
}
</style>