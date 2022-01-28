<template>
    <div>
        <header class="jumbotron">
            <div
                v-if="content"
                class="alert"
                :class="successful ? 'alert-success' : 'alert-danger'"
            >{{content}}</div>
        </header>
        <h2 class="text-center">Lista Usuários</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-success" @click="editUser(user.id)">Editar</button>
                            <button class="btn btn-danger" @click="deleteUser(user.id)">Deletar</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import UserService from '../services/user.service';

    export default{
       data(){
          return{
            users:[],
            content: '',
            successful: false
          }
        },
        computed: {
            currentUser() {
                return this.$store.state.auth.user;
            }
        },
        mounted() {
            if (!this.currentUser) {
                this.$router.push('/login');
            }
        },
       created(){
            UserService.getUserBoard().then(
            response => {
                this.users = response.data;
            },
            error => {
                this.content =
                (error.response && error.response.data && error.response.data.message) ||
                error.message ||
                error.toString();
            }
            );
        },
       methods:{
           deleteUser(id){
                if(confirm("Você tem certeza que quer deletar este usuário?")){
                    UserService.deleteUserBoard(id).then(response =>{
                        let i=this.users.map(data=>data.id).indexOf(id);
                        this.users.splice(i, 1);
                        this.content = response.data.message;
                        this.successful = true;
                    },
                    error => {
                        this.content =
                        (error.response && error.response.data && error.response.data.message) ||
                        error.message ||
                        error.toString();
                        this.successful = false;
                    }
                    );
                }
            },
           editUser(id){
                this.$router.push('/users/' + id);
            }
        }
    } 
</script>