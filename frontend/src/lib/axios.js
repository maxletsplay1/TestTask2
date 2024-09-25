import Axios from 'axios';

const BackendUrl = import.meta.env.VITE_BACKEND_URL;

const axios = Axios.create({
    baseURL: BackendUrl + 'api',
    withCredentials: true,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'multipart/form-data'
    }
});

export default axios;
