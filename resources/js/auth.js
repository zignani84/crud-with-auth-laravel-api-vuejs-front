import {router} from './app.js';
import { API_BASE_URL } from './config'

export default {
    check() {
        let token = localStorage.getItem('id_token')
        if (token !== null) {
            Vue.http.get(
                'api/user?token=' + token,
            ).then(response => {
                this.user.authenticated = true
                this.user.profile = response.data.data
            })
        }
    },
    register(user) {
        this.axios.post(
            API_BASE_URL + 'auth/register', 
            {
                name: user.name,
                email: user.email,
                password: user.password
            }
        ).then(response => (
            this.$router.push({name: 'home'})
        ))
        .catch(err=> console.log(err))
        .finally(()=> this.loadin=false);
    },
    signin(user) {
        this.axios.post(
            API_BASE_URL + 'auth/login', 
            {
                email: user.email,
                password: user.password
            }
        ).then(response => {
            if (response.data.accessToken) {
                localStorage.setItem('user', JSON.stringify(response.data));
            }
    
            console.log(response.data)
            this.$router.push({name: 'dashboard'})
        })
        .catch(err=> console.log(err))
        .finally(()=> this.loadin=false);
    },
    signout() {
        localStorage.removeItem('id_token')

        router.push({
            name: 'home'
        })
    }
}