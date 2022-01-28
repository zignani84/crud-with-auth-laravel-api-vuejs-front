export default function authHeader() {
    let user = JSON.parse(localStorage.getItem('user'));
  
    if (user && user.access_token) {
      console.log('AUTH HEADER user token:');
      console.log(user);
      return { Authorization: 'Bearer ' + user.access_token };
    } else {
      return {};
    }
  }