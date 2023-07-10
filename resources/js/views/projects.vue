<template>
    <AuthLayout>
        <div class="card">
            <h2>Projects</h2>
            <div class="button">
                <button @click="showModal"><i class="fas fa-plus"></i> Add Project</button>
            </div>
            <ul class="project-list">
                <li v-for="project in projects" :key="project.id">
                    <span class="title" v-text="project.name"></span>
                    <span class="date">Created: {{ project.created_at }}</span>
                    <router-link :to="{name: 'project', params: {id: project.id}}" class="show-btn"><i class="fas fa-eye"></i></router-link>
                    <button class="delete-btn" @click="showDeleteModal(project)"><i class="fas fa-trash"></i></button>
                </li>
            </ul>
        </div>
        <Modal :isOpen="isModalOpen" @close="closeModal">
            <h2 style="margin: 10px 0px;">Create new project</h2>
            <form @submit.prevent="store">
                <div class="form-group">
                  <input v-model="name" type="text" placeholder="Insert a name"/>
                  <p class="errors" v-if="errors && errors['name']" v-text="errors['name'][0]"></p>
                </div>
                <button type="submit" style="background-color: #998FC7; color: white; border-radius: 5px; padding: 10px 20px">Create</button>
            </form>
        </Modal>
        <Modal :isOpen="isModalDeleteOpen" @close="closeDeleteModal">
            <h2 style="margin: 10px 0px;">Delete Project</h2>
            <p style="margin-bottom: 10px">Type your project name to delete it,  <b v-text="current.name"></b></p>
            <form @submit.prevent="deleteProject">
              <div class="form-group">
                <input v-model="project_name" type="text" placeholder="Project name"/>
                <p class="errors" v-if="delete_errors" v-text="delete_errors"></p>
              </div>
              <button type="submit" style="background-color: red; color: white; border-radius: 5px; padding: 10px 20px">Delete</button>
            </form>
        </Modal>
    </AuthLayout>
</template>
<script lang="ts">

import { defineComponent } from "vue";
import { mapGetters } from 'vuex';
import AuthLayout from "../layouts/Auth.vue";
import Modal from "../components/Modal.vue";
import ProjectInterface from "../interfaces/ProjectInterface";

export default defineComponent({
    components: {
        AuthLayout,
        Modal
    },
    mounted() {
      this.$store.dispatch('projects/list');
    },
    data(){
        return {
            title: 'My Projects' as string,
            isModalOpen: false as boolean,
            isModalDeleteOpen: false as boolean,
            name: '' as string,
            current: null as ProjectInterface | null,
            project_name: '' as string,
            delete_errors: '' as string
        }
    },
    computed: {
      ...mapGetters({
        projects: 'projects/getProjects',
        errors: 'projects/getErrors',
      })
    },
    methods: {
      showModal: function(): void{
          this.isModalOpen = true;
      },
      closeModal: function(): void {
        this.isModalOpen = false;
        this.$store.commit('projects/SET_ERRORS', null);
      },
      store: function(): void {
        this.$store.dispatch('projects/store', { name: this.name })
          .then(() => {
            if ( !this.errors ){
              this.isModalOpen = false;
              this.name = "";
            }
          });
      },
      showDeleteModal: function(data:ProjectInterface): void {
        this.current = data;
        this.isModalDeleteOpen = true;
      },
      closeDeleteModal: function(): void {
        this.isModalDeleteOpen = false;
        this.delete_errors = "";
        this.project_name = "";
      },
      deleteProject: function(): void{
        if(this.project_name != this.current.name){
          this.delete_errors = "Sorry, please enter the text exactly as displayed to confirm";
          return;
        }
        this.$store.dispatch('projects/delete', this.current.id).then(() => {
          this.current = null;
          this.delete_errors = "";
          this.project_name = '';
          this.isModalDeleteOpen = false;
        });
      }
    }
});
</script>
<style scoped>

  .card {
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #FCFCFC;
  }

  .card h2 {
    text-align: left;
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
  }

  .card .button {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .card .button button {
    background: none;
    border: none;
    color: #5D576B;
    cursor: pointer;
    font-size: 16px;
    text-transform: uppercase;
    transition: color 0.3s;
  }

  .card .button button:hover {
    color: #998FC7;
  }

  .card .project-list {
    list-style: none;
    padding: 0;
  }

  .card .project-list li {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
  }

  .card .project-list li .title {
    font-weight: bold;
    margin-right: 10px;
    flex: 1;
  }

  .card .project-list li .date {
    color: #999;
    flex: 1;
  }

  .card .project-list li .delete-btn {
    background: none;
    border: none;
    color: #F7567C;
    cursor: pointer;
    transition: color 0.3s;
  }

  .card .project-list li .show-btn {
    background: none;
    border: none;
    color: #14248A;
    cursor: pointer;
    transition: color 0.3s;
  }

  .card .project-list li .delete-btn:hover {
    color: #998FC7;
  }

  .modal-content input[type="text"]{
    width: 100%;
    padding: 10px;
    border: none;
    border-bottom: 2px solid #D4C2FC;
    background-color: #FFFAE3;
    font-size: 14px;
    transition: border-bottom-color 0.3s ease;
    color: #5D576B;
  }

  .modal-content .errors {
    font-weight: bold;
    color: red;
    font-size: 12px;
    margin-top: 5px
  }
  .modal-content .form-group {
    margin-bottom: 10px;
  }
</style>