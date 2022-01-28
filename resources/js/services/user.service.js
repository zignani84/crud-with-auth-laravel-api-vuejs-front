import axios from 'axios';
import authHeader from './auth-header';

const API_URL = 'http://localhost:8000/api/';

class UserService {
  getPublicContent() {
    return axios.get(API_URL + 'all');
  }

  getUserBoard() {
    return axios.get(API_URL + 'users', { headers: authHeader() });
  }

  deleteUserBoard(id) {
    return axios.delete(API_URL + 'users/' + id, { headers: authHeader() });
  }

  addUserBoard(data) {
    return axios.post(API_URL + 'users/create', data, { headers: authHeader() });
  }

  editUserBoard(id) {
    return axios.get(API_URL + 'users/' + id, { headers: authHeader() });
  }

  updateUserBoard(id, data) {
    console.log(data);
    return axios.patch(API_URL + 'users/' + id, data, { headers: authHeader() });
  }

  updateUploadUserBoard(id, data) {
    console.log(data);
    return axios.post(API_URL + 'users/' + id, data, { headers: authHeader(), 'content-type': 'multipart/form-data' });
  }

  getModeratorBoard() {
    return axios.get(API_URL + 'mod', { headers: authHeader() });
  }

  getAdminBoard() {
    return axios.get(API_URL + 'admin', { headers: authHeader() });
  }
}

export default new UserService();