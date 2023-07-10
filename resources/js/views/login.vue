<template>
    <GuestLayout>
        <div class="card">
            <h2><i class="fas fa-sign-in-alt"></i><span v-text="title"></span></h2>
            <form @submit.prevent="loginAttemps">
                <div class="form-group">
                    <i class="fa-solid fa-at"></i>
                    <input v-model="email" type="text" placeholder="Email Adress">
                    <p class="errors" v-if="errors && errors['email']" v-text="errors['email'][0]"></p>
                </div>
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input v-model="password" type="password" placeholder="Password">
                    <p class="errors" v-if="errors && errors['password']" v-text="errors['password'][0]"></p>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </GuestLayout>
</template>
<script lang="ts">

import { defineComponent } from 'vue';
import { mapGetters } from 'vuex';
import GuestLayout from "../layouts/Guest.vue";

export default defineComponent({
    components: {
        GuestLayout,
    },
    data(){
        return {
            title: 'Sign In' as string,
            email: 'user@gmail.com' as string,
            password: 'user' as string
        }
    },
    computed: {
        ...mapGetters({
            errors: 'auth/getErrors',
            authenticated: 'auth/getAuthenticated'
        }),
    },
    methods: {
        loginAttemps: function(): void {
            this.$store.dispatch('auth/login', { email: this.email, password: this.password })
            .then(() => {
                if ( this.authenticated ) {
                    this.$router.push('/');
                } 
            });
        }
    }
});
</script>
<style scoped>

.card {
    width: 400px;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #FCFCFC;
}

.card h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #998FC7;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card h2 i {
    margin-right: 10px;
}

.card .form-group {
    margin-bottom: 20px;
}

.card input[type="text"],
.card input[type="password"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-bottom: 2px solid #D4C2FC;
    background-color: #FFFAE3;
    font-size: 14px;
    transition: border-bottom-color 0.3s ease;
    padding-left: 40px;
    color: #5D576B;
}

.card input[type="text"]::placeholder,
.card input[type="password"]::placeholder {
  color: #5D576B;
}

.card input[type="text"]:focus,
.card input[type="password"]:focus {
    border-bottom-color: #998FC7;
    outline: none;
}

.card .errors {
    font-weight: bold;
    color: red;
    font-size: 12px;
    margin-top: 5px
}

.card button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    background-color: #D4C2FC;
    color: #FCFCFC;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.card button:hover {
    background-color: #998FC7;
}

.card .fa-at,
.card .fa-lock {
    position: absolute;
    margin-top: 12px;
    margin-left: 10px;
    color: #28262C;
}
</style>