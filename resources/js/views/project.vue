<template>
    <AuthLayout>
        <h2>Video editing timeline</h2>
        <button @click="addLayer" class="btn-layer">Add new layer</button>
        <div class="card">
            <div style="display: flex; height: 40px; border-bottom: solid 1px #D4C2FC">

                <div class="layers">
                    <div></div>
                </div>
                <div class="timelines">
                </div>
            </div>
            <div v-for="layer in layers" :key="layer" style="display: flex; height: 60px; border-bottom: solid 1px #D4C2FC">
                <div class="layers">
                    <div v-text="'Layer ' + layer" class="layer"></div>
                </div>
                <div class="timelines">
                    <Vue3DraggableResizable :parent="true" :handles="['ml','mr']" :disabledY="true" class="timeline" :minW="20" :w="100" >
                    </Vue3DraggableResizable>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
<script lang="ts">

import { defineComponent } from "vue";
import Vue3DraggableResizable from 'vue3-draggable-resizable'
import AuthLayout from "../layouts/Auth.vue";

export default defineComponent({
    components: {
        AuthLayout,
        Vue3DraggableResizable
    },
    data(){
        return {
            //ticks: Array.from({ length: 101 }, (_, i) => i),
            layers: [] as number[],
            timelineWidth: 100,
            isResizing: false,
        }
    },
    computed: {
        timelineStyle() {
            return {
                width: `${this.timelineWidth}px`,
            };
        },
    },
    methods: {
        addLayer: function(): void{
            let id = this.layers.length + 1;
            this.layers.push(id);
        }, 
        onResize(width) {
            this.timelineWidth = width;
        },
    }
});
</script>
<style scoped>
.card {
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #FCFCFC;
    max-height: 600px;
    height: 600px;
    overflow-y: scroll;
}

h2 {
    text-align: left;
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
}

.btn-layer {
    background-color: #998FC7;
    border: none;
    color: white;
    transition: color 0.3s;
    margin-bottom: 10px;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.btn-layer:hover {
    background-color: #D4C2FC;
}

.layers {
    width: 20%;
    border-right: 1px solid #D4C2FC;
    padding: 10px;
}

.layer {
    background-color: #14248A;
    padding: 10px 20px;
    border-radius: 5px;
    color: white;
    margin-bottom: 10px;
}

.timelines {
    width: 80%;
    padding: 10px 20px;
    margin-bottom: 10px;
}

.timeline {
    position: relative;
    background-color: #D4C2FC;
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 10px;
    height: 40px;
}

.btn-timeline {
    position: absolute;
    left: 90%;
    background-color: #998FC7;
    padding: 5px;
    color: white;
    outline: none;
    border: none;
    border-radius: 5px;
}

/*.ruler {
  width: 100%;
  height: 80px;
  background-color: #f2f2f2;
  position: relative;
  font-family: Arial, sans-serif;
  font-size: 12px;
}

.tickss {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.ticks {
  position: absolute;
  top: 0px;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.tick {
  width: 1px;
  height: 10px;
  background-color: #000;
  position: relative;
}

.big-tick {
  height: 20px;
}

.labels {
  position: absolute;
  top: -40px;
  bottom: 0;
  left: 10px;
  right: 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.tick-label {
  white-space: nowrap;
}*/
</style>