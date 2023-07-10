<template>
    <div class="navbar">
        <div class="container">
            <div class="nav">
                <div>
                    <b>Atlas</b>Task
                </div>
                <div class="buttons">
                    <div class="email">
                        <i class="fas fa-envelope"></i>
                        {{ user?.email }}
                    </div>
                    <button @click="logout" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></button>
                    <button @click="showModal" title="Delete the account"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    <Modal :isOpen="isModalOpen" @close="closeModal">
        <h2 style="margin: 10px 0px;">Delete Account</h2>
        <p style="margin-bottom: 10px">Type your email to delete <b v-text="user?.email"></b></p>
        <input v-model="email" type="text" placeholder="Insert your email"/>
        <button style="background-color: red; color: white; border-radius: 5px; padding: 10px 20px" @click="deleteAccount">Delete</button>
    </Modal>
</template>
<script>
import { mapGetters } from 'vuex'
import Modal from "../components/Modal.vue";

export default {
    name: 'Navbar',
    components: {
        Modal,
    },
    data() {
        return {
            isModalOpen: false,
            email: ''
        };
    },
    computed: {
        ...mapGetters({
            user: 'auth/getUser',
        })
    },
    methods: {
        logout: function () {
            this.$store.dispatch('auth/logout').then(() => {
                this.$router.push({path: '/login', replace: true});
            });
        },
        showModal: function(){
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        deleteAccount() {
            if(this.email != this.user.email){
                alert("Please insert your email adress");
                return;
            }
            this.$store.dispatch('auth/delete').then(() => {
                this.$router.push({path: '/login', replace: true});
            });
        },
    }
}
</script>
<style scoped>
    .navbar {
        background-color: #998FC7;
        color: #F9F5FF;
        margin-bottom: 20px;
    }
    
    .container {
        width: 90%;
        margin: auto;
        padding: 15px 0px;
    }

    .nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .buttons {
        display: flex;
        align-items: center;
    }

    .buttons button {
        background: none;
        border: none;
        color: #F9F5FF;
        cursor: pointer;
        font-size: 14px;
        text-transform: uppercase;
        transition: color 0.3s;
        padding: 5px;
        border-radius: 3px;
    }

    .buttons button:hover {
        color: #28262C;
    }

    .email {
        color: #F9F5FF;
        font-size: 14px;
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .email i {
        margin-right: 5px;
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
        margin-bottom: 10px;
    }
</style>