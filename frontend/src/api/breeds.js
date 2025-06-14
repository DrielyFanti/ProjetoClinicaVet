import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});

export default {
  getAll() {
    return api.get('/breeds');
  },
  create(data) {
    return api.post('/breeds', data);
  },
  update(id, data) {
    return api.put(`/breeds/${id}`, data);
  },
  delete(id) {
    return api.delete(`/breeds/${id}`);
  },
};