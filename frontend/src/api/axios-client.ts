import axios from "axios";

const axiosClient = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest", // This header can help with CSRF issues
  },
  withCredentials: true, // This is important for handling cookies, including CSRF tokens
});

// Interceptor to handle 419 errors
axiosClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 419) {
      // Redirect to login page or refresh CSRF token
      console.error("Session expired. Please log in again.");
      // You might want to redirect to login page here
      // window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export default axiosClient;
