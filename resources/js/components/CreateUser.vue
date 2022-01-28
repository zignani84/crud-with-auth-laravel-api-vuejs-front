<template>
  <div class="col-md-12">
    <div class="card card-container">
        <h3 class="text-center">Criar Usuário</h3>
      <form name="form" @submit.prevent="handleRegister">
        <div v-if="!successful">
          <div class="form-group">
            <label for="name">Nome</label>
            <input
              v-model="name"
              v-validate="'required|min:3|max:20'"
              type="text"
              class="form-control"
              name="name"
            />
            <div
              v-if="submitted && errors.has('name')"
              class="alert-danger"
            >{{errors.first('name')}}</div>
          </div>
          <div class="form-group">
            <label for="email">E-mail</label>
            <input
              v-model="email"
              v-validate="'required|email|max:50'"
              type="email"
              class="form-control"
              name="email"
            />
            <div
              v-if="submitted && errors.has('email')"
              class="alert-danger"
            >{{errors.first('email')}}</div>
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input
              v-model="password"
              v-validate="'required|min:6|max:40'"
              type="password"
              class="form-control"
              name="password"
              ref="password"
            />
            <div
              v-if="submitted && errors.has('password')"
              class="alert-danger"
            >{{errors.first('password')}}</div>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirme a Senha</label>
            <input
              v-model="password_confirmation"
              v-validate="'required|confirmed:password|min:6|max:40'"
              type="password"
              class="form-control"
              name="password_confirmation"
              data-vv-as="password"
            />
            <div
              v-if="submitted && errors.has('password_confirmation')"
              class="alert-danger"
            >{{errors.first('password_confirmation')}}</div>
          </div>
            <div class="form-group">
                <label for="avatar">Avatar</label>
                <input type="file" @change='upload_avatar' :class="{ 'is-invalid': errors.has('avatar') }" name="avatar">
                <div class="avatar img-fluid img-circle" style="margin-top:10px">
                    <img id="profile-img" class="profile-img-card" :src="get_avatar()" v-bind:style="styleObject"/>
                </div>
                <div
                v-if="submitted && errors.has('avatar')"
                class="alert-danger"
                >{{errors.first('avatar')}}</div>
            </div>
          <div class="form-group">
            <button class="btn btn-primary btn-block">Criar</button>
          </div>
        </div>
      </form>

      <div
        v-if="message"
        class="alert"
        :class="successful ? 'alert-success' : 'alert-danger'"
      >{{message}}</div>
    </div>
  </div>
</template>

<script>
import UserService from '../services/user.service';
export default {
  name: 'Create',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      avatar: '',
      submitted: false,
      successful: false,
      message: '',
        styleObject: {
            width: '100px',
            height: '100px'
        }
    };
  },
  methods: {
    handleRegister() {
      this.message = '';
      this.submitted = true;

        let data = new FormData();
        data.append('name', this.name);
        data.append('email', this.email);
        data.append('password', this.password);
        data.append('password_confirmation', this.password_confirmation);
        data.append('avatar', this.avatar);

        console.log(data);

      this.$validator.validate().then(isValid => {
        if (isValid) {
            UserService.addUserBoard(data).then(response => {
                this.message = response.data.message;
                this.successful = true;
            })
            .catch(err=> {
                console.log(err)
                this.message =
                (err.response && err.response.data && err.response.data.message) ||
                err.message ||
                err.toString();
                this.successful = false;
            })
            .finally(()=> this.loadin=false)
        }
      });
    },
    upload_avatar(e){
        let file = e.target.files[0];
        let reader = new FileReader();  

        if(file['size'] < 2111775)
        {
            reader.onloadend = (file) => {
                //console.log('RESULT', reader.result)
                this.avatar = reader.result;
            }              
            reader.readAsDataURL(file);
        }else{
            alert('O arquivo não pode ser maior do que 2 MB')
        }
    },
    get_avatar(){
        let photo = (this.avatar.length > 100) ? this.avatar : "img/profile/"+ this.avatar;
        if (!this.avatar)
            photo = '//ssl.gstatic.com/accounts/ui/avatar_2x.png';
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