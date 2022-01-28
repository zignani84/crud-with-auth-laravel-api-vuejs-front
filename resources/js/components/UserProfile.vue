<template>
    <div class="col-md-12">
        <div class="card card-container">
          <header class="jumbotron">
            <h3>
              <strong>{{currentUser.user.name}}</strong> Profile
            </h3>
          </header>
          <div class="avatar img-fluid img-circle" style="margin-top:10px">
              <img id="profile-img" class="profile-img-card" :src="get_avatar()" v-bind:style="styleObject"/>
          </div>
          <p>
            <strong>Token:</strong>
            {{currentUser.access_token.substring(0, 20)}} ... {{currentUser.access_token.substr(currentUser.access_token.length - 20)}}
          </p>
          <p>
            <strong>Id:</strong>
            {{currentUser.user.id}}
          </p>
          <p>
            <strong>E-mail:</strong>
            {{currentUser.user.email}}
          </p>
        </div>
    </div>
</template>

<script>
export default {
  name: 'Profile',
  data(){
      return{
          styleObject: {
              width: '100px',
              height: '100px'
          }
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
  methods: {
    get_avatar(){
        let photo = '';
        if (!this.currentUser.user.avatar){
          photo = '//ssl.gstatic.com/accounts/ui/avatar_2x.png';
        }else{
          photo = (this.currentUser.user.avatar.length > 100) ? this.currentUser.user.avatar : "/img/profile/"+ this.currentUser.user.avatar;
        }
        return photo;
    },
  }
};
</script>

<style scoped>
label {
  display: block;
  margin-top: 10px;
}
.card-container.card {
  max-width: 350px !important;
  padding: 40px 40px;
}
.card {
  background-color: #f7f7f7;
  padding: 20px 25px 30px;
  margin: 0 auto 25px;
  margin-top: 50px;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.profile-img-card {
  width: 96px;
  height: 96px;
  margin: 0 auto 10px;
  display: block;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;
}
</style>