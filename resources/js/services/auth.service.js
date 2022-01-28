import axios from 'axios';

const API_URL = 'http://localhost:8000/api/auth/';

class AuthService {
  async login(user) {
    return axios
      .post(API_URL + 'login', {
        email: user.email,
        password: user.password
      })
      .then(response => {
        console.log('AUTH SERVICE login response:');
        console.log(response);
        console.log('AUTH SERVICE login response data:');
        console.log(response.data);
        console.log('AUTH SERVICE login response data access_token:');
        console.log(response.data.access_token);
        if (response.data.access_token) {
          localStorage.setItem('user', JSON.stringify(response.data));
          console.log('AUTH SERVICE login localStorage user:');
          console.log(localStorage.getItem('user'));
        }

        return response.data;
      });
  }

  logout() {
    localStorage.removeItem('user');
  }

  register(user) {
    return axios.post(API_URL + 'register', {
      name: user.name,
      email: user.email,
      password: user.password,
      password_confirmation: user.password_confirmation
    });
  }
}

export default new AuthService();